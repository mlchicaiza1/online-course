<?php

namespace App\Livewire;

use Livewire\Component;
use App\Dtos\CommentDto;
use App\Services\CommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentComponent extends Component
{


    public $comments, $comment, $commentId,$state;
    public $isEdit = false;

    protected $rules = [
        'comment' => 'required:comments,comment',
    ];

    protected $listeners = ['deleteComment'];

    protected $commentService;

    public function boot(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function mount()
    {
        $this->authorize('manage courses');
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = $this->commentService->getAllComments(['video']);
    }

    public function createComment()
    {
        $this->validate();

        $this->commentService->createComment(
            CommentDto::from(
                [   'comment' => $this->comment,
                    'video_id' => $this->video_id,
                    'user_id' => $this->user_id,
                    'state' => $this->state,
                ]
            ));

        $this->resetForm();
        $this->loadComments();

        session()->flash('success', 'Comment created successfully!');
    }

    public function editComment($id)
    {
        $comment = $this->commentService->findCommentById($id,['video']);

        $this->commentId = $comment->id;
        $this->comment = $comment->comment;
        $this->state = $comment->state;
        $this->isEdit = true;
    }

    public function updateComment()
    {
        $this->validate();

        $this->commentService->updateComment($this->commentId,
                CommentDto::from(['comment' => $this->comment, 'state' => $this->state,]));

        $this->resetForm();
        $this->loadComments();

        session()->flash('success', 'Comment updated successfully!');
    }

    public function confirmDeleteComment($id)
    {
        $this->dispatch('confirmDelete', id: $id);
    }

    public function deleteComment($id)
    {
        $this->commentService->deleteComment($id);

        $this->loadComments();

        session()->flash('success', 'Comment deleted successfully!');
    }

    public function resetForm()
    {
        $this->comment = '';
        $this->state  = '' ;
        $this->commentId = null;
        $this->isEdit = false;
    }

    public function render()
    {
        return view('livewire.comment-component');
    }
}
