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

use ONGR\ElasticsearchDSL\Query\TermLevel\PrefixQuery;

/**
 * @internal
 */
class PrefixQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests toArray().
     */
    public function testToArray(): void
    {
        $query = new PrefixQuery('user', 'ki');
        $expected = [
            'prefix' => [
                'user' => [
                    'value' => 'ki',
                ],
            ],
        ];

        $this->assertEquals($expected, $query->toArray());
    }
}
