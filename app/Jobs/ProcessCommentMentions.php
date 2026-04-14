<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Notifications\UserMentionedInComment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class ProcessCommentMentions implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;

    public array $backoff = [60, 120, 240];

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Comment $comment,
        private readonly Collection $mentionedUsers
    ) {}

    /** 
     * Execute the job.
     */
    public function handle(): void
    {   
        $this->comment->loadMissing('author');

        foreach ($this->mentionedUsers as $user) {
            if (! $user->is_active) {
                continue;
            }

            $user->notify(
                new UserMentionedInComment($this->comment)
            );
        }
    }
}
