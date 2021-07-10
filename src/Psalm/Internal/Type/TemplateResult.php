<?php

namespace Psalm\Internal\Type;

use Psalm\Type\Union;

use function array_map;

class TemplateResult
{
    /**
     * @var array<string, array<string, Union>>
     */
    public $template_types;

    /**
     * @var array<string, array<string, TemplateBound>>
     */
    public $lower_bounds;

    /**
     * @var array<string, array<string, TemplateBound>>
     */
    public $upper_bounds = [];

    /**
     * If set to true then we shouldn't update the template bounds
     *
     * @var bool
     */
    public $readonly = false;

    /**
     * @var list<Union>
     */
    public $upper_bounds_unintersectable_types = [];

    /**
     * @param  array<string, array<string, Union>> $template_types
     * @param  array<string, array<string, Union>> $lower_bounds
     */
    public function __construct(array $template_types, array $lower_bounds)
    {
        $this->template_types = $template_types;

        $this->lower_bounds = array_map(
            function ($type_map) {
                return array_map(
                    function ($type) {
                        return new TemplateBound($type);
                    },
                    $type_map
                );
            },
            $lower_bounds
        );
    }
}
