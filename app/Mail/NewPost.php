<?php

namespace App\Mail;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class NewPost extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Post insance
     */
    private $post;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("mysite@test.com")
            ->subject("New post published")
            ->markdown('mail.new-post')
            ->with([
                "title" => $this->post->title,
                "slug" => $this->post->slug
            ]);
    }
}
