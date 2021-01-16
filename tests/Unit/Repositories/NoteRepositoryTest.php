<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NoteRepositoryTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->repo = \App::make(NoteRepository::class); // IoC containerによる自動解決
  }

  public function testList()
  {
    $n = 5;
    $notes = Note::factory()->count($n)->create(); //レコード5件作成
    $list = $this->repo->list(); //NoteRepositoryの実装のメソッドlist()を実行

    $this->assertEquals($n, count($list)); //実際に5件のCollectionがリストされるか確認
  }

  public function testUpsertCreate()
  {
    $params = [
      'id' => null,
      'note_contents' => 'new hogefuga' //新規作成するとき
    ];

    $upsert = $this->repo->upsert($params);

    $this->assertInstanceOf(Note::class, $upsert); //保存成功すればNoteを返却  
  }
  
  /**
   * Upsertのうち、Updateが正常に行えるか
   *
   * @return void
   */
  public function testUpdateOfUpsert()
  {
    // レコード新規作成
    $note =  Note::factory()->create([
      'id' => 100,
      'note_contents' => 'hogehogehogehoge'
    ]);

    // アップデートパラメーター
    $params = [
      'id' => 100,
      'note_contents' => 'fuga'
    ];

    // 更新: 新規作成したモデルを配列にシリアライズ
    $upsert = $this->repo->upsert($params);

    // 保存成功すればNoteモデルを返却  
    $this->assertInstanceOf(Note::class, $upsert);
    // upsertして返却されたnote_contents = アップデートパラメータ note_contents
    $this->assertEquals(
      $params['note_contents'], 
      $upsert->toArray()['note_contents']
    ); 
  }
  
  /**
   * Upsertのうち、Createが正常に行えるか
   *
   * @return void
   */
  public function testCreateOfUpsert()
  {
    // 新規作成レコード
    $params = [
      'id' => null,
      'note_contents' => 'hogehogehogehoge'
    ];

    // 更新: 新規作成したモデルを配列にシリアライズ
    $upsert = $this->repo->upsert($params);

    // 保存成功すればNoteを返却  
    $this->assertInstanceOf(Note::class, $upsert);
  }

  public function testDestroy()
  {
    $id = 200;

    // レコード新規作成
    $note =  Note::factory()->create([
      'id' => $id,
      'note_contents' => 'hogehogehogehoge'
    ]);

    // モデル destroy
    $destroy = $this->repo->destroy($id);

    // 成功すれば真偽値でtrueを返す
    $this->assertTrue($destroy);

  }
}