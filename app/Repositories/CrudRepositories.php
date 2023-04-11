<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;

class CrudRepositories
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model->limit(5)->get();
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function getPaginate($perPage)
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function store($attributes, $isFile = false, $storage = '')
    {
        if ($isFile == true) {
            $lampiran = request()->file('lampiran');
            $lampiran->storeAs($storage, $lampiran->hashName());

            $attributes['lampiran'] = $lampiran->hashName();
        }

        return $this->model->create($attributes);
    }

    public function find($id)
    {
        return $this->model->findorfail($id);
    }

    public function update($id, $attributes, $isFile = false, $storage = '')
    {
        $model = $this->model->find($id);
        if ($isFile == true) {
            $img = request()->file('img');
            $img->storeAs($storage, $img->hashName());

            if ($model->img !== 'avatar.jpg') {
                Storage::delete($storage . '/' . $model->img);
            }

            $attributes['img'] = $img->hashName();
        }

        $model->update($attributes);
        return $model;
    }


    public function updateProfile($id, $attributes, $isFile = false, $storage = '')
    {
        $model = $this->model->find($id);
        if ($isFile == true) {
            $img = request()->file('img');
            $img->storeAs($storage, $img->hashName());

            if ($model->img !== 'avatar.jpg') {
                Storage::delete($storage . '/' . $model->img);
            }

            $attributes['img'] = $img->hashName();
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

        $attributes['password'] = $password;

        $model->update($attributes);
        return $model;
    }

    public function query()
    {
        return $this->model->query();
    }
}
