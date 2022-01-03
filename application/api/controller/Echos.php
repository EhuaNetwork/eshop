<?php


namespace app\api\controller;


class Echos extends BaseApi
{
    public function echos($name = null, $phone = null, $body = null)
    {


        if (empty($name) || empty($phone) || empty($body)) {
            $this->error('信息不完整');
        }
        if (!preg_match("/^1[34578]\d{9}$/", $phone)) {
            $this->error('手机号不符合格式');
        }


        $ip = request()->ip();
        if (Db::name('echo')->where('phone', $phone)->count() > 0) {
            $this->error('留言成功');
        } else {
            $data = [
                'ip' => $ip,
                'name' => $name,
                'phone' => $phone,
                'body' => $body,
                'create_time' => date('Y-m-d H:i:s', time())
            ];
            $res = Db::name('echo')->insert($data);
            if ($res) {
                $this->success('留言成功');
            } else {
                $this->error('留言失败');

            }
        }
    }

}