<?php
namespace app\index\controller;
use app\data\controller\Lists;
use think\Request;
class News extends Basehome
{
    public $table = 'article';
    public $m;
    public function _init(Request $request = null)
    {
        $this->m = strtolower(array_reverse(explode("\\", __CLASS__))[0]);
    }
    public function index($t = null)
    {
        $Show_num = 8;
        return Lists::index($this, __FUNCTION__, __CLASS__, $t, $Show_num);
    }
    public function search($k = null)
    {
        return Lists::search($this, __FUNCTION__, __CLASS__, $k);
    }
    public function content($i = null)
    {
        return Lists::content($this, __FUNCTION__, __CLASS__, $i);
    }
}