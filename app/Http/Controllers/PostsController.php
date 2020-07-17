<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostsCollection;
use App\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all user records
        $posts = Posts::all();

        // pass all eloquent objects to user collection
        return new PostsCollection($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'body' => 'required'
                ]
        );

        //$user_id = auth('api')->user()->id;

        if ($validate->fails()) {
            $messages = $validate->messages();
            return respondError('Parameters failed validation');
        }
        try {
            /* $post          = new Posts();
              $post->title   = $request->title;
              $post->body    = $request->body;
              $post->user_id = $user_id;

              if ($post->save()) {
              return respondSuccess(SUCCESS);
              } */
            /**
             * Create Post using User model relationship
             */
            $request->user()->manyPost()->create(
                [
                    'title' => $request->title,
                    'body' => $request->body,
                ]
            );
            return respondSuccess(SUCCESS);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(Posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = \Validator::make(
                $request->all(),
                [
                    'title' => 'required',
                    'body' => 'required'
                ]
        );

        if ($validate->fails()) {
            $messages = $validate->messages();
            return respondError('Parameters failed validation');
        }

        $post = Posts::find($id);

        $post->title = $request->title;
        $post->body  = $request->body;
        try {
            if ($post->update()) {
                return respondSuccess(SUCCESS);
            }
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Posts::find($id);
        try {
            $post->delete();
            return respondSuccess(SUCCESS);
        } catch (\Exception $e) {
            return respondError($e->getMessage());
        }
    }
}