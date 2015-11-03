<?php

namespace DomainBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DomainBundle\Entity\Course;
use DomainBundle\Entity\Student;

/**
 * Class LoadData
 *
 * @package DomainBundle\DataFixtures\ORM
 */
class LoadData extends AbstractFixture implements OrderedFixtureInterface
{
    const COURSE_COUNT = 30;
    const STUDENT_COUNT = 10;

    const ORDER = 2;

    const FIXED_AMOUNT = 10;
    const ADDITIONAL_AMOUNT = 20;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        try {
            $courses = $this->loadCourses($manager);
            $students = $this->loadStudents($manager);

            foreach ($courses as $course) {
                /** @var Student $student */
                $student = $students[array_rand($students)];
                $student->addCourse($course);
            }

            $manager->flush();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    private function loadCourses(ObjectManager $manager)
    {
        $courses = [];

        for ($i = 1; $i <= self::COURSE_COUNT / 2; $i++) {
            $course = new Course();
            $course
                ->setName('Name' . $i)
                //fixed cost
                ->setAmount(self::FIXED_AMOUNT);

            $manager->persist($course);
            $courses[] = $course;
        }

        for ($i = 1; $i <= self::COURSE_COUNT / 2; $i++) {
            $course = new Course();
            $course
                ->setName('Name' . ($i + self::COURSE_COUNT / 2))
                //additional cost
                ->setAmount(self::ADDITIONAL_AMOUNT);

            $manager->persist($course);
            $courses[] = $course;
        }

        $manager->flush();

        return $courses;
    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    private function loadStudents(ObjectManager $manager)
    {
        $students = [];
        for ($i = 1; $i <= self::STUDENT_COUNT; $i++) {
            $student = new Student();
            $student
                ->setFirstName('FirstName' . $i)
                ->setLastName('LastName' . $i);

            $manager->persist($student);
            $students[] = $student;
        }

        $manager->flush();
        return $students;
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return self::ORDER;
    }
}
