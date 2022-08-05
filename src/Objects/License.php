<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * License object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#license-object
 */
class License extends Base
{
    /**
     * @var string|null The license name used for the API.
     */
    public ?string $name;

    /**
     * @var string|null An SPDX license expression for the API. The identifier field is mutually exclusive of the url field.
     */
    public ?string $identifier;

    /**
     * @var string|null A URL to the license used for the API. MUST be in the format of a URL.
     */
    public ?string $url;

    /**
     * @param string|null $name The license name used for the API.
     * @param string|null $url  A URL to the license used for the API. MUST be in the format of a URL.
     */
    public function __construct(string $name = null, string $identifier = null, string $url = null)
    {
        $this->name = $name;
        $this->identifier = $identifier;
        $this->url = $url;
    }
}
