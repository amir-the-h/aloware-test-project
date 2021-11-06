<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\StoreRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    /**
     * List all comments with nested children
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query()
            ->whereNull('parent_id') // only get parent comments
            ->with(['children']) // then retreive childrens as well
            ->latest() // order comments by the lastest
            ->get();

        return response()->json($comments);
    }

    /**
     * Store new comment or new reply to another comment
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        // default depth is 1
        $depth = 1;
        $parent_id = $request->get('parrent_id');
        if (!is_null($parent_id)) {
            // no need to sanity check for existance of the comment.
            // request validation already checked.
            $parent = Comment::find($parent_id);
            $depth = $parent->depth + 1;
            // reject replying on max layer
            if ($depth > Comment::MAX_LAYER) {
                return response()->json(['error' => 'It is not possible to reply much deeper.'], 400);
            }
        }

        // prepare the object
        $comment = new Comment;
        $comment->name = $request->get('name');
        $comment->body = $request->get('body');
        $comment->parent_id = $parent_id;
        $comment->depth = $depth;
        // store it
        $comment->save();

        return response()->json($comment, 201);
    }
}
