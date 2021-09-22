<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\TermLevel;

use ONGR\ElasticsearchDSL\Query\TermLevel\RegexpQuery;

/**
 * @internal
 */
class RegexpQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new RegexpQuery('user', 's.*y');
        $expected = [
            'regexp' => [
                'user' => [
                    'value' => 's.*y',
                ],
            ],
        ];

        static::assertEquals($expected, $query->toArray());
    }
}
