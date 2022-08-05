<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

class ServerVariableObject extends Base
{
    /**
     * @var array|null An enumeration of string values to be used if the substitution options are from a limited set. The array MUST NOT be empty.
     */
    public ?array $enum = null;

    /**
     * @var string The default value to use for substitution, which SHALL be sent if an alternate value is not supplied. Note this behavior
     * is different than the Schema Object’s treatment of default values, because in those cases parameter values are optional. If the enum
     * is defined, the value MUST exist in the enum’s values.
     */
    public string $default;

    /**
     * @var string An optional description for the server variable. CommonMark syntax MAY be used for rich text representation.
     */
    public string $description;

    public function __construct(string $default, array $enum, string $description)
    {
        $this->enum = $enum;
        $this->default = $default;
        $this->description = $description;
    }
}