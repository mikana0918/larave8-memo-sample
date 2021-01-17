<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Repositories\NoteRepository;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{    
    /**
     * @var NoteRepository
     */
    private $noteRepository;
        
    /**
     * @param  NoteRepository $noteRepository
     */
    public function __construct(NoteRepository $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }
    
    /**
     * GET メモの一覧
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        return response()->json(
            $this->noteRepository->list()
        );
    }

    /**
     * POST メモの保存
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function save(NoteRequest $request): JsonResponse
    {
        return response()->json(
            $this->noteRepository->upsert($request->all())
        );
    }

    /**
     * DELETE メモの削除
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(NoteRequest $request): JsonResponse
    {
        return response()->json(
            $this->noteRepository->destroy($request->id)
        );
    }
}
