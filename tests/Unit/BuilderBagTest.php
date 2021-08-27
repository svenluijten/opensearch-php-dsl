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

use ONGR\ElasticsearchDSL\BuilderBag;
use ONGR\ElasticsearchDSL\BuilderInterface;
use PHPUnit\Framework\MockObject\MockBuilder;

/**
 * @internal
 */
class BuilderBagTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Tests if bag knows if he has a builder.
     */
    public function testHas(): void
    {
        $bag = new BuilderBag();
        $fooBuilder = $this->getBuilder('foo');
        $builderName = $bag->add($fooBuilder);
        $this->assertTrue($bag->has($builderName));
    }

    /**
     * Tests if bag can remove a builder.
     */
    public function testRemove(): void
    {
        $bag = new BuilderBag();
        $fooBuilder = $this->getBuilder('foo');
        $acmeBuilder = $this->getBuilder('acme');
        $fooBuilderName = $bag->add($fooBuilder);
        $acmeBuilderName = $bag->add($acmeBuilder);

        $bag->remove($fooBuilderName);

        $this->assertFalse($bag->has($fooBuilderName), 'Foo builder should not exist anymore.');
        $this->assertTrue($bag->has($acmeBuilderName), 'Acme builder should exist.');
        $this->assertCount(1, $bag->all());
    }

    /**
     * Tests if bag can clear it's builders.
     */
    public function testClear(): void
    {
        $bag = new BuilderBag(
            [
                $this->getBuilder('foo'),
                $this->getBuilder('baz'),
            ]
        );

        $bag->clear();

        $this->assertEmpty($bag->all());
    }

    /**
     * Tests if bag can get a builder.
     */
    public function testGet(): void
    {
        $bag = new BuilderBag();
        $bazBuilder = $this->getBuilder('baz');
        $builderName = $bag->add($bazBuilder);

        $this->assertNotEmpty($bag->get($builderName));
    }

    /**
     * Returns builder.
     *
     * @param string $name
     *
     * @return MockBuilder|BuilderInterface
     */
    private function getBuilder($name)
    {
        $friendlyBuilderMock = $this->getMockBuilder('ONGR\ElasticsearchDSL\BuilderInterface')
            ->onlyMethods(['toArray', 'getType'])
            ->addMethods(['getName'])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $friendlyBuilderMock
            ->expects($this->any())
            ->method('getName')
            ->willReturn($name)
        ;

        $friendlyBuilderMock
            ->expects($this->any())
            ->method('toArray')
            ->willReturn([])
        ;

        return $friendlyBuilderMock;
    }

    public function testAddWithoutName(): void
    {
        $bag = new BuilderBag();
        $bag->add(new class() implements BuilderInterface {
            public function toArray(): array
            {
                return [];
            }

            public function getType(): string
            {
                return '';
            }
        });

        static::assertSame([], $bag->toArray());
    }

    public function testGetOutOfBounds(): void
    {
        static::expectException(\OutOfBoundsException::class);

        $bag = new BuilderBag();
        $bag->get('test');
    }
}
