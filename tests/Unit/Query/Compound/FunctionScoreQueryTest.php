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
use ONGR\ElasticsearchDSL\Search;

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

    /**
     * Match all test
     */
    public function testRandomScore(): void
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addRandomFunction();
        $fquery->addParameter('boost_mode', 'multiply');

        $search = new Search();
        $search->addQuery($fquery);

        $expected = [
            'query' => [
                'function_score' => [
                    'query' => [
                        'match_all' => [],
                    ],
                    'functions' => [
                        0 => [
                            'random_score' => [],
                        ],
                    ],
                    'boost_mode' => 'multiply',
                ],
            ],
        ];

        static::assertEquals($expected, json_decode(json_encode($search->toArray()), true));
    }

    public function testScriptScore(): void
    {
        $fquery = new FunctionScoreQuery(new MatchAllQuery());
        $fquery->addScriptScoreFunction(
            "
            if (doc['price'].value < params.target)
             {
               return doc['price'].value * params.charge;
             }
             return doc['price'].value;
             ",
            [
                'target' => 10,
                'charge' => 0.9,
            ]
        );

        $search = new Search();
        $search->addQuery($fquery);

        $expected = [
            'query' => [
                'function_score' => [
                    'query' => [
                        'match_all' => [],
                    ],
                    'functions' => [
                        0 => [
                            'script_score' => [
                                'script' => [
                                    'lang' => 'painless',
                                    'source' => '
            if (doc[\'price\'].value < params.target)
             {
               return doc[\'price\'].value * params.charge;
             }
             return doc[\'price\'].value;
             ',
                                    'params' => [
                                        'target' => 10,
                                        'charge' => 0.9,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        static::assertEquals($expected, json_decode(json_encode($search->toArray()), true));
    }
}
