<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class TaskService
{
    protected $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function store($data)
    {
        if (isset($data['lampiran'])) {
            $data['lampiran'] = Storage::putFile('public/lampiran', $data['lampiran']);
        }
        return $this->model->create($data);
    }

    public function find($id)
    {
        $model = $this->model->find($id);
        return $model;
    }

    public function Query()
    {
        return $this->model->query();
    }
}
