<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * ExternalDocumentation object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#external-documentation-object
 */
class ExternalDocumentation extends Base
{
    /**
     * @var string A description of the target documentation. CommonMark syntax MAY be used for rich text representation.
     */
    public ?string $description;

    /**
     * @var string The URL for the target documentation. This MUST be in the form of a URL.
     */
    public string $url;

    /**
     * @param string      $url         The URL for the target documentation. This MUST be in the form of a URL.
     * @param string|null $description A description of the target documentation. CommonMark syntax MAY be used for rich text representation.
     */
    public function __construct(string $url, string $description = null)
    {
        $this->description = $description;
        $this->url = $url;
    }
}