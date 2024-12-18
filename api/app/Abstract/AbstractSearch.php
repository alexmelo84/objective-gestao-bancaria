<?php

namespace App\Abstract;

use stdClass;

/**
 * Abstraction for any kind of search
 */
abstract class AbstractSearch
{
    /**
     * @param string $tableName
     */
    public string $tableName;

    /**
     * @param array $fields
     */
    public array $fields;

    /**
     * @param array $parameters
     */
    public array $parameters;

    /**
     * @param array $fields
     * @return void
     */
    protected function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @param array $queryParameters
     * @return void
     */
    protected function setParameters(array $queryParameters): void
    {
        $this->parameters = array_combine(array_keys($queryParameters), array_values($queryParameters));
    }

    /**
     * @return array
     */
    abstract public function executeSearch(): array;
}