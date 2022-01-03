<?php


namespace app\data\controller;


use think\Controller;

class Only extends Controller
{
    public static function index($extends, $__FUNCTION__, $__CLASS__)
    {
        $extends->getLitsTitle(strtolower(array_reverse(explode("\\", $__CLASS__))[0]), $__FUNCTION__);
        $data = self::get_data($__FUNCTION__, $__CLASS__);
        $extends->assign('data', $data);
        return $extends->staticFetch($extends->staticStatus);
    }

    private static function get_data($__FUNCTION__, $__CLASS__)
    {
        $home = \db('mod')->where('upid', 0)->where('c', strtolower(array_reverse(explode("\\", $__CLASS__))[0]))->where('a', $__FUNCTION__)->find();
        return $home;
    }



}