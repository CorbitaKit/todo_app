<?php

namespace App\Interfaces;

use App\Http\Requests\TaskRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface TaskInterface
{
    public function get(): Collection;
    public function create(TaskRequest $request): Model;
    public function show(int $id): Model;
    public function update(Request $request, int $model): Model;
    public function delete(int $id): bool;
    public function filter(string $status): Collection;
}
