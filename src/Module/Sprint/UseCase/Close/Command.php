<?php

declare(strict_types=1);

namespace App\Module\Sprint\UseCase\Close;

class Command
{
    /**
     * @var string
     */
    public $sprintId;

    /**
     * @param string $sprintId
     */
    public function __construct(string $sprintId)
    {
        $this->sprintId = $sprintId;
    }
}
