<?php declare(strict_types=1);

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\ElasticsearchDSL\Tests\Unit;

use ONGR\ElasticsearchDSL\ParametersTrait;

/**
 * Test for ParametersTrait.
 *
 * @internal
 */
class ParametersTraitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var ParametersTrait
     */
    private $parametersTraitMock;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->parametersTraitMock = $this->getMockForTrait('ONGR\ElasticsearchDSL\ParametersTrait');
    }

    /**
     * Tests addParameter method.
     */
    public function testGetAndAddParameter(): void
    {
        static::assertTrue(is_object($this->parametersTraitMock->addParameter('acme', 123)));
        static::assertEquals(123, $this->parametersTraitMock->getParameter('acme'));
        $this->parametersTraitMock->addParameter('bar', 321);
        static::assertEquals(321, $this->parametersTraitMock->getParameter('bar'));
        static::assertTrue(is_object($this->parametersTraitMock->removeParameter('acme')));
    }
}
