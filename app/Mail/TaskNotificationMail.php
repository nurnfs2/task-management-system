<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $task;
    public $action;

    public function __construct(Task $task, $action)
    {
        $this->task = $task;
        $this->action = $action;
    }

    public function build()
    {
        return $this->subject("Task {$this->action}: {$this->task->title}")
                    ->markdown('emails.task.notification', [
                        'task' => $this->task,
                        'action' => $this->action,
                    ]);
    }
}
