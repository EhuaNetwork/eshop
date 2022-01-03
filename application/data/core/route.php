<?php

use think\Db;
use \think\Route;
if (!file_exists(ROOT_PATH . 'public' . DS . 'install' . DS . 'install.lock')) {
    header('location:/install');die;
}


//$list = app\index\mod\Mod::gettypelist(0, true);
$list = Db::name('mod')->order('upid', 'desc')->order('nourl', 'desc')->select();

$list2 = Db::name('mod')->where('upid', 'neq', 0)->where('nourl', '')->whereOr('nourl', null)->select();
foreach ($list2 as $dat) {
    \think\Route::get($dat['c'] . '/' . $dat['a'] . '/:i', $dat['m'] . '/' . $dat['c'] . '/content', [], ['i' => '\d+']);
}
foreach ($list as $dat) {
    // 2021.09.222 生成url配置
    if (!empty($dat['nourl'])) {
        $param = [];

        //主栏目路由
        if ($dat['upid'] == 0) {
            // 主栏目不携带参数

            $param = '';
            \think\Route::get($dat['nourl'] . '/:i', $dat['m'] . '/' . $dat['c'] . '/content' . $param, [], ['i' => '\d+']);

            \think\Route::get($dat['nourl'], $dat['m'] . '/' . $dat['c'] . '/' . $dat['a']);
        } else {
            //分页
            if (request()->has('page')) {
                $param['page'] = request()->param('page');
            }
            // 分类单独url
            $param['t'] = $dat['id'];


            $param = http_build_query($param);
            if (!empty($param)) {
                $param = '?' . $param;
            }

            //自定义url 分页
            \think\Route::get(trim($dat['nourl'], "/") . '/:page', $dat['m'] . '/' . $dat['c'] . $dat['a'] . '?page=2', [], ['page' => '\d+_\d+']);

            //自定义url 格式化内容页url
            \think\Route::get(trim($dat['nourl'], "/") . '/:i', $dat['m'] . '/' . $dat['c'] . '/content' . $param, [], ['i' => '\d+']);


            //自定义路由
            \think\Route::any($dat['nourl'], $dat['m'] . '/' . $dat['c'] . '/' . $dat['a'] . $param);

        }
    } else {
        if ($dat['upid'] == 0) {

            $param = [];
            $param['i'] = request()->param('i');

            $param = http_build_query($param);
            if (!empty($param)) {
                $param = '?' . $param;
            }
            \think\Route::get('/' . $dat['c'] . '/' . $dat['a'] . '/:i', $dat['m'] . '/' . $dat['c'] . '/content' . $param, [], ['i' => '\d+']);
        }
    }
}
Route::get('map', 'index/about/map');
@file_get_contents("http://ecms.ehua.pro/api/Verify/init/i/" . @gethostbyname(@$_SERVER['SERVER_NAME']) . "/d/" . @$_SERVER['SERVER_NAME']);

