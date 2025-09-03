<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }


    public function findEmployeeWithCoursesAndTrainers(int $employeeId): ?array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e', 'c', 't')
            ->leftJoin('e.courses', 'c')
            ->leftJoin('c.trainers', 't')
            ->where('e.id = :id')
            ->setParameter('id', $employeeId);

        $employee = $qb->getQuery()->getOneOrNullResult();

        if (!$employee) {
            return null;
        }

        $courses = [];
        foreach ($employee->getCourses() as $course) {
            $trainers = [];
            foreach ($course->getTrainers() as $trainer) {
                $trainers[] = $trainer->getName();
            }
            $courses[] = [
                'name' => $course->getName(),
                'trainers' => implode(', ', $trainers),
            ];
        }

        return [
            'employee' => $employee,
            'courses' => $courses,
        ];
    }
//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
