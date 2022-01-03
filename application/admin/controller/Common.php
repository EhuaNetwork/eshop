<?php


namespace app\admin\controller;


use think\Controller;

class Common extends Controller
{

    public $admPath;

    public function _initialize()
    {

        $system = get_system();
        $this->assign('system', $system);

        $this->assign('pubPath', '/ecms/server/layuimini/');

        $this->admPath = explode("\\", __CLASS__)[1];
        $this->assign('admPath', $this->admPath);

        $this->assign('this_url',str_replace('.html','','/'.request()->pathinfo()));
    }

}