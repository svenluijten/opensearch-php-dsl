<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Sort;

use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermsQuery;
use ONGR\ElasticsearchDSL\Sort\FieldSort;
use ONGR\ElasticsearchDSL\Sort\NestedSort;

/**
 * @internal
 */
class FieldSortTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test for toArray() method.
     */
    public function testToArray(): void
    {
        $nestedFilter = new NestedSort('somePath', new TermQuery('somePath.id', 10));
        $sort = new FieldSort('someField', 'asc', $nestedFilter);

        $expected = [
            'someField' => [
                'nested' => [
                    'path' => 'somePath',
                    'filter' => [
                        'term' => [
                            'somePath.id' => 10,
                        ],
                    ],
                ],
                'order' => 'asc',
            ],
        ];
        $result = $sort->toArray();
        $this->assertEquals($expected, $result);
    }

    public function testFieldSortingSetters(): void
    {
        $sort = new FieldSort('test', FieldSort::ASC);
        static::assertSame('test', $sort->getField());

        $sort->setField('bla');

        static::assertSame('bla', $sort->getField());

        static::assertSame(FieldSort::ASC, $sort->getOrder());

        $sort->setOrder(FieldSort::DESC);

        static::assertSame(FieldSort::DESC, $sort->getOrder());

        static::assertSame('sort', $sort->getType());

        static::assertNull($sort->getNestedFilter());

        $sort->setNestedFilter(new TermsQuery('foo', ['bar']));

        static::assertInstanceOf(TermsQuery::class, $sort->getNestedFilter());
    }
}
