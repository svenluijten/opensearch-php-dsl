<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Bucketing;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\BucketingTrait;
use ONGR\ElasticsearchDSL\BuilderInterface;

/**
 * Class representing FilterAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filter-aggregation.html
 */
class FilterAggregation extends AbstractAggregation
{
    use BucketingTrait;

    protected BuilderInterface $filter;

    public function __construct(string $name, BuilderInterface $filter)
    {
        parent::__construct($name);

        $this->setFilter($filter);
    }

    public function setFilter(BuilderInterface $filter): self
    {
        $this->filter = $filter;

        return $this;
    }

    public function getFilter(): BuilderInterface
    {
        return $this->filter;
    }

    /**
     * {@inheritdoc}
     */
    public function setField(?string $field): self
    {
        throw new \LogicException("Filter aggregation, doesn't support `field` parameter");
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return $this->getFilter()->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'filter';
    }
}
