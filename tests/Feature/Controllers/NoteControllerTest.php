<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controller\NoteController;
use App\Models\Note;

class NoteControllerTest extends TestCase
{
  use RefreshDatabase;

  public function testList()
  {
    $response = $this->get('/api/note');

    $response->assertStatus(200);
  }

  public function testCreateOfSave()
  {
    // 新規作成用のデータでPOST
    $response = $this->post('/api/note', [
      'id' => null,
      'note_contents' => 'new note'
    ]);

    // 新規作成が成功する
    $response->assertStatus(200);
  }

  public function testUpdateOfSave()
  {
    // テスト用レコード作成
    $note = Note::factory()->create();

    // アップデート用のデータでPOST
    $response = $this->post('/api/note', [
      'id' => $note->id,
      'note_contents' => $note->note_contents
    ]);

    // アップデートが成功する
    $response->assertStatus(200);
  }

  public function testDestroy()
  {
    // テスト用レコード作成
    $note = Note::factory()->create();

    // 削除できる
    $response = $this->delete('/api/note', [
      'id' => $note->id
    ]);

    // 削除が成功する
    $response->assertStatus(200);
  }
}