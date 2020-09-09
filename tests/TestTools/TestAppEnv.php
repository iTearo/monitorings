<?php

declare(strict_types=1);

namespace TestTools;

abstract class TestAppEnv extends TestEnv
{
    abstract public static function getUsedTables(): array;
}
