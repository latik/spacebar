<?php declare(strict_types=1);

namespace App\Query;

/**
 * @property-read string $fieldName
 * @property-read string $type
 */
class Order
{
    public const ASC = 'asc';

    public const DESC = 'desc';

    /**
     * @var string
     */
    public $fieldName;

    /**
     * ASC|DESC.
     * @var string
     */
    public $type;

    /**
     * @param string $fieldName
     * @param string $type
     */
    private function __construct(string $fieldName, string $type)
    {
        $this->fieldName = $fieldName;
        $this->type = $type;
    }

    public static function by(string $fieldName, string $type)
    {
        return new self($fieldName, $type);
    }
}
