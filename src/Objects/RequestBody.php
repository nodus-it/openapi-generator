<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

class RequestBody extends Base
{
    /**
     * @var string|null A brief description of the request body. This could contain examples of use. CommonMark syntax MAY
     * be used for rich text representation.
     */
    public ?string $description;

    /**
     * @var array[MediaType] The content of the request body. The key is a media type or media type range and the value describes it.
     * For requests that match multiple keys, only the most specific key is applicable. e.g. text/plain overrides text/*
     */
    public array $content;

    /**
     * @var bool Determines if the request body is required in the request
     */
    public bool $required = false;

    public function __construct(array $content, bool $required = false, string $description = null)
    {
        $this->description = $description;
        $this->content = $content;
        $this->required = $required;
    }
}