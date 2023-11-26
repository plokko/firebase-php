<?php
namespace Plokko\Firebase\IO;

use ArrayAccess;
use GuzzleHttp\Client;
use JsonSerializable;
use Plokko\Firebase\ServiceAccount;

class DatabaseRules implements JsonSerializable, ArrayAccess
{
    private Database $database;
    private array $rules;

    function __construct(Database $database, array $rules)
    {
        $this->database = $database;
        $this->rules = $rules;
    }

    /**
     * Save current rules to Firebase
     */
    public function saveRules(): void
    {
        $this->database->setRules($this->toArray());
    }

    /**
     * Replace rules with new ones
     * @param array $newRules New rules to apply
     */
    public function setRules(array $newRules): void
    {
        $this->rules = $newRules;
    }

    /**
     * Get current rules as an Array
     * @return array
     */
    function getRules(): array
    {
        return $this->rules;
    }

    /**
     * Get current rules as an Array
     * @return array
     */
    function toArray(): array
    {
        return $this->rules;
    }

    function jsonSerialize(): mixed
    {
        return $this->rules;
    }


    function &__get($path)
    {
        return $this->rules[$path];
    }

    function __set($path, $value)
    {
        $this->rules[$path] = $value;
    }

    function offsetExists($offset): bool
    {
        return isset($this->rules[$offset]);
    }

    function offsetGet($offset): mixed
    {
        return $this->rules[$offset];
    }

    function offsetSet($offset, $value): void
    {
        $this->rules[$offset] = $value;
    }
    function offsetUnset($offset): void
    {
        unset($this->rules[$offset]);
    }
}
