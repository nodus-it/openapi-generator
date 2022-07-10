<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * @see https://spec.openapis.org/oas/v3.1.0#responses-object
 */
class Server extends Base
{
    /**
     * @var string A URL to the target host. This URL supports Server Variables and MAY be relative, to indicate that the host location is relative
     *      to the location where the OpenAPI document is being served. Variable substitutions will be made when a variable is named in {brackets}.
     */
    public string $url;

    /**
     * @var string|null An optional string describing the host designated by the URL. CommonMark syntax MAY be used for rich text representation.
     */
    public ?string $description;

    /**
     * @var ServerVariable|null A map between a variable name and its value. The value is used for substitution in the server's URL template.
     */
    //public ?ServerVariable $serverVariable; ToDO

    /**
     * Erzeugt eine Instanz des Server Objektes
     *
     * @param string      $url         A URL to the target host. This URL supports Server Variables and MAY be relative, to indicate that the host
     *                                 location is relative to the location where the OpenAPI document is being served. Variable substitutions will
     *                                 be made when a variable is named in {brackets}.
     * @param string|null $description An optional string describing the host designated by the URL. CommonMark syntax MAY be used for rich text
     *                                 representation.
     */
    public function __construct(string $url, string $description = null)
    {
        $this->url = $url;
        $this->description = $description;
    }
}
