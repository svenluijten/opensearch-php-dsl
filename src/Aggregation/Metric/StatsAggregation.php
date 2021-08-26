<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Aggregation\Metric;

use ONGR\ElasticsearchDSL\Aggregation\AbstractAggregation;
use ONGR\ElasticsearchDSL\Aggregation\Type\MetricTrait;
use ONGR\ElasticsearchDSL\ScriptAwareTrait;

/**
 * Class representing StatsAggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-stats-aggregation.html
 */
class StatsAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    /**
     * Inner aggregations container init.
     *
     * @param string $name
     * @param string $field
     * @param string $script
     */
    public function __construct($name, $field = null, $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setScript($script);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'stats';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        $out = [];
        if ($this->getField()) {
            $out['field'] = $this->getField();
        }
        if ($this->getScript()) {
            $out['script'] = $this->getScript();
        }

        return $out;
    }
}
