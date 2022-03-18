<?php

declare(strict_types=1);

namespace App\Module\Task\UseCase\Close;

use App\Module\Task\Entity\Task;
use App\Module\Task\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var TaskRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(TaskRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Command $command
     * @return Task
     * @throws \Exception
     */
    public function handle(Command $command): Task
    {
        if (empty($command->taskId)) {
            throw new \Exception('taskId must not be empty.');
        }

        $id = explode('-', $command->taskId)[1];
        $task = $this->repository->findOneBy(['id' => $id]);

        if (!$task) {
            throw new \Exception('task does not exists.');
        }

        if ($task->getStatus() === Task::STATUS_CLOSED) {
            throw new \Exception('task already closed.');
        }

        $task->setStatus(Task::STATUS_CLOSED);
        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $task;
    }
}
