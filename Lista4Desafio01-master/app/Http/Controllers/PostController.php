<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\Gate;


class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try
        {
            $posts = $this->postService->listAllPosts();
            return response()->json($posts);
        }
        catch(\Exception $e)
        {
            return response()->json(['Erro'=> $e->getMessage()],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        try{
        $validated_data = $request->validated();
        
        $author_id = $request->user()->id;
        
        $post = $this->postService->createPost($validated_data, $author_id);

        return response()->json([
            'message'=> 'Sucesso: Post criado com sucesso',
            'post'=> $post
        ],201);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try
        {
            $post = $this->postService->findPostById($id);

            if(!$post)
                {
                    return response()->json('Erro: Post nao encontrado', 404);
                }
            return response()->json($post, 200);
        }
        catch(\Exception $e)
        {
            return response()->json(['Erro'=> $e->getMessage()],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        try
        {
        $post = $this->postService->findPostById($id);
        if(!$post)
            {
                return response()->json(['Erro'=> 'Post nao encontrado'], 404);
            }
        Gate::authorize('update', $post);

        $validated_data = $request->validated();

        $updated_post = $this->postService->updatePost($id, $validated_data);
        
        return response()->json([
            'message'=> 'Sucesso: Post atualizado',
             'post'=> $updated_post,
            ], 200);
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try
        {
            $post = $this->postService->findPostById($id);

            if(!$post)
                {
                    return response()->json(['Erro'=> 'Post nao encontrado'],404);
                }
            Gate::authorize('delete', $post);

            $this->postService->deletePost($id);

            return response()->json( null, 204);
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

    public function archive(string $id)
    {
        try
        {
            $post = $this->postService->findPostById($id);

            if(!$post)
                {
                    return response()->json(['Erro'=> 'Post nao encontrado'],404);
                }

            Gate::authorize('update', $post);

            $this->postService->archivePost($id);

            return response()->json(['Sucesso'=> 'Post arquivado']);
        }
        catch (AuthorizationException $e)
        {
            return response()->json(['Erro'=> $e->getMessage()],403);
        }
        catch(\Exception $e)
        {
            return response()->json(['Erro'=> $e->getMessage()],500);
        }
    }
}
