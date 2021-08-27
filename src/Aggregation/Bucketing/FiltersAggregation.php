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
 * Class representing filters aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-filters-aggregation.html
 */
class FiltersAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var BuilderInterface[]
     */
    private array $filters = [];

    private bool $anonymous = false;

    public function __construct(string $name, array $filters = [], bool $anonymous = false)
    {
        parent::__construct($name);

        $this->setAnonymous($anonymous);

        foreach ($filters as $filterName => $filter) {
            $anonymous ? $this->addFilter($filter) : $this->addFilter($filter, $filterName);
        }
    }

    public function setAnonymous(bool $anonymous): self
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    public function addFilter(BuilderInterface $filter, string $name = ''): self
    {
        if (!$this->anonymous && !$name) {
            throw new \LogicException('In not anonymous filters, filter name must be set.');
        }

        if (!$this->anonymous && $name) {
            $this->filters['filters'][$name] = $filter->toArray();
        } else {
            $this->filters['filters'][] = $filter->toArray();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return $this->filters;
    }

    public function getType(): string
    {
        return 'filters';
    }
}
