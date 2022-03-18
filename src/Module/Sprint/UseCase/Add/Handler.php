<?php

declare(strict_types=1);

namespace App\Module\Sprint\UseCase\Add;

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
        if (empty($command->year)) {
            throw new \Exception('year must not be empty.');
        }
        if (empty($command->week)) {
            throw new \Exception('week must not be empty.');
        }

        $yearChar = strtolower(substr($command->year, -2));
        $weekChar = strtolower($command->week);
        $generatedId = "$yearChar-$weekChar";

        $sprint = $this->repository->getSprintByGeneratedId($generatedId);

        if ($sprint) {
            throw new \Exception('sprint for this week already exists.');
        }

        $sprint = (new Sprint())
            ->setYear($command->year)
            ->setWeek($command->week)
            ->setGeneratedId($generatedId)
            ->setStatus(Sprint::STATUS_ACTIVE)
        ;
        $this->entityManager->persist($sprint);
        $this->entityManager->flush();

        return $sprint;
    }
}
