<?php

namespace app\admin\controller;

use think\Controller;

class Article extends Controller
{
    /**
     * 首页
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function store()
    {
        //获取分类数据
        $cateData = (new \app\common\model\Category())->getAll();
        $this->assign('cateData', $cateData);

        //获取标签数据
        $tagData = db('tag')->select();
        $this->assign('tagData', $tagData);
        return $this->fetch();
    }
}