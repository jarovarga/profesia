<?php

declare(strict_types=1);

namespace App\Model\Enum;

use App\src\Model\Traits\EnumOptionsTrait;
use Cake\Database\Type\EnumLabelInterface;
use Cake\Utility\Inflector;

use function App\Model\Enum\__x;

enum UserRole: string implements EnumLabelInterface
{
    use EnumOptionsTrait;

    case Admin = 'admin';
    case Guest = 'guest';

    /**
     * Get the label for the current instance.
     *
     * @return string The label for the current instance.
     */
    public function label(): string
    {
        return $this->generateLabel($this->name);
    }

    /**
     * Generate a label for a given name.
     *
     * @param string $name The name to generate the label for.
     *
     * @return string The generated label.
     */
    private function generateLabel(string $name): string
    {
        return __x('role', Inflector::humanize(Inflector::underscore($name)));
    }
}
