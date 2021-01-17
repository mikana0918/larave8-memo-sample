<?php

namespace Tests\Unit\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\NoteRequest;
use Illuminate\Support\Str;

class NoteRequestTest extends TestCase
{
  use RefreshDatabase;

  public function setUp(): void
  {
    parent::setUp();
    $this->validator = app()->get('validator'); //バリデータインスタンス
    $this->rules = (new NoteRequest())->rules(); //フォームリクエストにrules()を差し込んでおく
  }
  
  /**
   * testAuthorize
   *
   * FormRequestが現在のユーザー権限で実行できるか
   * （今回は全てに適用するので常にtrueだが、稀にfalseだったりするのでテストしておく)
   */
  public function testAuthorize()
  {
    $this->assertTrue(
      (new NoteRequest())->authorize()
    );
  }

  /**
   * @test
   * @dataProvider validationProvider
   * 
   * テストの期待値
   * @param bool $shouldPass
   * 
   * フォームリクエストのモックデータ
   * @param array $mockedRequestData
   */
  public function バリデーションが通るか(bool $shouldPass, array $mockedRequestData)
  {
      $this->assertEquals(
          $shouldPass, 
          $this->validate($mockedRequestData)
      );
  }
  
  /**
   * テストの期待値: passed
   * フォームリクエストのモックデータ: data
   */
  public function validationProvider()
  {
      return [
          'アップデート: バリデーションが透る' => [
              'passed' => true,
              'data' => [
                  'id' => 1,
                  'note_contents' => '140字以下'
              ]
          ],
          'アップデート: バリデーションが通らない' => [
              'passed' => false,
              'data' => [
                'id' => 1,
                'note_contents' => Str::random(141) //141字のランダムな文字列を作成
              ]
          ],
          '新規作成： バリデーションが透る' => [
              'passed' => true,
              'data' => [
                  'id' => null,
                  'note_contents' => '140字以下'
              ]
          ],
          '新規作成: バリデーションが通らない' => [
              'passed' => false,
              'data' => [
                  'title' => null,
                  'note_contents' => Str::random(141) //141字のランダムな文字列を作成
              ]
          ]
      ];
  }
  
  /**
   * ルールを受け取って、バリデーターを実際に動作させる
   *
   * @param  array $mockedRequestData
   */
  protected function validate(array $mockedRequestData)
  {
      return $this->validator
          ->make($mockedRequestData, $this->rules)
          ->passes();
  }
}