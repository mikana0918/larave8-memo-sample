<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controller\NoteController;

class NoteControllerTest extends TestCase
{
  use RefreshDatabase;

  public function testList()
  {
    $response = $this->get('/api/note');

    $response->assertStatus(200);
  }

  public function testSave()
  {
    $response = $this->post('/api/note');

    $response->assertStatus(200);
  }

  public function testDestroy()
  {
    $response = $this->delete('/api/note');

    $response->assertStatus(200);
  }
}