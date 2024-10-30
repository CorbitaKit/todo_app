<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    protected $tasksNum;

    public function setUp(): void
    {
        parent::setUp();

        $this->tasksNum = rand(5, 10);
    }

    /**
     * Test for fetching task lists.
     *
     * This test verifies that the API endpoint for retrieving the list of tasks
     * returns a successful response (HTTP status 200). It also checks that the
     * response contains the expected number of tasks and that each task object
     * includes the required attributes: 'id', 'description', 'status', and 'title'.
     */
    public function test_fetch_tasks_list(): void
    {
        Task::factory($this->tasksNum)->create();

        $response = $this->getJson(route('tasks.index'))
            ->assertStatus(200);

        $response->assertJsonCount($this->tasksNum)
            ->assertJsonStructure(
                [
                    '*' => [
                        'id',
                        'description',
                        'status',
                        'title'
                    ]
                ]
            );
    }
    /**
     * Test fetching tasks with the status 'Completed'.
     *
     * This test verifies that the process_test_request method correctly retrieves
     * tasks that have a status of 'Completed' and asserts the expected outcomes.
     */
    public function test_fetch_tasks_with_completed_status(): void
    {
        $this->process_test_request('Completed');
    }

    /**
     * Test fetching tasks with the status 'To Do'.
     *
     * This test verifies that the process_test_request method correctly retrieves
     * tasks that have a status of 'To Do' and asserts the expected outcomes.
     */
    public function test_fetch_tasks_with_to_do_status(): void
    {
        $this->process_test_request('To Do');
    }

    /**
     * Test fetching tasks with the status 'In Progress'.
     *
     * This test verifies that the process_test_request method correctly retrieves
     * tasks that have a status of 'In Progress' and asserts the expected outcomes.
     */
    public function test_fetch_tasks_with_in_progress_status(): void
    {
        $this->process_test_request('In Progress');
    }

    /**
     * Test fetching a single task by its ID.
     *
     * This test verifies that the API endpoint for retrieving a specific task
     * returns a successful response (HTTP status 200) and that the response
     * contains the expected JSON structure, including the task's 'id', 'title',
     * 'description', and 'status'.
     */
    public function test_fetch_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson(route('tasks.show', $task->id))
            ->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'title',
            'description',
            'status'
        ]);
    }

    /**
     * Process a test request to filter tasks by their status.
     *
     * This method creates a specified number of task instances with the given status,
     * sends a GET request to the tasks.filter endpoint to retrieve tasks with that status,
     * and asserts that the response has a status code of 200 and contains the expected number
     * of tasks. It also verifies that each task in the response has the correct status.
     *
     * @param string $status The status to filter tasks by.
     */
    protected function process_test_request(string $status): void
    {
        Task::factory($this->tasksNum)->create([
            'status' => $status
        ]);

        $response = $this->getJson(route('tasks.filter', $status))
            ->assertStatus(200);

        $response->assertJsonCount($this->tasksNum);

        $tasks = $response->json();

        foreach ($tasks as $task) {
            $this->assertEquals($status, $task['status']);
        }
    }
    /**
     * Test deleting a task by its ID.
     *
     * This test verifies that the API endpoint for deleting a specific task
     * returns a successful response with no content (HTTP status 204). It also
     * checks that the task has been removed from the database by asserting that
     * it no longer exists in the 'tasks' table.
     */
    public function test_delete_task()
    {
        $task = Task::factory()->create();

        $this->deleteJson(route('tasks.destroy', $task->id))
            ->assertStatus(204);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id
        ]);
    }
}
