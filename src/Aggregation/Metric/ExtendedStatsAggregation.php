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
 * Class representing Extended stats aggregation.
 *
 * @see http://goo.gl/E0PpDv
 */
class ExtendedStatsAggregation extends AbstractAggregation
{
    use MetricTrait;
    use ScriptAwareTrait;

    public function __construct(string $name, ?string $field = null, ?string $sigma = null, ?string $script = null)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setSigma($sigma);
        $this->setScript($script);
    }

    private ?int $sigma;

    public function getSigma(): ?int
    {
        return $this->sigma;
    }

    public function setSigma(?int $sigma): self
    {
        $this->sigma = $sigma;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'extended_stats';
    }

    /**
     * {@inheritdoc}
     */
    public function getArray(): array
    {
        return array_filter(
            [
                'field' => $this->getField(),
                'script' => $this->getScript(),
                'sigma' => $this->getSigma(),
            ],
            static function ($val) {
                return $val || is_numeric($val);
            }
        );
    }
}
