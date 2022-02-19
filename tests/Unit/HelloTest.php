<?php

namespace SkeletonTest\Unit;

use Skeleton\Hello;
use PHPUnit\Framework\TestCase;

final class HelloTest extends TestCase
{
    public function testSayHelloWorld(): void
    {
        $hello = new Hello();
        $this->assertEquals('Hello World!', $hello->sayHello());
    }

    public function testSayHelloName(): void
    {
        $hello = new Hello();
        $this->assertEquals('Hello Max!', $hello->sayHello('Max'));
    }
}
