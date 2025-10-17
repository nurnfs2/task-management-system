<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_create_task()
    {
        $user = User::factory()->create();

        $res = $this->actingAs($user, 'sanctum')->postJson('/api/tasks', [
            'title'       => 'My unique task',
            'description' => 'desc',
            'status'      => 'incomplete',
        ]);

        $res->assertStatus(201)
            ->assertJsonFragment(['title' => 'My unique task']);

        $this->assertDatabaseHas('tasks', ['title' => 'My unique task']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $res = $this->actingAs($user, 'sanctum')->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated Title',
            'status' => 'complete',
        ]);

        $res->assertStatus(200);
        $this->assertDatabaseHas('tasks', ['title' => 'Updated Title']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_delete_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $res = $this->actingAs($user, 'sanctum')->deleteJson("/api/tasks/{$task->id}");

        $res->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
