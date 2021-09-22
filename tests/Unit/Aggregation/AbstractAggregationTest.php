<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Tests\Unit\Aggregation;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\NamedBuilderInterface;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class AbstractAggregationTest extends TestCase
{
    public function testGetAggregation(): void
    {
        $subAgg = new NamedTestAggregation('foo_bar');

        $agg = $this->getMockBuilder(AbstractAggregation::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $agg->addAggregation($subAgg);

        $this->assertSame($subAgg, $agg->getAggregation('foo_bar'));
    }

    public function testGetUnavailableAggregation(): void
    {
        $subAgg = new NamedTestAggregation('foo_bar');

        $agg = $this->getMockBuilder(AbstractAggregation::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $agg->addAggregation($subAgg);

        $this->assertNull($agg->getAggregation('invalid'));
    }
}

class NamedTestAggregation extends AbstractAggregation implements NamedBuilderInterface
{
    public function toArray(): array
    {
        return [];
    }

    public function getType(): string
    {
        return 'bar';
    }

    protected function getArray(): array
    {
        return [];
    }

    protected function supportsNesting(): bool
    {
        return false;
    }
}
