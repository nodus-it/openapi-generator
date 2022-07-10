<?php

namespace Nodus\Packages\OpenApiGenerator\Objects;

/**
 * Base OpenApi object
 */
class Base
{
    /**
     * Converts the object recursively to array
     *
     * @return array
     */
    public function toArray(): array
    {
        $array = (array)$this;
        foreach ($array as $key => $item) {
            if ($item instanceof Base) {
                $array[ $key ] = $item->toArray();
            } elseif (is_array($item)) {
                foreach ($item as $subKey => $subItem) {
                    if ($subItem instanceof Base) {
                        $array[ $key ][ $subKey ] = $subItem->toArray();
                    }
                }
            }
        }

        return array_filter($array);
    }
}
