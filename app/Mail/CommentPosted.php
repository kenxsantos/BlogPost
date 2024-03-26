<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentPosted extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;
    /**
     * Create a new message instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Comment Posted',
        );
    }

    /**
     * Get the message content definition.
     */
    public function build()
    {
        $subject = "Commented was posted on your {$this->comment->commentable->title} blog post";
        return $this->subject($subject)
            ->view('emails.posts.commented');
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
