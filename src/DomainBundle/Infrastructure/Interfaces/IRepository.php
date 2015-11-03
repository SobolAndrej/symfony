<?php

namespace DomainBundle\Infrastructure\Interfaces;

/**
 * Interface IRepository
 *
 * @package DomainBundle\Infrastructure\Interfaces
 */
interface IRepository
{
    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @return array
     */
    public function findAll();

    /**
     * @param IEntity $object
     * @return mixed
     */
    public function add(IEntity $object);

    /**
     * @param IEntity $object
     * @return mixed
     */
    public function remove(IEntity $object);

    /**
     * @return int
     */
    public function total();
}
