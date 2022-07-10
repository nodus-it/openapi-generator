<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * Contact object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#contact-object
 */
class Contact extends Base
{
    /**
     * @var string|null The identifying name of the contact person/organization.
     */
    public ?string $name;

    /**
     * @var string|null The URL pointing to the contact information. MUST be in the format of a URL.
     */
    public ?string $url;

    /**
     * @var string|null The email address of the contact person/organization. MUST be in the format of an email address.
     */
    public ?string $email;

    /**
     * @param string|null $name  The identifying name of the contact person/organization.
     * @param string|null $url   The URL pointing to the contact information. MUST be in the format of a URL.
     * @param string|null $email The email address of the contact person/organization. MUST be in the format of an email address.
     */
    public function __construct(string $name = null, string $url = null, string $email = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->email = $email;
    }
}
