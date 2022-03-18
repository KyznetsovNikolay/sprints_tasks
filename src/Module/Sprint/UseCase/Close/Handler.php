<?php

declare(strict_types=1);

namespace App\Module\Sprint\UseCase\Close;

use App\Module\Sprint\Entity\Sprint;
use App\Module\Sprint\Repository\SprintRepository;
use Doctrine\ORM\EntityManagerInterface;

class Handler
{
    /**
     * @var SprintRepository
     */
    private $repository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(SprintRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Command $command
     * @return Sprint
     * @throws \Exception
     */
    public function handle(Command $command): Sprint
    {
        $generatedId = $command->sprintId;
        /** @var Sprint $sprint */
        $hasSprint = $this->repository->getSprintByGeneratedId($generatedId);
        if ($hasSprint) {
            $sprint = $hasSprint[0];
        }

        if (!$hasSprint) {
            throw new \Exception('sprint does not exists or already closed.');
        }

        $tasks = $this->repository->getSprintTasksByGeneratedId($generatedId);
        if (count($tasks) > 0) {
            throw new \Exception('you can\'t close a sprint with open tasks. First you need to complete all tasks.');
        }

        $sprint->setStatus(Sprint::STATUS_CLOSED);
        $this->entityManager->persist($sprint);
        $this->entityManager->flush();

        return $sprint;
    }
}
