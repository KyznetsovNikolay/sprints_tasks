<?php

declare(strict_types=1);

namespace App\Module\Task\UseCase\Close;

class Command
{
    /**
     * @var string
     */
    public $taskId;

    /**
     * @param string $taskId
     */
    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }
}
