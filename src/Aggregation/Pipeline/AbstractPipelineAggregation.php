<?php declare(strict_types=1);

namespace ONGR\ElasticsearchDSL\Aggregation\Pipeline;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;

abstract class AbstractPipelineAggregation extends AbstractAggregation
{
    use MetricTrait;

    /**
     * @var array|string
     */
    private $bucketsPath;

    public function __construct(string $name, $bucketsPath)
    {
        parent::__construct($name);

        $this->setBucketsPath($bucketsPath);
    }

    /**
     * @return array|string
     */
    public function getBucketsPath()
    {
        return $this->bucketsPath;
    }

    /**
     * @param $bucketsPath
     */
    public function setBucketsPath($bucketsPath): self
    {
        $this->bucketsPath = $bucketsPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        return ['buckets_path' => $this->getBucketsPath()];
    }
}
