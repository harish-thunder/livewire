<?php

namespace App\Http\Livewire;

use App\Models\Comment;
use Livewire\Component;

class Comments extends Component
{
    public $comments, $newComment;

    protected $rules = [
        'newComment' => 'required|max:255'
    ];

    public function render()
    {
        return view('livewire.comments', ['comments' => $this->comments]);
    }

    public function mount()
    {
        $this->comments = Comment::latest()->get();
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function addComment()
    {
        $this->validate();
        $this->comments->prepend(Comment::create(['body' => $this->newComment, 'creator' => 1]));

        $this->newComment = '';

        session()->flash('message', 'Comment Created Successfully 🍻.');
    }

    public function removeComment($id)
    {
        $comment = Comment::find($id);
        $this->comments = $this->comments->except($id);
        $comment->delete();

        session()->flash('message', 'Comment Deleted Successfully 😃.');
    }
}
