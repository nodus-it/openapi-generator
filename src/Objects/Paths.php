<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * Paths object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#paths-object
 */
class Paths extends Base
{
    /**
     * @var array<PathItem> A relative path to an individual endpoint. The field name MUST begin with a forward slash (/). The path is appended (no
     * relative
     *      URL resolution) to the expanded URL from the Server Object's url field in order to construct the full URL. Path templating is allowed.
     *      When matching URLs, concrete (non-templated) paths would be matched before their templated counterparts. Templated paths with the same
     *      hierarchy but different templated names MUST NOT exist as they are identical. In case of ambiguous matching, it's up to the tooling to
     *      decide which one to use.
     */
    public array $path;

    /**
     * @param array<PathItem> $path A relative path to an individual endpoint. The field name MUST begin with a forward slash (/). The path is
     *                              appended (no relative URL resolution) to the expanded URL from the Server Object's url field in order to
     *                              construct the full URL. Path templating is allowed. When matching URLs, concrete (non-templated) paths would be
     *                              matched before their templated counterparts. Templated paths with the same hierarchy but different templated
     *                              names MUST NOT exist as they are identical. In case of ambiguous matching, it's up to the tooling to decide which
     *                              one to use.
     */
    public function __construct(array $path)
    {
        foreach ($path as $name => $pathItem) {
            $this->{$name} = $pathItem;
        }
    }
}
