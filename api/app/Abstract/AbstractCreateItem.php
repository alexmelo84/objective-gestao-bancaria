<?php

namespace App\Abstract;

/**
 * Abstraction for any kind of item creation
 */
abstract class AbstractCreateItem
{
    /**
     * @param array $requiredFields
     */
    public array $requiredFields;

    /**
     * @param array $input
     * @return bool
     */
    protected function validateFields(array $input): bool
    {
        $validated = true;

        foreach ($this->requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $input)) {
                $validated = false;
            }
        }

        return $validated;
    }
}