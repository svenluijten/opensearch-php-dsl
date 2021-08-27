<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Query\Geo;

use ONGR\ElasticsearchDSL\BuilderInterface;
use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Represents Elasticsearch "geo_shape" query.
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-geo-shape-query.html
 */
class GeoShapeQuery implements BuilderInterface
{
    use ParametersTrait;

    public const INTERSECTS = 'intersects';
    public const DISJOINT = 'disjoint';
    public const WITHIN = 'within';
    public const CONTAINS = 'contains';

    /*
     * Available shape types for addShape() $type param.
     *
     * @link https://www.elastic.co/guide/en/elasticsearch/reference/current/geo-shape.html#input-structure
     */
    public const SHAPE_TYPE_POINT = 'point';
    public const SHAPE_TYPE_LINESTRING = 'linestring';
    public const SHAPE_TYPE_POLYGON = 'polygon';
    public const SHAPE_TYPE_MULTIPOINT = 'multipoint';
    public const SHAPE_TYPE_MULTILINESTRING = 'multilinestring';
    public const SHAPE_TYPE_MULTIPOLYGON = 'multipolygon';
    public const SHAPE_TYPE_GEOMETRYCOLLECTION = 'geometrycollection';
    public const SHAPE_TYPE_ENVELOPE = 'envelope';
    public const SHAPE_TYPE_CIRCLE = 'circle';

    /**
     * @var array
     */
    private $fields = [];

    public function __construct(array $parameters = [])
    {
        $this->setParameters($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): string
    {
        return 'geo_shape';
    }

    /**
     * Add geo-shape provided filter.
     *
     * @param string $field field name
     * @param string $type shape type
     * @param array $coordinates shape coordinates
     * @param string $relation spatial relation
     * @param array $parameters additional parameters
     */
    public function addShape($field, $type, array $coordinates, string $relation = self::INTERSECTS, array $parameters = []): void
    {
        $filter = array_merge(
            $parameters,
            [
                'type' => $type,
                'coordinates' => $coordinates,
            ]
        );

        $this->fields[$field] = [
            'shape' => $filter,
            'relation' => $relation,
        ];
    }

    /**
     * Add geo-shape pre-indexed filter.
     *
     * @param string $field field name
     * @param string $id the ID of the document that containing the pre-indexed shape
     * @param string $type name of the index where the pre-indexed shape is
     * @param string $index index type where the pre-indexed shape is
     * @param string $relation spatial relation
     * @param string $path the field specified as path containing the pre-indexed shape
     * @param array $parameters additional parameters
     */
    public function addPreIndexedShape(
        $field,
        $id,
        $type,
        $index,
        $path,
        string $relation = self::INTERSECTS,
        array $parameters = []
    ): void {
        $filter = array_merge(
            $parameters,
            [
                'id' => $id,
                'type' => $type,
                'index' => $index,
                'path' => $path,
            ]
        );

        $this->fields[$field] = [
            'indexed_shape' => $filter,
            'relation' => $relation,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        $output = $this->processArray($this->fields);

        return [$this->getType() => $output];
    }
}
