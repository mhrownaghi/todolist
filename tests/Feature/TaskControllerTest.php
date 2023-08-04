<?php

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * Test storing a task successfully
     */
    public function test_store_success()
    {
        // Arrange
        $data = [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-01',
            'end' => '2020-01-10',
            'description' => 'this is a test',
        ];

        // Act
        $response = $this->post(route('tasks.store'), $data);

        // Assert
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $data);
        $this->assertTrue(session()->has('message'));
    }

    /**
     * @test
     * Test storing a task on failure
     */
    public function test_store_failure()
    {
        // Act
        $response = $this->post(route('tasks.store'), []);

        // Assert
        $this->assertDatabaseMissing('tasks', []);
        $this->assertFalse(session()->has('message'));
    }

    /**
     * @test
     * Test storing a task while end date lesser than start date
     */
    public function test_store_endLesserThanStart_failure()
    {
        // Arrange
        $data = [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-10',
            'end' => '2020-01-01',
            'description' => 'this is a test',
        ];

        // Act
        $response = $this->post(route('tasks.store'), $data);

        // Assert
        $this->assertDatabaseMissing('tasks', $data);
        $this->assertFalse(session()->has('message'));
    }

    /**
     * @test
     * Test changing task status
     */
    public function test_changes_task_status_and_redirects_to_tasks_index()
    {
        // Arrange
        $task = Task::factory()->create();
        $newStatus = 'Completed';
        $data = ['status' => $newStatus];

        // Act
        $path = route('tasks.changeStatus', ['task' => $task->id]);
        $response = $this->post($path, $data);

        // Assert
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => $newStatus,
        ]);
    }

    /**
     * @test
     * Test changing task status on failure
     */
    public function test_returns_404_if_task_not_found()
    {
        // Arrange
        $taskId = 999;
        $data = ['status' => 'Completed'];

        // Act
        $response = $this->post(route('tasks.changeStatus', $taskId), $data);

        // Assert
        $response->assertStatus(404);
    }

    /**
     * @test
     * Test updating a task
     */
    public function test_updates_task_and_redirects_to_index()
    {
        // Arrange
        $task = Task::factory()->create();
        $requestData = [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-10',
            'end' => '2020-01-20',
            'description' => 'this is a test',
        ];

        // Act
        $response = $this->post(route('tasks.update', $task->id), $requestData);

        // Assert
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-10',
            'end' => '2020-01-20',
            'description' => 'this is a test',
        ]);
        $this->assertTrue(session()->has('message'));
    }

    /**
     * @test
     * test updating task on failure
     */
    public function it_redirects_back_if_task_update_fails()
    {
        // Arrange
        $taskId = 1;
        $requestData = [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-10',
            'end' => '2020-01-20',
            'description' => 'this is a test',
        ];

        // Act
        $response = $this->post(route('tasks.update', $taskId), $requestData);

        // Assert
        $response->assertStatus(404);
        $this->assertDatabaseMissing('tasks', [
            'name' => 'Test Task',
            'status' => 'Incomplete',
            'priority' => 1,
            'start' => '2020-01-10',
            'end' => '2020-01-20',
            'description' => 'this is a test',
        ]);
        $this->assertFalse(session()->has('message'));
    }

    /**
     * @test
     */
    public function testDestroyNoTasksToDelete()
    {
        $request = new Request();
        $request->tasks = [];

        $response = $this->deleteJson(route('tasks.delete'), $request->toArray());

        $response->assertJson([
            'success' => true,
            'count' => 0,
            'tasks' => []
        ]);
    }

    public function testDestroyMultipleTasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $request = new Request();
        $request->tasks = $tasks->pluck('id')->toArray();

        $response = $this->deleteJson(route('tasks.delete'), ['tasks' => $request->tasks]);

        $response->assertJson([
            'success' => true,
            'count' => 3,
            'tasks' => $request->tasks
        ]);
    }

    public function testDestroySingleTask()
    {
        $task = Task::factory(Task::class)->create();

        $request = new Request();
        $request->tasks = [$task->id];

        $response = $this->deleteJson(route('tasks.delete'), ['tasks' => $request->tasks]);

        $response->assertJson([
            'success' => true,
            'count' => 1,
            'tasks' => $request->tasks
        ]);
    }
}
