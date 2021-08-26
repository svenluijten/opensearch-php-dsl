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

/**
 * Class representing Avg Aggregation.
 *
 * @see http://goo.gl/7KOIwo
 */
class AvgAggregation extends StatsAggregation
{
    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'avg';
    }
}
