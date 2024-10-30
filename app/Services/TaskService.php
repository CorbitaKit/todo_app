<?php

namespace App\Services;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskInterface;
use App\Repository\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskService implements TaskInterface
{
    protected $repo;

    public function __construct(TaskRepository $repo)
    {
        $this->repo = $repo;
    }

    public function get(): Collection
    {
        return $this->repo->get();
    }

    public function create(TaskRequest $request): Model
    {
        return $this->repo->create($request->all());
    }

    public function show(int $id): Model
    {
        return $this->repo->show($id);
    }

    public function update(TaskRequest $request, int $id): Model
    {
        return $this->repo->update($request->all, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repo->delete($id);
    }

    public function filter(string $status): Collection
    {
        if ($status === 'All') {
            return $this->repo->get();
        }

        return $this->repo->filter($status);
    }
}
