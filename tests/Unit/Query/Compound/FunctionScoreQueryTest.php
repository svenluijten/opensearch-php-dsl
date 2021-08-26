<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit\Query\Compound;

use ONGR\ElasticsearchDSL\Query\Compound\FunctionScoreQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;

/**
 * Tests for FunctionScoreQuery.
 *
 * @internal
 */
class FunctionScoreQueryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Data provider for testAddRandomFunction.
     *
     * @return array
     */
    public function addRandomFunctionProvider()
    {
        return [
            // Case #0. No seed.
            [
                'seed' => null,
                'expectedArray' => [
                    'query' => [
                        'match_all' => new \stdClass(),
                    ],
                    'functions' => [
                        [
                            'random_score' => new \stdClass(),
                        ],
                    ],
                ],
            ],
            // Case #1. With seed.
            [
                'seed' => 'someSeed',
                'expectedArray' => [
                    'query' => [
                        'match_all' => new \stdClass(),
                    ],
                    'functions' => [
                        [
                            'random_score' => ['seed' => 'someSeed'],
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Tests addRandomFunction method.
     *
     * @param mixed $seed
     * @param array $expectedArray
     *
     * @dataProvider addRandomFunctionProvider
     */
    public function testAddRandomFunction($seed, $expectedArray): void
    {
        $functionScoreQuery = new FunctionScoreQuery(new MatchAllQuery());
        $functionScoreQuery->addRandomFunction($seed);

        $this->assertEquals(['function_score' => $expectedArray], $functionScoreQuery->toArray());
    }

    /**
     * Tests default argument values.
     */
    public function testAddFieldValueFactorFunction(): void
    {
        $functionScoreQuery = new FunctionScoreQuery(new MatchAllQuery());
        $functionScoreQuery->addFieldValueFactorFunction('field1', 2);
        $functionScoreQuery->addFieldValueFactorFunction('field2', 1.5, 'ln');

        $this->assertEquals(
            [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
                'functions' => [
                    [
                        'field_value_factor' => [
                            'field' => 'field1',
                            'factor' => 2,
                            'modifier' => 'none',
                        ],
                    ],
                    [
                        'field_value_factor' => [
                            'field' => 'field2',
                            'factor' => 1.5,
                            'modifier' => 'ln',
                        ],
                    ],
                ],
            ],
            $functionScoreQuery->toArray()['function_score']
        );
    }
}
