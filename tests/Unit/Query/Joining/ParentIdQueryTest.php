<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Joining;

use ONGR\ElasticsearchDSL\Query\Joining\ParentIdQuery;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ParentIdQueryTest extends TestCase
{
    public function testToArray(): void
    {
        $query = new ParentIdQuery('parent_id', 'child_type', ['foo' => 'bar']);

        $this->assertSame(
            [
                'parent_id' => [
                    'id' => 'parent_id',
                    'type' => 'child_type',
                    'foo' => 'bar',
                ],
            ],
            $query->toArray(),
        );
    }
}
