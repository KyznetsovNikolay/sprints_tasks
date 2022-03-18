<?php

declare(strict_types=1);

namespace App\Module\Sprint\UseCase\Add;

class Command
{
    /**
     * @var string
     */
    public $year;

    /**
     * @var string
     */
    public $week;

    public function __construct(string $year, string $week)
    {
        $this->year = $year;
        $this->week = $week;
    }
}
