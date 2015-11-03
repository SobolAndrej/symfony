<?php

namespace DomainBundle\Infrastructure\Interfaces;

use Doctrine\Common\Collections\Selectable;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * Interface DoctrineRepositoryInterface
 *
 * @package DomainBundle\Infrastructure\Interfaces
 */
interface DoctrineRepositoryInterface extends ObjectRepository, Selectable, IRepository
{
    /**
     * @param IEntity $object
     */
    public function update(IEntity $object);

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     *
     * @return QueryBuilder
     */
    public function createQueryBuilder($alias);

    /**
     * Creates a new result set mapping builder for this entity.
     *
     * The column naming strategy is "INCREMENT".
     *
     * @param string $alias
     *
     * @return ResultSetMappingBuilder
     */
    public function createResultSetMappingBuilder($alias);

    /**
     * Creates a new Query instance based on a predefined metadata named query.
     *
     * @param string $queryName
     *
     * @return Query
     */
    public function createNamedQuery($queryName);

    /**
     * Creates a native SQL query.
     *
     * @param string $queryName
     *
     * @return NativeQuery
     */
    public function createNativeNamedQuery($queryName);

    /**
     * Clears the repository, causing all managed entities to become detached.
     *
     * @return void
     */
    public function clear();
}
