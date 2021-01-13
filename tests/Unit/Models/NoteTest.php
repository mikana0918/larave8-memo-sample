<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase; //テストごとにDBリフレッシュ

class NoteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function testModelAndFactory() 
    {        
        $persisted = Note::factory()->create(); //永続化(内部的にsaveを行う)
        $first = Note::first(); //最初のモデルを取得

        $this->assertEquals($persisted->id, $first->id);

    }
}
