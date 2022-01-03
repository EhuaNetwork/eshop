<?php


namespace app\index\controller;


use app\data\controller\Only;

class About extends Basehome
{
    public function link()
    {
        return Only::index($this, __FUNCTION__, __CLASS__);
    }
    public function echo()
    {
        return Only::index($this, __FUNCTION__, __CLASS__);
    }
    public function info()
    {
        return Only::index($this, __FUNCTION__, __CLASS__);
    }
    public function map()
    {
        return Only::index($this, __FUNCTION__, __CLASS__);
    }
}