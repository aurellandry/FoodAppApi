<?php

declare(strict_types=1);

namespace Domain\Shared\Tools;

final readonly class Tools
{
    public static function isKeyInEnum(string $key, string $enumName): bool
    {
        try {
            $enum = new \ReflectionEnum($enumName);
            $cases = $enum->getCases();

            foreach ($cases as $case) {
                if ($case->getName() === $key) {
                    return true;
                }
            }
        } catch (\ReflectionException) {
            return false;
        }

        return false;
    }
}
