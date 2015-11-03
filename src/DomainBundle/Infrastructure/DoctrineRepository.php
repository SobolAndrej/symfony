<?php

namespace DomainBundle\Infrastructure;

use Doctrine\ORM\EntityRepository;
use DomainBundle\Infrastructure\Interfaces\DoctrineRepositoryInterface;
use DomainBundle\Infrastructure\Interfaces\IEntity;

/**
 * Class DoctrineRepository
 *
 * @package DomainBundle
 */
class DoctrineRepository extends EntityRepository implements DoctrineRepositoryInterface
{

    /**
     * @param $id
     * @return null|object
     */
    public function findById($id)
    {
        return $this->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @param IEntity $object
     * @return mixed|void
     */
    public function add(IEntity $object)
    {
        $this->errorOnInvalidEntityType($object);
        $this->getEntityManager()->persist($object);
    }

    /**
     * @param IEntity $object
     */
    public function update(IEntity $object)
    {
        $this->errorOnInvalidEntityType($object);
        $this->getEntityManager()->persist($object);
    }

    /**
     * @param IEntity $object
     * @return mixed|void
     */
    public function remove(IEntity $object)
    {
        $this->errorOnInvalidEntityType($object);
        $this->getEntityManager()->remove($object);
    }

    /**
     * @return mixed
     */
    public function total()
    {
        $builder = $this->getEntityManager()->createQueryBuilder();
        $builder->select('COUNT(e)');
        $builder->from($this->getEntityName(), 'e');

        return $builder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param IEntity $object
     * @throws \InvalidArgumentException
     */
    private function errorOnInvalidEntityType(IEntity $object)
    {
        if (get_class($object) !== $this->_entityName) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid entity type %s supplied for repository of %s',
                    $this->_entityName,
                    get_class($object)
                )
            );
        }
    }
}
