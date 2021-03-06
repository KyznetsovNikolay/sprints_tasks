<?php

declare(strict_types=1);

namespace App\Module\Task\Repository;

use App\Module\Task\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function getTasksBySprintId(string $sprintId)
    {
        $sql = sprintf("SELECT * FROM sprints s 
                JOIN tasks t ON s.generated_id = t.sprint_id WHERE s.generated_id = '%s'",
            $sprintId
        );
        $conn = $this->getEntityManager()->getConnection();
        return $conn->query($sql)->fetchAll();
    }
}
