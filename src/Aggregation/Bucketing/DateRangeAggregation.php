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

/**
 * Class representing date range aggregation.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/search-aggregations-bucket-daterange-aggregation.html
 */
class DateRangeAggregation extends AbstractAggregation
{
    use BucketingTrait;

    /**
     * @var string
     */
    private $format;

    /**
     * @var array
     */
    private $ranges = [];

    /**
     * @var bool
     */
    private $keyed = false;

    /**
     * @param string $name
     * @param string $field
     * @param string $format
     * @param bool $keyed
     */
    public function __construct($name, $field = null, $format = null, array $ranges = [], $keyed = false)
    {
        parent::__construct($name);

        $this->setField($field);
        $this->setFormat($format);
        $this->setKeyed($keyed);
        foreach ($ranges as $range) {
            $from = $range['from'] ?? null;
            $to = $range['to'] ?? null;
            $key = $range['key'] ?? null;
            $this->addRange($from, $to, $key);
        }
    }

    /**
     * Sets if result buckets should be keyed.
     *
     * @param bool $keyed
     *
     * @return DateRangeAggregation
     */
    public function setKeyed($keyed)
    {
        $this->keyed = $keyed;

        return $this;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $format
     */
    public function setFormat($format): void
    {
        $this->format = $format;
    }

    /**
     * Add range to aggregation.
     *
     * @param string|null $from
     * @param string|null $to
     * @param string|null $key
     *
     * @throws \LogicException
     *
     * @return $this
     */
    public function addRange($from = null, $to = null, $key = null)
    {
        $range = array_filter(
            [
                'from' => $from,
                'to' => $to,
                'key' => $key,
            ],
            function ($v) {
                return null !== $v;
            }
        );

        if (empty($range)) {
            throw new \LogicException('Either from or to must be set. Both cannot be null.');
        }

        $this->ranges[] = $range;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getArray()
    {
        if ($this->getField() && !empty($this->ranges)) {
            $data = [
                'field' => $this->getField(),
                'ranges' => $this->ranges,
                'keyed' => $this->keyed,
            ];
            if ($this->getFormat()) {
                $data['format'] = $this->getFormat();
            }

            return $data;
        }
        throw new \LogicException('Date range aggregation must have field and range added.');
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'date_range';
    }
}
