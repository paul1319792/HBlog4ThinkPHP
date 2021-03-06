<?php

namespace app\admin\controller;

use think\Controller;

class Tag extends Controller
{
    protected $db;

    protected function initialize()
    {
        parent::initialize();
        $this->db = new \app\common\model\Tag();
    }

    public function index()
    {
        //获取首页数据
        $field = db('tag')->paginate(5);
        $this->assign('field', $field);

        return $this->fetch();
    }

    //添加
    public function store()
    {
        if (request()->isPost()) {
            $res = $this->db->store(input('post.'));
            $validate = new \app\admin\validate\Tag;
            if (!$validate->check($res)) {
                $this->error($validate->getError());
                exit;
            } else {
                $Tag = new \app\common\model\Tag([
                    'tag_name' => $res['tag_name']
                ]);
                $Tag->save();
                $this->success('添加成功', 'index');
            }
        }
        return $this->fetch();

    }

    public function edit()
    {
        if (request()->isPost()) {
            $validate = new \app\admin\validate\Tag;
            $res = $this->db->edit(input('post.'));
            if (!$validate->check($res)) {
                $this->error($validate->getError());
                exit;
            } else {
                $cate = new \app\common\model\Tag();
                $cate->save([
                    'tag_name' => $res['tag_name']],
                    ['tag_id' => $res['tag_id']]);
                $this->success('修改成功', 'index');
            }
        }
        $tag_id = input('param.tag_id');
        $oldData = $this->db->find($tag_id);
        $this->assign('oldData', $oldData);
        return $this->fetch();
    }

    public function del()
    {
        $tag_id = input('get.tag_id');
        if (\app\common\model\Tag::destroy($tag_id)) {
            $this->success('删除成功', 'index');
            exit;
        } else {
            $this->error('删除失败');
            die;
        }
    }
}
