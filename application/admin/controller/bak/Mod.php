<?php


namespace app\admin\controller;

//栏目管理
use Cassandra\DefaultSchema;
use Ehua\Tool\Tool;
use think\Db;

class Mod extends Baseadmin
{


    public function index()
    {
//        $data = Db::name('mod');
//        if (!empty($t)) {
//            $data = $data->where('type', $t);
//        }
//        if (!empty($key)) {
//            $data = $data->where('name', 'like', "%{$key}%");
//        }
//        $data = $data->order('top', 'desc')->field('id,upid,name')->select();
//        $res = json_encode(_classify_category(0, $data), 256);
//
//        $res = preg_replace("/\"upid\":0,/", '', $res);
//        $res = preg_replace("/name/", 'title', $res);
//        $data = preg_replace("/,\"children\":\[\]/", '', $res);
//
//        $this->assign('data', $data);
//
//        return view();
        $types = Db::name('mod')->order('top', '')->field('id,upid,name,top')->select();
        function sort($data, $pid = 0, $level = 0)
        {
            static $arr = array();
            foreach ($data as $k => $v) {
                if ($v['upid'] == $pid) {
                    $v['level'] = $level;
                    $arr[] = $v;
                    sort($data, $v['id'], $level + 1);
                }
            }
            return $arr;
        }

        $type2 = sort($types);
        $this->assign('data', $type2);
        return view();
    }

    //旧版创建弹出页面
    public function create($i = 0)
    {
        $this->assign('i', $i);

        if (request()->isPost()) {
            $id = request()->param('i');
            $upid_all = Db::name('mod')->where('id', $id)->value('upid_all');
            $data = [
                'name' => request()->param('name'),
                'id' => request()->param('id'),
                't' => request()->param('t'),
                'd' => request()->param('d'),
                'k' => request()->param('k'),
                'nourl' => request()->param('nourl'),
                'm' => request()->param('m'),
                'c' => request()->param('c'),
                'a' => request()->param('a'),

                'type' => request()->param('type'),
                'upid' => request()->param('i'),
                'upid_all' => $upid_all . "[$id]",
                'body' => request()->param('body'),
                'top' => 0,
            ];
            //todo 增加自动创建文件功能

            if ($i == 0) {
                if ($data['type'] == 2) {//列表页

                    $file = APP_PATH . 'data' . DS . 'tpl' . DS . 'controller' . DS . 'Lists';
                    if (!is_file($file)) {
                        $this->error("模板文件不存在");
                    }
                    $f = file_get_contents($file);

                    $controller_file = APP_PATH . $data['m'] . DS . 'controller' . DS . ucfirst($data['c']) . '.php';
                    $view_index_file = APP_PATH . $data['m'] . DS . 'view' . DS . $data['c'] . DS . 'index.html';
                    $view_content_file = APP_PATH . $data['m'] . DS . 'view' . DS . $data['c'] . DS . 'content.html';
                    if (is_file($controller_file)) {
                        $this->error(ucfirst($data['c']) . " 栏目已存在");
                    } else {
                        Tool::dir_create(APP_PATH . $data['m'] . DS . 'view' . DS . $data['c'] . DS);
                        Tool::file_put_contents_ehua($controller_file, str_replace("class Class extends", "class " . ucfirst($data['c']) . " extends", $f));
                        Tool::file_put_contents_ehua($view_index_file, ' ');
                        Tool::file_put_contents_ehua($view_content_file, ' ');
                    }
                } else {//单页
                    $controller_file = APP_PATH . $data['m'] . DS . 'controller' . DS . ucfirst($data['c']) . '.php';
                    $view_index_file = APP_PATH . $data['m'] . DS . 'view' . DS . $data['c'] . DS . $data['a'] . '.html';


                    $file_c = APP_PATH . 'data' . DS . 'tpl' . DS . 'controller' . DS . 'Only_Class';
                    if (!is_file($file_c)) {
                        $this->error("模板文件不存在");
                    }


                    if (is_file($controller_file)) {//合并文件

                        //创建控制器文件
                        //获取文件数组1
                        $arr1 = Tool::file_to_array($controller_file);
                        array_pop($arr1);
                        foreach ($arr1 as $dat) {
                            if (preg_match("/public function " . $data['a'] . "\(\)/", $dat)) {
                                $this->error($data['a'] . " 方法已存在");
                            }
                        }
                        //获取文件数组2
                        $arr2 = Tool::file_to_array($file_c);
                        $arr2[0] = str_replace("FUNCTION", $data['a'], $arr2[0]);
                        //合并
                        $new_arr = array_merge($arr1, $arr2);
                        //追加
                        array_push($new_arr, '}');
                        //写入文件
                        $file = fopen($controller_file, 'w+');
                        fwrite($file, implode("", $new_arr));
                        fclose($file);

                        Tool::file_put_contents_ehua($view_index_file, ' ');

                    } else {//新建文件
                        $file_o = APP_PATH . 'data' . DS . 'tpl' . DS . 'controller' . DS . 'Only';
                        if (!is_file($file_o)) {
                            $this->error("模板文件不存在");
                        }

                        //创建控制器文件
                        $temp = file_get_contents($file_o);
                        $temp = str_replace('public function FUNCTION()', 'public function ' . $data['a'] . '()', $temp);
                        file_put_contents($controller_file, $temp);

                        Tool::file_put_contents_ehua($view_index_file, ' ');
                    }
                }

                if (Db::name('mod')->insert($data)) {
                    $this->success('操作成功');
                } else {
                    $this->error('操作失败');
                }
            } else {

                if (Db::name('mod')->insert($data)) {
                    echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
                } else {
                    echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
                }
            }


        } else {
            $c = Db::name('mod')->where('id', $i)->value('c');;
            $this->assign('c', $c);
            return view();
        }
    }

//    public function create2($i = 0)
//    {
//        $this->assign('i', $i);
//
//        if (request()->isPost()) {
//            $id = request()->param('i');
//            $upid_all = Db::name('mod')->where('id', $id)->find();
//            $data = [
//                'name' => '未命名',
//                'm' => 'index',
//                'c' => $upid_all['c'],
//                'a' => 'index',
//                'type' => 1,
//                'body' => request()->param('body'),
//                'upid' => request()->param('i'),
//                'upid_all' => $upid_all['upid_all'] . "[$id]",
//                'top' => 0,
//            ];
//            //todo 增加自动创建文件功能
////            $file=APP_PATH.$data['m'].'/controller/'.ucwords($data['c']).'.php';
////           if(is_file($file)){
////           }else{
////           }
//
//
//            if (Db::name('mod')->insert($data)) {
//                $this->success();
//            } else {
//                $this->error();
//
//            }
//        }
//
//        return view();
//    }

