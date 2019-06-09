<?php declare(strict_types=1);

namespace App\Query;
use function strlen;

class QueryObjectFactory
{
    public const FILTER_PARAM_PREFIX = 'filterBy';

    public const ORDER_PARAM_PREFIX = 'orderBy';

    public static function fromArray(array $params): QueryObject
    {
        $query = new QueryObject();

        foreach ($params as $field => $input) {
            // Set filters
            if (self::inputFieldIsFilter($field)) {
                $fieldName = self::mapFieldNameFromInputFilter($field);
                $query->addCriteria(Criteria::equalsTo($fieldName, $input));

                continue;
            }

            // Set orders
            if (self::inputFieldIsOrder($field)) {
                $fieldName = self::mapFieldNameFromInputOrder($field);
                $query->addOrder(Order::by($fieldName, $input));

                continue;
            }
        }

        $limit = $params['limit'] ?? -1;
        $offset = $params['offset'] ?? 0;

        $query->setLimitAndOffset($limit, $offset);

        return $query;
    }

    private static function inputFieldIsFilter(string $field): bool
    {
        return 0 === strpos($field, self::FILTER_PARAM_PREFIX);
    }

    private static function inputFieldIsOrder(string $field): bool
    {
        return 0 === strpos($field, self::ORDER_PARAM_PREFIX);
    }

    private static function mapFieldNameFromInputFilter(string $field): string
    {
        return strtolower(substr($field, strlen(self::FILTER_PARAM_PREFIX)));
    }

    private static function mapFieldNameFromInputOrder(string $field): string
    {
        return strtolower(substr($field, strlen(self::ORDER_PARAM_PREFIX)));
    }
}
