<?php

namespace App\Repositories;

use App\Models\Note;
use Illuminate\Database\Eloquent\Collection;


class NoteRepository
{  
  /**
   * @var Note
   */
  private $note;
  
  /**
   * @param  Note $note
   */
  public function __construct(Note $note)
  {
    $this->model = $note;
  }
  
  /**
   * メモの一覧取得
   *
   * @return Collection
   */
  public function list(): Collection
  {
    return $this->model->get();
  }
  
  /**
   * メモの保存/更新
   *
   * @param  array $params
   * @return Note
   */
  public function upsert(array $params): Note
  {
    return $this->model->updateOrCreate(
      ['id' => $params['id']],
      ['note_contents' => $params['note_contents']]
    );
  }
  
  /**
   * メモの削除
   *
   * @param  int $id
   * @return bool
   */
  public function destroy(int $id): bool
  {
    return $this->model->destroy($id);
  }
}