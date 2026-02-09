<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Notes\StoreRequest;
use App\Http\Requests\Api\Notes\UpdateRequest;
use App\Models\Notes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class NoteController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    public function index(): JsonResponse
    {
        $notes = Notes::all();

        return response()->json($notes);
    }


    public function show(int $id): JsonResponse
    {
        $user_id = Auth::user()->id;
        $note = Notes::where('id', $id)->where('user_id', $user_id)->first();

        if (!$note) {
            return response()->json(['message' => 'Note not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($note);
    }


    public function store(StoreRequest $request): JsonResponse
    {
        $user_id = Auth::user()->id;
        $note = Notes::create(array_merge($request->all(), ['user_id' => $user_id]));

        return response()->json($note, Response::HTTP_CREATED);
    }


    public function update(int $id, UpdateRequest $request): JsonResponse
    {
        $note = Notes::find($id);

        if (!$note) {
            return response()->json(['message' => 'Note not found'], Response::HTTP_NOT_FOUND);
        }

        $note->title = $request->input('title');
        $note->content = $request->input('content');
        $note->save();

        return response()->json($note);
    }


    public function destroy(int $id): JsonResponse
    {
        Notes::destroy($id);

        return response()->json(['message' => 'Note deleted']);
    }
}
