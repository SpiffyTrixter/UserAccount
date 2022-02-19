<?php

namespace Skeleton;

final class Hello
{
    public function sayHello(string $name = 'World'): string
    {
        return 'Hello ' . $name . '!';
    }
}
