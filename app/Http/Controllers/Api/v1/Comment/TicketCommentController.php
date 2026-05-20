<?php

namespace App\Http\Controllers\Api\v1\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Ticket;
use App\Services\Comment\CommentService;

class TicketCommentController extends Controller
{
    public function __construct(
        protected CommentService $commentService
    ) {}

    public function index(Ticket $ticket)
    {
        return $this->commentService->indexComment($ticket);
    }

    public function store(StoreCommentRequest $request, Ticket $ticket)
    {
        return $this->commentService->storeComment($request, $ticket);
    }

    public function destroy(Ticket $ticket, Comment $comment)
    {
        return $this->commentService->destroyComment($ticket, $comment);
    }
}
