<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Cache\EntityCacheEntry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Employee::class);
        $this->em = $em;
    }

    // /**
    //  * @return Employee[] Returns an array of Employee objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /**
     * @param $content
     *
     * @return bool
     */
    public function saveEmployees($content): bool
    {
        try {
            $this->em->persist($content);
            $this->em->flush();

            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function create(Employee $employee): bool
    {
        try {
            $this->em->persist($employee);
            $this->em->flush();

            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function update(Employee $employee): bool
    {
        try {
            $this->em->persist($employee);
            $this->em->flush();

            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function delete(Employee $employee): bool
    {
        try {
            $this->em->remove($employee);
            $this->em->flush();

            return true;
        } catch (OptimisticLockException $exception) {
            return false;
        }
    }

    /*
    public function findOneBySomeField($value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
