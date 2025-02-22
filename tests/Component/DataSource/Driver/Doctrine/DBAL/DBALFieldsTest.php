<?php

/**
 * (c) FSi sp. z o.o. <info@fsi.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\FSi\Component\DataSource\Driver\Doctrine\DBAL;

use DateTimeImmutable;
use FSi\Component\DataSource\DataSourceInterface;

class DBALFieldsTest extends TestBase
{
    protected function setUp(): void
    {
        $this->loadTestData($this->getMemoryConnection());
    }

    /**
     * @return array<int,array{string,string,array<int,array{string,mixed,mixed}>}>
     */
    public function fieldsProvider(): array
    {
        return [
            [
                'title',
                'text',
                [
                    ['eq', 'title-1', 1],
                    ['neq', 'title-1', 99],
                    ['in', ['title-1', 'title-2'], 2],
                    ['notIn', ['title-1', 'title-2'], 98],
                    ['like', 'title-1', 12],
                    ['contains', 'title-1', 12],
                    ['isNull', 'null', 0],
                ],
            ],
            [
                'id',
                'number',
                [
                    ['eq', 50, 1],
                    ['neq', 50, 99],
                    ['lt', 50, 49],
                    ['lte', 50, 50],
                    ['gt', 50, 50],
                    ['gte', 50, 51],
                    ['in', [50, 60], 2],
                    ['notIn', [50, 60], 98],
                    ['between', ['from' => 30, 'to' => 50], 21],
                    ['isNull', 'null', 0],
                ],
            ],
            [
                'event_date',
                'date',
                [
                    ['eq', new DateTimeImmutable('1970-01-02 00:00:00'), 24],
                    ['neq', new DateTimeImmutable('1970-01-01 00:00:00'), 76],
                    ['lt', new DateTimeImmutable('1970-01-02 00:00:00'), 24],
                    ['lte', new DateTimeImmutable('1970-01-02 00:00:00'), 48],
                    ['gt', new DateTimeImmutable('1970-01-02 00:00:00'), 52],
                    ['gte', new DateTimeImmutable('1970-01-02 00:00:00'), 76],
                    [
                        'in',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                            new DateTimeImmutable('1970-01-02 00:00:00'),
                        ],
                        48 //not 3 because it's date, not datetime
                    ],
                    [
                        'notIn',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                            new DateTimeImmutable('1970-01-02 00:00:00'),
                        ],
                        52 //not 97 because it's date, not datetime
                    ],
                    [
                        'between',
                        [
                            'from' => new DateTimeImmutable('1970-01-02 00:00:00'),
                            'to' => new DateTimeImmutable('1970-01-03 00:00:00'),
                        ],
                        48
                    ],
                    ['isNull', 'null', 0],
                ],
            ],
            [
                'create_datetime',
                'datetime',
                [
                    ['eq', new DateTimeImmutable('1970-01-01 00:00:00'), 1],
                    ['neq', new DateTimeImmutable('1970-01-01 00:00:00'), 99],
                    ['lt', new DateTimeImmutable('1970-01-02 00:00:00'), 24],
                    ['lte', new DateTimeImmutable('1970-01-02 00:00:00'), 25],
                    ['gt', new DateTimeImmutable('1970-01-02 00:00:00'), 75],
                    ['gte', new DateTimeImmutable('1970-01-02 00:00:00'), 76],
                    [
                        'in',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                        ],
                        2
                    ],
                    [
                        'notIn',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                        ],
                        98
                    ],
                    [
                        'between',
                        [
                            'from' => new DateTimeImmutable('1970-01-01 00:00:00'),
                            'to' => new DateTimeImmutable('1970-01-02 00:00:00'),
                        ],
                        25
                    ],
                    ['isNull', 'null', 0],
                ],
            ],
            [
                'event_hour',
                'time',
                [
                    ['eq', new DateTimeImmutable('1970-01-01 01:00:00'), 5],
                    ['neq',new DateTimeImmutable('1970-01-01 01:00:00'), 95],
                    ['lt', new DateTimeImmutable('1970-01-01 03:00:00'), 15],
                    ['lte', new DateTimeImmutable('1970-01-01 03:00:00'), 20],
                    ['gt', new DateTimeImmutable('1970-01-02 03:00:00'), 80],
                    ['gte', new DateTimeImmutable('1970-01-02 03:00:00'), 85],
                    [
                        'in',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                            new DateTimeImmutable('1970-01-02 01:00:00'),
                        ],
                        10 //not 15 because it's time, not datetime
                    ],
                    [
                        'notIn',
                        [
                            new DateTimeImmutable('1970-01-01 00:00:00'),
                            new DateTimeImmutable('1970-01-01 01:00:00'),
                            new DateTimeImmutable('1970-01-02 01:00:00'),
                        ],
                        90 //not 85 because it's time, not datetime
                    ],
                    [
                        'between',
                        [
                            //dates doesn't matter
                            'from' => new DateTimeImmutable('1970-01-01 02:00:00'),
                            'to' => new DateTimeImmutable('1970-01-02 05:00:00'),
                        ],
                        18
                    ],
                    ['isNull', 'null', 0],
                ]
            ],
            [
                'visible',
                'boolean',
                [
                    ['eq', true, 50],
                ],
            ],
        ];
    }

    /**
     * @dataProvider fieldsProvider
     * @param string $fieldName
     * @param string $dataSourceType
     * @param array<int,array{string,mixed,mixed}> $typeParams
     */
    public function testFieldResult(string $fieldName, string $dataSourceType, array $typeParams): void
    {
        foreach ($typeParams as [$comparison, $parameter, $expectedCount]) {
            $dataSource = $this->getNewsDataSource();
            $dataSource->addField($fieldName, $dataSourceType, ['comparison' => $comparison]);

            $dataSource->bindParameters([
                $dataSource->getName() => [
                    DataSourceInterface::PARAMETER_FIELDS => [
                        $fieldName => $parameter,
                    ],
                ],
            ]);

            self::assertCount($expectedCount, $dataSource->getResult());
        }
    }

    /**
     * @return DataSourceInterface<array<string,mixed>>
     */
    private function getNewsDataSource(): DataSourceInterface
    {
        return $this->getDataSourceFactory()->createDataSource('doctrine-dbal', ['table' => 'news'], 'name');
    }
}
