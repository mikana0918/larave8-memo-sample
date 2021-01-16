<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NoteController extends Controller
{
    public function list(): JsonResponse
    {
        return response()->json('メモの一覧がここに入る');
    }

    public function save(): JsonResponse
    {
        return response()->json('メモの保存・アップデートの完了');
    }

    public function destroy(): JsonResponse
    {
        return response()->json('メモの削除');
    }
}
