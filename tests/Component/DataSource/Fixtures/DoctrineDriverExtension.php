<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FSi\Tests\Component\DataSource\Fixtures;

use FSi\Component\DataSource\Driver\DriverAbstractExtension;
use FSi\Component\DataSource\Event\DriverEvents;

/**
 * Class to test DoctrineDriver extensions calls.
 */
class DoctrineDriverExtension extends DriverAbstractExtension
{
    /**
     * @var array
     */
    private $calls = [];

    /**
     * @var \Doctrine\ORM\QueryBuilder
     */
    private $queryBuilder;

    public function getExtendedDriverTypes()
    {
        return ['doctrine', 'doctrine-orm'];
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            DriverEvents::PRE_GET_RESULT => ['preGetResult', 128],
            DriverEvents::POST_GET_RESULT => ['postGetResult', 128],
        ];
    }

    /**
     * Returns array of calls.
     *
     * @return array
     */
    public function getCalls()
    {
        return $this->calls;
    }

    /**
     * Resets calls.
     */
    public function resetCalls()
    {
        $this->calls = [];
    }

    /**
     * Catches called method.
     *
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        if ($name === 'preGetResult') {
            $args = array_shift($arguments);
            $this->queryBuilder = $args->getDriver()->getQueryBuilder();
        }
        $this->calls[] = $name;
    }

    /**
     * Loads itself as subscriber.
     *
     * @return array
     */
    public function loadSubscribers()
    {
        return [$this];
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }
}
