<?php

namespace Psalm\Type\Atomic;

use function preg_quote;
use function preg_replace;
use function stripos;
use function strpos;
use function strtolower;

/**
 * Represents an offset of a class constant array.
 */
class TKeyOfClassConstant extends Scalar
{
    /** @var string */
    public $fq_classlike_name;

    /** @var string */
    public $const_name;

    public function __construct(string $fq_classlike_name, string $const_name)
    {
        $this->fq_classlike_name = $fq_classlike_name;
        $this->const_name = $const_name;
    }

    public function getKey(bool $include_extra = true): string
    {
        return 'key-of<' . $this->fq_classlike_name . '::' . $this->const_name . '>';
    }

    public function __toString(): string
    {
        return 'key-of<' . $this->fq_classlike_name . '::' . $this->const_name . '>';
    }

    public function getId(bool $nested = false): string
    {
        return $this->getKey();
    }

    /**
     * @param  array<lowercase-string, string> $aliased_classes
     */
    public function toPhpString(
        ?string $namespace,
        array $aliased_classes,
        ?string $this_class,
        int $analysis_php_version_id
    ): ?string {
        return null;
    }

    public function canBeFullyExpressedInPhp(int $analysis_php_version_id): bool
    {
        return false;
    }

    /**
     * @param array<lowercase-string, string> $aliased_classes
     */
    public function toNamespacedString(
        ?string $namespace,
        array $aliased_classes,
        ?string $this_class,
        bool $use_phpdoc_format
    ): string {
        if ($this->fq_classlike_name === 'static') {
            return 'key-of<static::' . $this->const_name . '>';
        }

        if ($this->fq_classlike_name === $this_class) {
            return 'key-of<self::' . $this->const_name . '>';
        }

        if ($namespace && stripos($this->fq_classlike_name, $namespace . '\\') === 0) {
            return 'key-of<' . preg_replace(
                '/^' . preg_quote($namespace . '\\') . '/i',
                '',
                $this->fq_classlike_name
            ) . '::' . $this->const_name . '>';
        }

        if (!$namespace && strpos($this->fq_classlike_name, '\\') === false) {
            return 'key-of<' . $this->fq_classlike_name . '::' . $this->const_name . '>';
        }

        if (isset($aliased_classes[strtolower($this->fq_classlike_name)])) {
            return 'key-of<'
                . $aliased_classes[strtolower($this->fq_classlike_name)]
                . '::'
                . $this->const_name
                . '>';
        }

        return 'key-of<\\' . $this->fq_classlike_name . '::' . $this->const_name . '>';
    }

    public function getAssertionString(bool $exact = false): string
    {
        return 'mixed';
    }
}
