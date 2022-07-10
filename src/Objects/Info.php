<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * Info object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#info-object
 */
class Info extends Base
{
    /**
     * @var string The title of the API.
     */
    public string $title;

    /**
     * @var string|null A short description of the API. CommonMark syntax MAY be used for rich text representation.
     */
    public ?string $description;

    /**
     * @var string|null A URL to the Terms of Service for the API. MUST be in the format of a URL.
     */
    public ?string $termsOfService;

    /**
     * @var Contact|null The contact information for the exposed API.
     */
    public ?Contact $contact;

    /**
     * @var License|null The license information for the exposed API.
     */
    public ?License $license;

    /**
     * @var string The version of the OpenAPI document (which is distinct from the OpenAPI Specification version or the API implementation version).
     */
    public string $version;

    /**
     * @param string $title   The title of the API.
     * @param string $version The version of the OpenAPI document (which is distinct from the OpenAPI Specification version or the API implementation
     *                        version).
     */
    public function __construct(string $title, string $version)
    {
        $this->title = $title;
        $this->version = $version;
    }
}
