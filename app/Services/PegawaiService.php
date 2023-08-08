<?php

namespace App\Services;


class PegawaiService
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        $insert = $this->model->create($data);
        return $insert;
    }

    public function Query()
    {
        return $this->model->query();
    }

    public function update($id, $data)
    {
        $model = $this->model->find($id);

        if (isset($data['newimage'])) {
            $img = $data['newimage'];
            $image_array_1 = explode(";", $img);
            $image_array_2 = explode(",", $image_array_1[1]);
            $base64_decode = base64_decode($image_array_2[1]);
            $image_name = 'img/profile/' . time() . '.png';
            file_put_contents($image_name, $base64_decode);

            if ($model->img != 'avatar.png') {
                unlink($model->img);
            }
            $data['img'] = $image_name;
        } else {
            $data['img'] = $model->img;
        }

        if (\request('password')) {
            if (auth()->guard('pegawai')->check()) {
                $password = request('password');
            } else {
                $password = bcrypt(\request()->password);
            }
        } else {
            $password = $model->password;
        }

        $data['password'] = $password;

        $model->update($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->model->find($id);
        return $model;
    }
}
