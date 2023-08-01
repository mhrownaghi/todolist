<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task;

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
}
