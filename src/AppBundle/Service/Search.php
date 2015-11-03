<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use DomainBundle\Entity\Course;
use DomainBundle\Entity\Student;
use DomainBundle\Repository\CourseRepository;
use DomainBundle\Repository\StudentRepository;
use DomainBundle\Service\MemcachedService;

/**
 * Class Search
 *
 * @package AppBundle\Service
 */
class Search
{
    const SERVICE = 'app.service.search';

    const MAX_COURSES_KEY = 'maxStudentCourses';
    const STUDENT_LIST_KEY = 'studentList';

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var StudentRepository
     */
    protected $studentRepository;

    /**
     * @var CourseRepository
     */
    protected $courseRepository;

    /**
     * @var MemcachedService
     */
    protected $memcached;

    /**
     * @param EntityManager $entityManager
     * @param MemcachedService $memcached
     */
    public function __construct(EntityManager $entityManager, MemcachedService $memcached)
    {
        $this->entityManager = $entityManager;
        $this->studentRepository = $this->entityManager->getRepository(Student::class);
        $this->courseRepository = $this->entityManager->getRepository(Course::class);
        $this->memcached = $memcached;
    }

    /**
     * @return mixed
     */
    public function getRandomStudent()
    {
        return $this->studentRepository->findRand();
    }

    /**
     * @return array|null
     */
    public function getMaxStudentCourses()
    {
        $result = $this->memcached->get(self::MAX_COURSES_KEY);

        if (empty($result)) {
            $result = $this->studentRepository->findMaxStudentCourses();
            $this->memcached->set(self::MAX_COURSES_KEY, $result);
        }
        return $result;
    }

    /**
     * @return array
     */
    public function getStudentList()
    {
        $result = $this->memcached->get(self::STUDENT_LIST_KEY);

        if (empty($result)) {
            $result = $this->studentRepository->findStudentList();
            $this->memcached->set(self::STUDENT_LIST_KEY, $result);
        }
        return $result;
    }
}