    public function edit_name()
    {
        if (request()->isPost()) {
            $id = request()->param('i');
            $name = request()->param('name');
            if (Db::name('mod')->where('id', $id)->update(['name' => $name])) {
                $this->success('ok');
            } else {
                $this->error('error');
            }
        }
    }

    public function edit_del()
    {
        if (request()->isPost()) {
            $id = request()->param('i');
            if (Db::name('mod')->where('id', $id)->delete()) {
                Db::name('article')->where('type', $id)->delete();
                $this->success('ok');
            } else {
                $this->error('error');
            }
        }
    }


    public function edit($i = 0)
    {
        $this->assign('i', $i);
        if (request()->isPost()) {
            $id = request()->param('i');

            $this_info = \db('mod')->where('id', $id)->find();
            $upid_all = \db('mod')->where('id', request()->param('upid'))->value('upid_all');

            $new_down_all = $upid_all . '[' . request()->param('upid') . ']';
            $re_down_all = $this_info['upid_all'] . '[' . $id . ']';
            $r = \db('mod')->where('upid_all', 'like', "%" . $re_down_all . "%")->select();
            foreach ($r as $y) {
                $y['upid_all'] = str_replace($this_info['upid_all'], $new_down_all, $y['upid_all']);
                \db('mod')->where('id', $y['id'])->update(['upid_all' => $y['upid_all']]);
            }
            $data = [
                'name' => request()->param('name'),
                'm' => request()->param('m'),
                'c' => request()->param('c'),
                'a' => request()->param('a'),
                't' => request()->param('t'),
                'd' => request()->param('d'),
                'upid' => request()->param('upid'),
                'upid_all' => $new_down_all,
                'k' => request()->param('k'),
                'nourl' => request()->param('nourl'),
                'type' => request()->param('type'),
                'body' => request()->param('body'),
                'top' => request()->param('top'),
            ];
//            $data = array_filter($data);
//            $file=APP_PATH.$data['m'].'/controller/'.ucwords($data['c']).'.php';
//           if(is_file($file)){
//           }else{
//           }


            if (Db::name('mod')->where('id', $id)->update($data)) {
                echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
            } else {
                echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
            }
        } else {


            $data = Db::name('mod')->where('id', $i)->find();
            $this->assign('data', $data);

            //todo 21.12.8更新
            $types = Db::name('mod')->order('top', '')->field('id,upid,name')->select();
            function sort($data, $pid = 0, $level = 0)
            {
                static $arr = array();
                foreach ($data as $k => $v) {
                    if ($v['upid'] == $pid) {
                        $v['level'] = $level;
                        $arr[] = $v;
                        sort($data, $v['id'], $level + 1);
                    }
                }
                return $arr;
            }

            $type2 = sort($types);
            $this->assign('type2', $type2);
            $this->assign('tt', $data['upid']);
            return view();
        }
    }


    public function settop($i = null, $t = null)
    {
        $arr = explode(',', $i);
        if (Db::name('mod')->whereIn('id', $arr)->update(['top' => $t])) {
            $this->success('设置完成');
        } else {
            $this->error('设置失败');
        }
    }
}