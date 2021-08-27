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
 * Class representing Percentile Ranks Aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-metrics-percentile-rank-aggregation.html
 */
class PercentileRanksAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    private array $values;

    public function __construct(string $name, ?string $field, array $values = [], ?string $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setValues($values);
        $this->setScript($script);
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function setValues(array $values): self
    {
        $this->values = $values;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        $out = \array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'values' => $this->getValues(),
            ],
            static function ($val) {
                return $val || \is_numeric($val);
            }
        );

        $this->isRequiredParametersSet($out);

        return $out;
    }

    public function getType(): string
    {
        return 'percentile_ranks';
    }

    private function isRequiredParametersSet(array $out): void
    {
        if (\array_key_exists('values', $out)) {
            if (\array_key_exists('field', $out)) {
                return;
            }

            if (\array_key_exists('script', $out)) {
                return;
            }
        }

        throw new \LogicException('Percentile ranks aggregation must have field and values or script and values set.');
    }
}
