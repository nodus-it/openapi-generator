<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * Reference object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#reference-object
 */
class Reference extends Base
{
    /**
     * @var string The reference string.
     */
    public string $ref;

    /**
     * @param string $ref The reference string.
     */
    public function __construct(string $ref)
    {
        // ToDo: Validate reference string
        $this->ref = $ref;
    }
}
