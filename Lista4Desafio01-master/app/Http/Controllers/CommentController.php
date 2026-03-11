<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;
class CommentController extends Controller
{
    protected $comment_service;

    public function __construct(CommentService $comment_service)
    {
        $this->comment_service = $comment_service;
    }

    public function index(string $post_id)
    {
    try{
        $comment = $this->comment_service->listByPost($post_id);
        return response()->json($comment, 200);
        }
        catch(\Exception $e){
            return response()->json(['Erro'=>$e->getMessage()], $e->getCode()?:500);
        }
    }

    public function store(StoreCommentRequest $request, string $post_id)
    {
        try
        {
            $data = [
                'post_id'=> $post_id,
                'author_id'=>$request->user()->id,
                'content'=> $request->validated()['content']
            ];

            $comment = $this->comment_service->create($data);

            return response()->json($comment, 201);
        }
        catch(\Exception $e){
            return response()->json(['Erro'=>$e->getMessage()], $e->getCode()?:500);
        }
    }

    public function destroy(string $id)
    {
        try
        {
            $comment = $this->comment_service->findById($id);

            if(!$comment)
                {
                    return response()->json('Erro: comentario nao encontrado', 404);
                }
            Gate::authorize('delete', $comment);

            $this->comment_service->delete($id);

            return response()->json(null, 204);
        }
        catch(AuthorizationException $e)
        {
            return response()->json(['Erro'=> $e->getMessage()],403);
        }
        catch(\Exception $e)
        {
            return response()->json(['Erro:'=> $e->getMessage()],500);
        }
    }
}
