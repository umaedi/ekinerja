<?php

namespace App\Services;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;

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

        if (isset($data['img'])) {
            $data['img'] = Storage::putFile('public/avatar', $data['img']);
            if ($data['img'] != 'avatar.png') {
                Storage::delete($model->img);
            }
        } else {
            $data['img'] = $model->img;
        }

        if (\request('password')) {
            $data['password'] = bcrypt(\request()->password);
        } else {
            $data['password'] = $model->password;
        }

        $model->update($data);
        return $model;
    }

    public function find($id)
    {
        $model = $this->model->find($id);
        return $model;
    }
}
