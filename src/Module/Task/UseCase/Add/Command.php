<?php

declare(strict_types=1);

namespace App\Module\Task\UseCase\Add;

class Command
{
    /**
     * @var string
     */
    public $sprintId;

    /**
     * @var string
     */
    public $estimation;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    public function __construct(
        string $sprintId,
        string $estimation,
        string $title,
        string $description
    ) {
        $this->sprintId = $sprintId;
        $this->estimation = $estimation;
        $this->title = $title;
        $this->description = $description;
    }
}
