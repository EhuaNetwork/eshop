<?php


namespace app\admin\controller;

use think\Db;
use think\Exception;
use think\exception\ErrorException;
use think\exception\TemplateNotFoundException;

class Index extends Baseadmin
{
    public function index()
    {
        return view();
    }

    public function addparam()
    {
        if (request()->isPost()) {

            $key = request()->param('key');
            $as = request()->param('as');
            $value = request()->param('value');

            if (Db::name('system')->insert(['key' => $key, 'as' => $as, 'value' => $value])) {
                echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
            } else {
                echo "<script> var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);  </script> ";
            }


        } else {
            return view();
        }
    }

    public function seo()
    {
        $path1 = ROOT_PATH . 'application/data/tpl/index';
        if (!file_exists($path1)) {
            file_put_contents($path1, 'false');
            $Pststic = 'false';
        } else {
            $Pststic = file_get_contents($path1);
        }
        $path2 = ROOT_PATH . 'application/data/tpl/m';
        if (!file_exists($path2)) {
            file_put_contents($path2, 'false');
            $Mststic = 'false';
        } else {
            $Mststic = file_get_contents($path2);
        }

        $this->assign('Pststic', $Pststic);
        $this->assign('Mststic', $Mststic);
        return view();
    }

    public function Pseosave($status = null)
    {
        if (!in_array($status, ['false', 'true'])) {
            $this->error('信息不符 true false');
        }
        $path = ROOT_PATH . 'application/data/tpl/index';
        file_put_contents($path, $status);
        if ($status == 'false') {
            $this->deldir(ROOT_PATH . 'public/index/');
        }
        $this->success('修改成功');
    }

    public function Mseosave($status = null)
    {
        if (!in_array($status, ['false', 'true'])) {
            $this->error('信息不符 true false');
        }
        $path = ROOT_PATH . 'application/data/tpl/m';
        file_put_contents($path, $status);
        if ($status == 'false') {
            $this->deldir(ROOT_PATH . 'public/m/');
        }
        $this->success('修改成功');
    }

    //删除文件夹
    private function deldir($path)
    {
        try {
            if (is_dir($path)) {
                //扫描一个文件夹内的所有文件夹和文件并返回数组
                $p = scandir($path);
                foreach ($p as $val) {
                    //排除目录中的.和..
                    if ($val != "." && $val != "..") {
                        //如果是目录则递归子目录，继续操作
                        if (is_dir($path . $val)) {
                            //子目录中操作删除文件夹和文件
                            $this->deldir($path . $val . '/');
                            //目录清空后删除空文件夹
                            @rmdir($path . $val . '/');
                        } else {
                            //如果是文件直接删除
                            unlink($path . $val);
                        }
                    }
                }
            } else {
                unlink($path);
            }
            @rmdir($path);
        } catch (ErrorException $errorException) {
//            var_dump($errorException->getMessage());
            return false;
        }
    }

    public function controll()
    {
        return view();
    }

    public function Pdel()
    {

        $mod = \db('mod')->where('upid', 0)->order('upid_all', 'desc')->select();
        $this->deldir(ROOT_PATH . 'public' . DS . 'index.html');
        $this->deldir(ROOT_PATH . 'public/index/');

        foreach ($mod as $no) {
            if ($no['nourl'] != '/' && $no['nourl'] != '\\') {
                if ($no['nourl'] != '' && $no['nourl'] != null) {
                    $this->deldir(ROOT_PATH . 'public' . DS . $no['nourl']);
                } else {
                    $this->deldir(ROOT_PATH . 'public' . DS . $no['c'] . DS);
                }
            }
        }
        $this->success('更新成功', $this->admPath . '/index/seo');

    }


    function file_put_contents_ehua($path, $body)
    {
        $path = explode(DS, $path);
        $temp = array_pop($path);
        $path = implode('/', $path);
        $this->dir_create($path);
        file_put_contents($path . DS . $temp . '.html', $body);
    }

    /**
     * 递归创建文件目录
     * @param $dir
     */
    function dir_create($dir)
    {
        if (is_dir($dir) || @mkdir($dir, 0777)) {
        } else {
            $this->dir_create(dirname($dir));
            if (@mkdir($dir, 0777)) {
            }
        }
    }


    public function Pcheck()
    {

        //更新首页
        try {
            $data = new \app\index\controller\Index();
            $data->index();
        } catch (TemplateNotFoundException $exception) {
            $HTML = $this->fetch('index@index/index');//获得页面HTML代码
            $HTML = str_replace('="/index/', '="/', $HTML);
            $HTML = str_replace('="/index/index.html', '="/', $HTML);

            file_put_contents('index.html', $HTML);
        }

        //更新栏目
        $mod = Db::name('mod')->order('upid', 'desc')->order('nourl', 'desc')->select();
        foreach ($mod as $m) {
            try {
                eval("\$data = new \\app\\" . $m['m'] . "\\controller\\" . ucfirst($m['c']) . "();");
                eval("\$data->" . $m['a'] . "();");
            } catch (TemplateNotFoundException $exception) {
                $HTML = $this->fetch($m['m'] . '@' . $m['c'] . DS . $m['a']);//获得页面HTML代码
                $HTML = str_replace('="/index/', '="/', $HTML);
                $HTML = str_replace('="/index/index.html', '="/', $HTML);
                if ($m['upid'] != 0) {
                    $this->file_put_contents_ehua($m['c'] . DS . $m['a'] . DS . 't' . DS . $m['id'], $HTML);
                } else {
                    $this->file_put_contents_ehua($m['c'] . DS . $m['a'], $HTML);
                }
            }
        }


        //更新文章


//        file_put_contents()
        $article = \db('article')->join('mod', 'mod.id=' . config('database.prefix') . 'article.type')->field(config('database.prefix') . 'article.*,mod.m,mod.c,mod.a')->select();
        foreach ($article as $a) {
            try {
                eval("\$data = new \\app\\" . $a['m'] . "\\controller\\" . ucfirst($a['c']) . "();");
                eval("\$data->" . 'content' . "(" . $a['id'] . ");");
            } catch (TemplateNotFoundException $exception) {
                $HTML = $this->fetch($a['m'] . '@' . $a['c'] . DS . 'content');//获得页面HTML代码
                $HTML = str_replace('="/index/', '="/', $HTML);
                $HTML = str_replace('="/index/index.html', '="/', $HTML);
                $this->file_put_contents_ehua($a['c'] . DS . $a['a'] . DS . $a['id'], $HTML);
            }
        }

        $this->success('更新成功', $this->admPath . '/index/seo');
    }

    public function del($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }
        $i = str_replace('.html', '', $i);
        if (Db::name('system')->where('key', $i)->delete()) {
            $this->success('删除完成');
        } else {
            $this->error('删除失败');
        }

    }

    public function load()
    {
        $sys = Db::name('system')->select();
        $this->assign('sys', $sys);
        return view();
    }

    public function save()
    {
        foreach (request()->param() as $k => $y) {
            if (!empty($y)) {
                Db::name('system')->where('key', $k)->update(['value' => $y]);
            }
        }
        $this->success('保存成功', 'load');
    }
}