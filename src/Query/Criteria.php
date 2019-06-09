<?php declare(strict_types=1);

namespace App\Query;

/**
 * @property-read string $fieldName
 * @property-read string $operator
 * @property-read string $fieldValue
 */
class Criteria
{
    /**
     * @var string
     */
    public $fieldName;

    /**
     * @var string
     */
    public $operator;

    /**
     * @var string
     */
    public $fieldValue;

    private function __construct(string $fieldName, string $operator, string $fieldValue)
    {
        $this->fieldName = $fieldName;
        $this->operator = $operator;
        $this->fieldValue = $fieldValue;
    }

    public static function equalsTo(string $fieldName, string $filedValue): self
    {
        return new self($fieldName, '=', $filedValue);
    }

    public static function greaterThan(string $fieldName, string $filedValue): self
    {
        return new self($fieldName, '>', $filedValue);
    }
}
