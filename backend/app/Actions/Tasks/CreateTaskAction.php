<?php

namespace App\Actions\Tasks;

use App\Models\Task;
use App\Jobs\ProcessTaskJob;
use App\Events\TaskCreated;

class CreateTaskAction
{
    public function execute(array $data, int $userId): Task
    {
        $task = Task::create([
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => 'pending',
        ]);

        ProcessTaskJob::dispatch($task);
        event(new TaskCreated($task));

        return $task;
    }
}
