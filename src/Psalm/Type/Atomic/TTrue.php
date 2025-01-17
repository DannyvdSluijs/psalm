<?php

namespace Psalm\Type\Atomic;

/**
 * Denotes the `true` value type
 */
class TTrue extends TBool
{
    public function __toString(): string
    {
        return 'true';
    }

    public function getKey(bool $include_extra = true): string
    {
        return 'true';
    }

    public function canBeFullyExpressedInPhp(int $analysis_php_version_id): bool
    {
        return false;
    }
}
