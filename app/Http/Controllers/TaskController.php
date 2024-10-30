<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Interfaces\TaskInterface;

class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskInterface $taskInterface)
    {
        $this->service = $taskInterface;
    }

    public function index()
    {
        $tasks =  $this->service->get();

        return response(json_encode($tasks), 200);
    }

    public function show(int $id)
    {
        $task = $this->service->show($id);

        return response(json_encode($task), 200);
    }

    public function store(TaskRequest $request)
    {
        $this->service->create($request);

        return response(json_encode('Created!'), 201);
    }

    public function update(TaskRequest $request, int $id)
    {
        $this->service->update($request, $id);

        return response(json_encode("Updated!"), 200);
    }

    public function destroy(int $id)
    {
        $this->service->delete($id);

        return response(json_encode('Deleted Successfully!'), 204);
    }

    public function filter(string $status)
    {
        $tasks = $this->service->filter($status);

        return response(json_encode($tasks), 200);
    }
}
