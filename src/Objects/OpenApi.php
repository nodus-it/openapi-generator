<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * OpenApi object
 *
 * @see https://spec.openapis.org/oas/v3.1.0#openapi-object
 */
class OpenApi extends Base
{
    /**
     * @var string This string MUST be the semantic version number of the OpenAPI Specification version that the OpenAPI document uses. The openapi
     *      field SHOULD be used by tooling specifications and clients to interpret the OpenAPI document. This is not related to the API info.version
     *      string.
     */
    public string $openapi;

    /**
     * @var Info Provides metadata about the API. The metadata MAY be used by tooling as required.
     */
    public Info $info;

    /**
     * @var string|null The default value for the $schema keyword within Schema Objects contained within this OAS document. This MUST be in the form
     *      of a URI.
     */
    public ?string $jsonSchemaDialect;

    /**
     * @var array<Server> An array of Server Objects, which provide connectivity information to a target server. If the servers property is not
     *      provided, or is an empty array, the default value would be a Server Object with a url value of /.
     */
    public array $servers;

    /**
     * @var Paths The available paths and operations for the API.
     */
    public Paths $paths;

    // ToDo: webhooks,components,security,tags

    /**
     * @var ExternalDocumentation|null Additional external documentation.
     */
    public ?ExternalDocumentation $externalDocs;

    /**
     * @param string $openApi This string MUST be the semantic version number of the OpenAPI Specification version that the OpenAPI document uses.
     *                        The openapi field SHOULD be used by tooling specifications and clients to interpret the OpenAPI document. This is not
     *                        related to the API info.version string.
     * @param Info   $info    Provides metadata about the API. The metadata MAY be used by tooling as required.
     * @param Paths  $paths   The available paths and operations for the API.
     */
    public function __construct(string $openapi, Info $info, Paths $paths)
    {
        $this->openapi = $openapi;
        $this->info = $info;
        $this->paths = $paths;
    }
}
