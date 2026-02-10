<?php

namespace App\Jobs;

use App\Models\Task;
use App\Events\TaskStatusUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProcessTaskJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 15;

    public function __construct(
        public Task $task
    ) {}

    public function handle(): void
    {
        // simulate heavy processing
        sleep(random_int(3, 5));

        $this->task->update([
            'status' => 'in_progress',
        ]);

        event(new TaskStatusUpdated($this->task));
    }

    public function failed(Throwable $exception): void
    {
        $this->task->update([
            'status' => 'pending',
        ]);
    }
}
