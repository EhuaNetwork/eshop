<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Db;
use think\Request;
use think\Url;




//取格式化的分类url
function eurl($url = '', $vars = '', $suffix = true, $domain = false)
{
    //菜单
    if (empty($vars['t']) && empty($vars['i'])) {
        return Url::build($url, $vars, $suffix, $domain);
    }

    if (!empty($vars['t']) && !empty($vars['i'])) {
        if (is_array($vars)) {
            $i = $vars['i'];
            $t = $vars['t'];
            $newurl = \db('mod')->where('id', $i)->value('nourl');
            if ($newurl != null) {
                $url = $newurl;
                $vars = '';
            } else {
                $vars = array_values($vars);
                $vars = implode('_', $vars);
                $url = explode('/', $url);
                $url = '/' . $url[1];
                $url .= '/t/' . $vars;
            }
        }
        return Url::build($url, $vars, $suffix, $domain);
    }


    //文章url
    if (!empty($vars['i'])) {
        //门窗类型url
        $vars['t'] = \db('article')->where('id', $vars['i'])->value('type');
        $newurl = \db('mod')->where('id', $vars['t'])->value('nourl');
        if ($newurl) {
            $url = $newurl . '/' . $vars['i'];
            $vars = '';
        } else {
            $url .= '/' . $vars['i'];
            $vars = '';
        }


        return Url::build($url, $vars, $suffix, $domain);
    }


    if (!empty($vars['t'])) {
        //文章url
        $newurl = \db('mod')->where('id', $vars['t'])->value('nourl');
        if ($newurl) {
            $url = $newurl;

            $vars = '';
        }
        return Url::build($url, $vars, $suffix, $domain);
    }

    return Url::build($url, $vars, $suffix, $domain);


}

function url($url = '', $vars = '', $suffix = true, $domain = false)
{
    return Url::build($url, $vars, $suffix, $domain);
}


/**
 * 解析树形结构数据
 * @param int $father_id 父节点id
 * @param $data 需要解析的数组
 * @return array 树形结构
 */
function _classify_category($father_id = 0, $data)
{
    $category = [];

    // 深度遍历
    foreach ($data as $key => $row) {
        $temp = $row;
        $temp['children'] = [];
        // 若在数组中找到子节点，删除该节点在数组中的值，减少后面遍历次数
        if ($father_id == $temp['upid']) {
            unset($data[$key]);
            $temp['children'] = _classify_category($temp['id'], $data);
            array_push($category, $temp);
        }
    }
    return $category;
}

//获取指定分类id下的子门窗类型
function get_type($id = 0, $bool = false)
{
    return \app\index\mod\Mod::gettypelist($id, $bool);
}

//获取指定分类id下的文章
function get_article($id = 0, $bool = false)
{
    return \app\index\mod\Article::getmodlist($id, $bool);
}

//获取导航
function get_nav()
{
    return \app\index\mod\Mod::getnavlist();
}

function get_system($name = null)
{
    return \app\index\mod\System::get_system($name);
}


function topString($level)
{
    $str = '';
    for ($i = 0; $i < $level; $i++) {
        $str .= '|----';
    }
    return $str;
}


function objtoarr($obj)
{
    return json_decode(json_encode($obj, true), 256);
}


/**
 * 只取中文
 * @param $chars
 * @param string $encoding
 * @return string
 */
function match_chinese($chars, $encoding = 'utf8')
{
    $pattern = ($encoding == 'utf8') ? '/[\x{4e00}-\x{9fa5}]/u' : '/[\x80-\xFF]/';
    preg_match_all($pattern, $chars, $result);
    $temp = join('', $result[0]);
    return $temp;
}