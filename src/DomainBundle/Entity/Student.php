<?php

namespace DomainBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DomainBundle\Infrastructure\Interfaces\IEntity;

/**
 * Student
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="DomainBundle\Repository\StudentRepository")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Student implements IEntity
{
    /**
     * @var integer
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="first_name", nullable=false, type="string")
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(name="last_name", nullable=false, type="string")
     */
    private $lastName;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity = "DomainBundle\Entity\Course")
     * @ORM\JoinTable(
     *  name = "student_courses",
     *  joinColumns = {@ORM\JoinColumn(name = "student_id", referencedColumnName = "id", onDelete = "CASCADE")},
     *  inverseJoinColumns = {@ORM\JoinColumn( name = "course_id", referencedColumnName = "id", onDelete = "CASCADE")}
     * )
     */
    protected $courses;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->courses = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return $this
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return $this
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getCourses()
    {
        return $this->courses;
    }

    /**
     * @param Course $course
     * @return $this
     */
    public function addCourse(Course $course)
    {
        $this->courses->add($course);
        return $this;
    }

    /**
     * @param Course $course
     * @return $this
     */
    public function removeCourse(Course $course)
    {
        $this->courses->removeElement($course);
        return $this;
    }
}
