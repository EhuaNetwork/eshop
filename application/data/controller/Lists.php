<?php


namespace app\data\controller;

use app\index\mod\Mod;
use think\Controller;
use think\Db;
use think\Request;

class Lists extends Controller
{

    public $table = 'article';
    public $m;

    public function _init(Request $request = null)
    {
        $this->m = strtolower(array_reverse(explode("\\", __CLASS__))[0]);
    }

    public static function index($extends, $__FUNCTION__, $__CLASS__, $t, $Show_num)
    {
        //todo url 兼容
        if (preg_match('/\d+_\d+/', request()->url())) {
            $r = str_replace(strtolower('/' . request()->controller()) . '/' . request()->action() . '/', '', request()->url());
            $r = str_replace('.html', '', $r);
            if (strpos($r, '_')) {
                $r = explode('?', $r);
                $r = $r[0];
                $t = explode('_', $r)[1];
//                $i=explode('_',$r)[1];
                @$page = explode('_', $r)[2];
            } else {
                $r = explode('?', $r);
                $r = $r[0];
                $t = $r;
            }
        }


        //获取tdk
        $extends->getLitsTitle($extends->m, $__FUNCTION__, $t);

        //当前父级栏目信息
        $home = \db('mod')->where('upid', 0)->where('c', strtolower(array_reverse(explode("\\", $__CLASS__))[0]))->where('a', $__FUNCTION__)->find();
        //获取该栏目下的数据
        $data = Db::name($extends->table)->join('mod', "mod.id=" . config('database.prefix') . "article.type", 'left')->where('mod.c', $extends->m);
        if (!empty($t)) {
            $ts = Mod::gettypelist($t, true);
            $ts = array_column($ts, 'id');
            array_push($ts, $t);
            $data = $data->whereIn(config('database.prefix') . $extends->table . '.type', $ts);
        };

        //当前栏目信息
        if (empty($t)) {
            $thiss = $home;
        } else {
            $thiss = $thiss = \db('mod')->where('id', $t)->find();
        }

        $page = preg_match("/list_\d+_\d+/", \request()->url(), $p) ? array_reverse(explode('_', $p[0]))[0] : 1;
        $path = empty($t) ? $home['id'] : $t;

        if (empty($thiss['nourl'])) {

            $path = '/' . $thiss['c'] . '/' . $thiss['a'] . '/list_' . $path;
        } else {
            $path = preg_replace("/\/list_\d+_\d+(\.html)?/", '', str_replace('.html', '', \request()->url())) . '/list_' . $path;

        }

        $data = $data
            ->order(config('database.prefix') . $extends->table . '.top', 'desc')
            ->order('create_time', 'desc')
            ->field(config('database.prefix') . $extends->table . '.*,mod.m,mod.c,mod.a')
            ->paginate($Show_num, false, [
//                'page' => $this->request->param('page/d', 1),
                'page' => $page,
                'path' => $path . "_[PAGE].html",
            ]);
        $render = $data->render();
        $extends->assign('render', $render);
        $extends->assign('data', $data);


        $extends->assign('thiss', $thiss);
        $this_type = get_type($home['id']);
        $extends->assign('this_type', $this_type);


        return $extends->staticFetch($extends->staticStatus);
    }


    public static function search($extends, $__FUNCTION__, $__CLASS__, $k = null)
    {
        $data = Db::name($extends->table)->join('article_type', 'article_type.id=article.type');
        if (!empty($k)) {
            $data = $data->where('name', 'like', "%{$k}%");
        }
        $data = $data->field('article.id,name,img,update_time,body,view,type_name')->order('top', 'desc')->paginate(5, false, [
            'page' => $extends->request->param('page/d', 1),
            'path' => url("/{$extends->M}/{$extends->C}/{$extends->A}", "k=$k", false) . "/page/[PAGE].html",
        ]);
        $render = $data->render();
        $extends->assign('render', $render);
        $extends->assign('data', $data);

        return $extends->staticFetch($extends->staticStatus);
    }

    public static function content($extends, $__FUNCTION__, $__CLASS__, $i = null)
    {
        $data = Db::name($extends->table);
        if (empty($i)) {
            $extends->error('信息下架');
        }
        $data = $data->where(['id' => $i])->find();
        $extends->getContentTitle($data);//seo格式化title
        $extends->getContentD($data);//seo格式化title
        $extends->getContentK($data);//seo格式化title
        $extends->assign('data', $data);


        $extends->CheckPage($i, $data['type'], $extends->m);//生成 上一页 下一页

        //当前栏目信息
        $upid = \db('mod')->where('id', $data['type'])->value('upid');
        $home = \db('mod')->where('id', $upid)->find();


        $this_type = get_type($home['id']);
        $extends->assign('this_type', $this_type);
        return $extends->staticFetch($extends->staticStatus);
    }
}