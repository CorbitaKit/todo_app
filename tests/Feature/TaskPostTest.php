<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class TaskPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test storing a new task.
     *
     * This test verifies that the API endpoint for creating a new task
     * returns a successful response (HTTP status 201) when valid data
     * is provided. It also checks that the task has been correctly
     * added to the database by asserting its presence in the 'tasks' table.
     */
    public function test_store_task(): void
    {
        $task = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => 'To Do'
        ];

        $this->postJson(route('tasks.store', $task))
            ->assertStatus(201);

        $this->assertDatabaseHas('tasks', $task);
    }

    /**
     * Test validation for a missing title when creating a task.
     *
     * This test verifies that the API endpoint for creating a task returns
     * a validation error when the title field is missing. It asserts that
     * the response contains a validation error for the 'title' field.
     */
    public function test_validate_required_tasks_title(): void
    {
        $response = $this->process_test_request([
            'title' => null,
            'description' => $this->faker->paragraph(),
            'status' => 'To Do'
        ]);

        $response->assertJsonValidationErrors(['title']);
    }

    /**
     * Test validation for a missing description when creating a task.
     *
     * This test verifies that the API endpoint for creating a task returns
     * a validation error when the description field is missing. It asserts that
     * the response contains a validation error for the 'description' field.
     */
    public function test_validate_required_tasks_description(): void
    {
        $response = $this->process_test_request([
            'title' => $this->faker->sentence(),
            'description' => null,
            'status' => 'To Do'
        ]);

        $response->assertJsonValidationErrors(['description']);
    }

    /**
     * Test validation for a missing status when creating a task.
     *
     * This test verifies that the API endpoint for creating a task returns
     * a validation error when the status field is missing. It asserts that
     * the response contains a validation error for the 'status' field.
     */
    public function test_validate_required_tasks_status(): void
    {
        $response = $this->process_test_request([
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => null
        ]);

        $response->assertJsonValidationErrors(['status']);
    }

    /**
     * Test validation for an invalid status when creating a task.
     *
     * This test verifies that the API endpoint for creating a task returns
     * a validation error when an invalid status is provided. It asserts that
     * the response contains a validation error for the 'status' field.
     */
    public function test_validate_tasks_valid_status(): void
    {
        $response = $this->process_test_request([
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => 'Test'
        ]);

        $response->assertJsonValidationErrors(['status']);
    }
    /**
     * Test the update functionality for a task.
     *
     * This test verifies that a task can be updated successfully by:
     * 1. Creating a new task using the factory.
     * 2. Sending a PATCH request with updated data.
     * 3. Asserting that the response status is 200 (OK).
     * 4. Checking that the database contains the updated task data.
     */
    public function test_update_task(): void
    {
        $newTask = Task::factory()->create();

        $updatedData = [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status' => $newTask->status
        ];

        $this->patchJson(route('tasks.update', $newTask->id,), $updatedData)
            ->assertStatus(200);

        $this->assertDatabaseHas('tasks', [
            'id' => $newTask->id,
            'title' => $updatedData['title'],
            'description' => $updatedData['description'],
            'status' => $updatedData['status']
        ]);
    }

    /**
     * Process a test request to store a task.
     *
     * This method sends a POST request to the task creation endpoint
     * with the provided task data. It expects a validation error response
     * with an HTTP status of 422.
     *
     * @param array $task The task data to be validated.
     * @return TestResponse The response from the API.
     */
    protected function process_test_request(array $task): TestResponse
    {
        return $this->postJson(route('tasks.store', $task))
            ->assertStatus(422);
    }
}
