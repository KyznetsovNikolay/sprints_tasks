<?php

declare(strict_types=1);

namespace App\Module\Task\UseCase\Add;

use App\Module\Sprint\Repository\SprintRepository;
use App\Module\Task\Entity\Task;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var SprintRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $entityManager, SprintRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @param Command $command
     * @return Task
     * @throws \Exception
     */
    public function handle(Command $command): Task
    {
        $sprint = $this->repository->getSprintByGeneratedId($command->sprintId);
        if (!$sprint) {
            throw new \Exception('there is no such sprint.');
        }

        $task = (new Task)
            ->setTitle($command->title)
            ->setStatus(Task::STATUS_ACTIVE)
            ->setEstimation($command->estimation)
            ->setSprintId($command->sprintId)
            ->setDescription($command->description);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }
}
