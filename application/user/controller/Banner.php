<?php


namespace app\admin\controller;


class Banner extends Baseadmin
{
    public function lists($t = null, $key = null)
    {
        $data = db('banner');
        if (!empty($t)) {
            $data = $data->where('style', $t);
        }
        if (!empty($key)) {
            $data = $data->where('name', 'like', "%{$key}%");
        }

        $data = $data->paginate(5, false, ['query' => request()->param()]);

        $render = $data->render();
        $this->assign('render', $render);
        $this->assign('data', $data);


        return view();
    }

    public function create()
    {
        return view();
    }

    public function save()
    {
        $data = [
            'img' => request()->param('img'),
            'img2' => request()->param('img2'),
            'name' => request()->param('name'),
        ];
        if (db('banner')->insert($data)) {
            $this->success('发布完成','lists');
        } else {
            $this->error('发布失败');
        }

    }

    public function edit($i = null)
    {
        if (empty($i)) {
            $this->error('数据不存在');
        }
        $res = db('banner')->where('id', $i)->find();
        if (empty($res)) {
            $this->error('数据不存在');
        }


        $type = get_menu_type(1);
        $this->assign('type', $type);
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
            'img' => request()->param('img'),
            'img2' => request()->param('img2'),
            'name' => request()->param('name'),
        ];
        $data=array_filter($data);
        $data['d'] = request()->param('d');
        $data['k'] = request()->param('k');
        if (db('banner')->where('id', $id)->update($data)) {
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

        if (db('banner')->where('id', $i)->delete()) {
            $this->success('删除完成');
        } else {
            $this->error('删除失败');
        }

    }

}