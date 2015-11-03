<?php

namespace DomainBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use DomainBundle\Entity\Student;
use DomainBundle\Infrastructure\DoctrineRepository;

/**
 * Class Student
 *
 * @package DomainBundle\Repository
 */
class StudentRepository extends DoctrineRepository
{

    /**
     * Returns random Student
     *
     * @return Student|null
     */
    public function findRand()
    {
        $result = $this->createQueryBuilder('student')
            ->addSelect('RAND() as HIDDEN rand')
            ->addOrderBy('rand')
            ->getQuery()
            ->setMaxResults(1)
            ->getResult();
        return count($result) > 0 ? reset($result) : null;
    }

    /**
     * @return array|null
     */
    public function findMaxStudentCourses()
    {
        $result = $this->createQueryBuilder('student')
            ->select(
                "CONCAT(student.firstName, ' ', student.lastName) as name, COUNT(courses.id) as course_count"
            )
            ->join('student.courses', 'courses')
            ->groupBy('student.id')
            ->orderBy('course_count', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
        return count($result) > 0 ? reset($result) : null;
    }

    /**
     * @return array
     */
    public function findStudentList()
    {
        return $this->studentInfoQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    protected function studentInfoQueryBuilder()
    {
        return $this->createQueryBuilder('student')
            ->select(
                "CONCAT(student.firstName, ' ', student.lastName) as name,
                COUNT(courses) as course_count,
                SUM(courses.amount) as cost"
            )
            ->join('student.courses', 'courses')
            ->groupBy('student.id')
            ->orderBy('name', 'ASC');
    }
}
