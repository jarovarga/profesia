<?php

declare(strict_types=1);

namespace App\Model\Traits;

use BackedEnum;
use Cake\Database\Type\EnumLabelInterface;

/**
 * @mixin BackedEnum&EnumLabelInterface
 */
trait EnumOptionsTrait
{
    /**
     * Returns an array of options based on the provided cases.
     *
     * If no cases are provided, it generates the options for all cases.
     * If cases are provided, it generates the options for the input cases.
     *
     * @param array $cases The array of cases (optional)
     *
     * @return array The array of options
     */
    public static function options(array $cases = []): array
    {
        if (empty($cases)) {
            return static::generateOptionsForAllCases();
        }

        return static::generateOptionsForInputCases($cases);
    }

    /**
     * Generates options for input cases.
     *
     * @param array $cases The input cases.
     *
     * @return array The generated options.
     */
    private static function generateOptionsForInputCases(array $cases): array
    {
        $options = [];

        foreach ($cases as $case) {
            $case = static::validateAndTransformCase($case);
            $options[(string) $case->value] = $case->label();
        }

        return $options;
    }

    /**
     * Generates options for all cases.
     *
     * @return array Returns an array of options where the key is the string value of each case and the value is the label of each case.
     */
    private static function generateOptionsForAllCases(): array
    {
        $options = [];

        foreach (static::cases() as $case) {
            $options[(string) $case->value] = $case->label();
        }

        return $options;
    }

    /**
     * Validates and transforms the given case.
     *
     * @param mixed $case The case to be validated and transformed.
     *
     * @return mixed The validated and transformed case.
     */
    private static function validateAndTransformCase(mixed $case): mixed
    {
        if (!($case instanceof BackedEnum)) {
            $case = static::from($case);
        }

        return $case;
    }
}
