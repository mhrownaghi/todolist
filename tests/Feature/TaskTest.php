<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * test for showing create form.
     *
     * @return void
     */
    public function test_show_create_form()
    {
        $response = $this->get('/tasks/create');

        $response->assertStatus(200);
    }
}
