<?php

namespace App\Listeners;

use App\Events\TaskCreatedEvent;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class TaskCreatedEventListener
{
    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     *
     * @param  TaskCreatedEvent  $event
     * @return void
     */
    public function handle(TaskCreatedEvent $event)
    {
        $this->mailer->send('emails.new_task', ['task' => $event->getTask()], function ($m) {
            $m->from('hello@app.com', 'Your Application');

            $m->to('example@email.com', 'destinatario')->subject('Task creato!');
        });
    }
}
