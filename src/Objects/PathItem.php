<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

class PathItem extends Base
{
    /**
     * @var string|null Allows for an external definition of this path item. The referenced structure MUST be in the format of a Path Item Object. In
     *      case a Path Item Object field appears both in the defined object and the referenced object, the behavior is undefined.
     */
    public ?string $ref;

    /**
     * @var string|null An optional, string summary, intended to apply to all operations in this path.
     */
    public ?string $summary;

    /**
     * @var string|null An optional, string description, intended to apply to all operations in this path. CommonMark syntax MAY be used for rich
     *      text representation.
     */
    public ?string $description;

    /**
     * @var Operation|null A definition of a GET operation on this path.
     */
    public ?Operation $get;

    /**
     * @var Operation|null A definition of a PUT operation on this path.
     */
    public ?Operation $put;

    /**
     * @var Operation|null A definition of a POST operation on this path.
     */
    public ?Operation $post;

    /**
     * @var Operation|null A definition of a DELETE operation on this path.
     */
    public ?Operation $delete;

    /**
     * @var Operation|null A definition of a OPTIONS operation on this path.
     */
    public ?Operation $options;

    /**
     * @var Operation|null A definition of a HEAD operation on this path.
     */
    public ?Operation $head;

    /**
     * @var Operation|null A definition of a PATCH operation on this path.
     */
    public ?Operation $patch;

    /**
     * @var Operation|null A definition of a TRACE operation on this path.
     */
    public ?Operation $trace;

    /**
     * @var array<Server> An alternative server array to service all operations in this path.
     */
    public array $servers;

    /**
     * @var array<Parameter> A list of parameters that are applicable for all the operations described under this path. These parameters can be
     * overridden at
     *      the operation level, but cannot be removed there. The list MUST NOT include duplicated parameters. A unique parameter is defined by a
     *      combination of a name and location. The list can use the Reference Object to link to parameters that are defined at the OpenAPI Object's
     *      components/parameters.
     */
    //public array $parameters; ToDo
}
