<?php


namespace app\index\controller;


use think\Controller;
use think\Db;

class Basehome extends Controller
{
    public $staticStatus = false;
    public $M;
    public $C;
    public $A;
    public $system;

    public function _initialize()
    {
        $this->M = strtolower(request()->module());//获取模块
        $this->C = strtolower(request()->controller());//获取控制器
        $this->A = strtolower(request()->action());//获取方法

        if (substr(request()->url(), -4) != '.html') {
            if (file_exists(ROOT_PATH . 'public' . request()->url() . '.html')) {
                echo file_get_contents(ROOT_PATH . 'public' . request()->url() . '.html');
                die;
            }
        }


        //读取seo配置
        $path = ROOT_PATH . 'application/data/tpl/index';
        if (!file_exists($path)) {
            file_put_contents($path, 'false');
            $this->staticStatus = 'false';
        } else {
            $this->staticStatus = file_get_contents($path);
        }



        //获取公共数据
        $this->setCommon();

        $links=Db::name('link')->where('status',1)->select();
        $this->assign('links',$links);


        $this->system = get_system();
        $this->system['web_title'] = $this->getTitle($this->C, $this->A);
        $this->assign('system', $this->system);

        $this->_init();
    }

    public function _init()
    {
        //注册加载方法 此处不写代码
    }

    public function setCommon()
    {
        $nav = get_nav();
        $this->assign('nav', $nav);
    }

    public function getTitle($C, $A)
    {
        $C = strtolower($C);
        $A = strtolower($A);

        if ($C == 'index' && $A == 'index') {
            $T_name = $this->system['web_title'];
        } else {
            $T_name = 'SEO填充内容_' . $this->system['web_title'];
        }
        return $T_name;

    }

    public function getContentTitle($data)
    {

       if (@$data['name']) {
            $this->system['web_title'] = $data['name'] . '_'. $this->system['company'];
        } else {
            $this->system['web_title'] =  $data['title'] . '_'. $this->system['company'];
        }
        $this->assign('system', $this->system);

    }

    public function getContentD($data)
    {
        if (empty($data['d']) || $data['d'] == '') {
            $this->system['web_description'] = $this->system['web_description'];
        } else {
            $this->system['web_description'] = $data['d'];
        }
        $this->assign('system', $this->system);

    }

    public function getContentK($data)
    {
        if (empty($data['d']) || $data['d'] == '') {
            $this->system['web_keywords'] = $this->system['web_keywords'];
        } else {
            $this->system['web_keywords'] = $data['k'];
        }
        $this->assign('system', $this->system);

    }

    /**
     * 模板输出重写方法
     * @access protected
     * @param boolean $isstatic 是否保存为静态文件
     * @param string $template 模板文件名
     * @param array $vars 模板输出变量
     * @param array $replace 模板替换
     * @param array $config 模板参数
     * @return mixed
     */
    public function staticFetch($isstatic = false, $template = '', $vars = [], $replace = [], $config = [])
    {
        $HTML = $this->fetch($template, $vars, $replace, $config);//获得页面HTML代码
        if ($isstatic == "true") {//判断是否需要保存为静态页
            //多参数目录递归版本
            $new_file = request()->url();
            $new_file = explode('/', $new_file);
            $thisAction = array_pop($new_file);
            array_shift($new_file);
            $new_file = implode('/', $new_file);
            if (empty($new_file)) {
                $thisModule = strtolower(request()->module());//获取模块
                $thisController = strtolower(request()->controller());//获取控制器
                $thisAction = strtolower(request()->action());//获取方法
                if ($thisModule == 'index' || $thisController == 'index' || $thisAction == 'index') {
                    file_put_contents('index.html', $HTML);//生成静态页
                }

                $new_file = "{$thisModule}/{$thisController}";
                if (!file_exists($new_file)) {
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0777, true);
                }
                $new_file .= "/{$thisAction}." . config('default_return_type');

                if (substr($new_file, -5) != '.html') {
                    $new_file .= '.html';
                }

                file_put_contents($new_file, $HTML);//生成静态页
            } else {
                if (!file_exists($new_file)) {
                    //检查是否有该文件夹，如果没有就创建，并给予最高权限
                    mkdir($new_file, 0777, true);
                }
                $new_file .= "/{$thisAction}";

                if (substr($new_file, -1) == '/') {
                    $new_file .= 'index.html';
                } else {
                    if (substr($new_file, -5) != '.html') {
                        $new_file .= '.html';
                    }
                }

                file_put_contents($new_file, $HTML);//生成静态页
            }
        }
        return $HTML;
    }

    /**
     * @param $mode 栏目类别
     * @param $t    分类id
     */
    public function getLitsTitle($c, $a, $t = null)
    {
        $t= empty($t)? \db('mod')->where('c',$c)->where('a',$a)->where('upid',0)->value('id'): $t;
        $data = Db::name('mod')->where('id', $t)->find();
        if (!empty($data)) {

            if($t==1){
                if ((empty($data['t']) || $data['t'] == '' )) {
                    $this->system['web_title'] = $data['name'];
                } else {
                    $this->system['web_title'] = $data['t'];
                }

            }else{
                if ((empty($data['t']) || $data['t'] == '' )) {
                    $this->system['web_title'] =  str_replace('SEO填充内容_', $data['name'] . '-', $this->system['web_title']);
                } else {
                    $this->system['web_title'] = str_replace('SEO填充内容_', $data['t'] . '-', $this->system['web_title']);
                }
            }

            if($data['d']){
                $this->system['web_description'] = $data['d'];
            }
            if($data['k']){
                $this->system['web_keywords'] = $data['k'];
            }
        } else {
            $data['name'] = Db::name('mod')->where('c', $c)->where('a', $a)->where(['upid' => 0])->value('name');
            $this->system['web_title'] = str_replace('SEO填充内容_', $data['name'] . '-', $this->system['web_title']);
        }
        $this->assign('system', $this->system);
    }

    /**
     * 内容页 上一篇 下一篇功能
     * @param $i    当前内容id
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function CheckPage($i, $t, $m)
    {
        $prev = Db::name('article')->where('type', $t)->where('id', '<', $i)->order('id', 'desc')->limit(1)->find();
        $next = Db::name('article')->where('type', $t)->where('id', '>', $i)->order('id')->limit(1)->find();
        $prev_url = url("index/$m/content", ['i' => $prev['id']]);
        $next_url = url("index/$m/content", ['i' => $next['id']]);

        if (empty($prev)) {
            $prev['name'] = '没有了';
            $prev_url = 'javascript:void(0);';
        }
        if (empty($next)) {
            $next['name'] = '没有了';
            $next_url = 'javascript:void(0);';
        }


        $pag = "
        <div style='width: 100%'>
        <a href='" . $prev_url . "'><div style='width: 100%'>上一个：" . $prev['name'] . "</div></a>
               <a href='" . $next_url . "'><div style='width: 100%'>下一个：" . $next['name'] . "</div></a>
</div>
        
        ";
        $this->assign('pag', $pag);
    }

}
