<?php


namespace app\admin\controller;
use think\Db;

class Echos extends Baseadmin
{
    public function lists()
    {
        $data = Db::name('echo');

        if (!empty($key)) {
            $data = $data->where('phone', 'like', "%{$key}%");
        }
        if (!empty($name)) {
            $data = $data->where('name', 'link', "%{$name}%");
        }

        $data = $data->field('id,name,phone,create_time,description,ip')->order('create_time', 'desc')->paginate(5, false, ['query' => request()->param()]);

        $render = $data->render();
        $this->assign('render', $render);
        $this->assign('data', $data);

        return view();
    }


    public function edit($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }
        $res = Db::name('echo')->where('id', $i)->find();
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
        $data = [
            'name' => request()->param('name'),
            'phone' => request()->param('phone'),
            'area' => request()->param('area'),
            'budget' => request()->param('budget'),
            'description' => request()->param('description'),
        ];
        $data=array_filter($data);
        if (Db::name('echo')->where('id', $id)->update($data)) {
            $this->success('保存完成','lists');
        } else {
            $this->error('保存失败');
        }
    }

    public function del($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }

        if (Db::name('echo')->where('id', $i)->delete()) {
            $this->success('删除完成','lists');
        } else {
            $this->error('删除失败');
        }

    }

}