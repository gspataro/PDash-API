<?php

namespace GSpataro\Validation\Rule;

use GSpataro\Validation\Rule;

final class RequiredRule extends Rule
{
    public static function validate(mixed $value, array $params = []): array
    {
        if (is_null($value) || strlen(trim($value)) < 1) {
            return self::prepareResponse(true, "required", "set", "null_or_empty");
        }

        return self::prepareResponse(false);
    }
}
