<?php

namespace App\Repository;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskRepository
{
    protected $model;
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function get(): Collection
    {
        return $this->model->get();
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function show(int $id): Model
    {
        return $this->model->where('id', $id)->first();
    }

    public function update(array $data, int $id): Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }

    public function delete(int $id): bool
    {
        $model = $this->model->findOrFail($id);
        return $model->delete();
    }

    public function filter(string $status): Collection
    {
        return $this->model->where('status', $status)->get();
    }
}
