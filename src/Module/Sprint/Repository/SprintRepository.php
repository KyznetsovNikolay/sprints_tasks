<?php

declare(strict_types=1);

namespace App\Module\Sprint\Repository;

use App\Module\Sprint\Entity\Sprint;
use App\Module\Task\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sprint|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sprint|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sprint[]    findAll()
 * @method Sprint[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SprintRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sprint::class);
    }

    public function getAllSprints()
    {
        $sql = "SELECT * FROM sprints";
        $conn = $this->getEntityManager()->getConnection();
        return $conn->query($sql)->fetchAll();
    }

    public function getSprintByGeneratedId(string $generatedId)
    {
        $qb = $this->createQueryBuilder('s');
        return $qb
            ->andWhere('s.generatedId = :id AND s.status = :status')
            ->setParameter('id', $generatedId)
            ->setParameter('status', Sprint::STATUS_ACTIVE)
            ->getQuery()
            ->getResult();
    }

    public function getSprintTasksByGeneratedId(string $generatedId)
    {
        $sql = sprintf(
            "SELECT * FROM sprints AS s 
                        JOIN tasks AS t ON s.generated_id = t.sprint_id 
                        WHERE s.generated_id = '%s' AND s.status = '%s' AND t.status = '%s'",
            $generatedId,
            Sprint::STATUS_ACTIVE,
            Task::STATUS_ACTIVE
        );
        $conn = $this->getEntityManager()->getConnection();
        return $conn->query($sql)->fetchAll();
    }
}
