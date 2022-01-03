<?php


namespace app\admin\controller;


use EhuaTool\Layuimini;
use think\Db;

class Shoptype extends Baseadmin
{

    public  $table='shop_type';

    public function index()
    {
        if (request()->isAjax()) {
            $data = Db::name($this->table);

            //条件
            if (request()->has('searchParams')) {
                $where=Layuimini::request_json('searchParams');
            } else {
                $where = [];
            }
            $all_page = count($data->where($where)->select()) / request()->param('limit');//总页数

            $data = $data
                ->where($where)
//                ->field('id,name,url')
                ->limit((request()->param('page') - 1) * request()->param('limit'), request()->param('limit'))
                ->order('top', 'desc')->order('create_time', 'desc')
                ->select();
            return json([
                'code' => 0,
                'msg' => '',
                'count' => $all_page,
                'data' => $data,
            ]);
        }
        return view();
    }


    public function create()
    {
        return view();
    }

    public function save()
    {
        $data=Layuimini::request_json('data');

        if (Db::name($this->table)->insert($data)) {
            $this->success('添加完成', 'lists');
        } else {
            $this->error('添加失败');
        }

    }

    public function edit($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }
        $res = Db::name($this->table)->where('id', $i)->find();
        if (empty($res)) {
            $this->error('数据不存在');
        }

        $this->assign('data', $res);
        return view();
    }

    public function update()
    {

        $id = request()->param('i');
        if (empty($id)) {
            $this->error('信息不完整');
        }
        $data = Layuimini::request_json('data');
        $data = array_filter($data);
        unset($data['i']);
        if (Db::name($this->table)->where('id', $id)->update($data)) {
            $this->success('保存完成' );
        } else {
            $this->error('保存失败');
        }
    }

    public function delete($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }

        if (Db::name($this->table)->where('id', $i)->delete()) {
            $this->success('删除完成' );
        } else {
            $this->error('删除失败');
        }

    }


}