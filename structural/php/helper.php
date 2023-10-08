<?php

if (!function_exists('call_user_func_with_decorators')) {
    /**
     * @param callable $function
     * @param array|null $attributes
     * @return callable
     * @throws ReflectionException
     */
    function call_user_func_with_decorators(callable $function, array $attributes = null): callable
    {
        $attributes ??= array_reverse(
            (new ReflectionFunction($function))->getAttributes()
        );

        if ($attributes === []) {
            return $function;
        }

        $attribute = array_shift($attributes);

        if ([] !== $attributes) {
            call_user_func_with_decorators($function, $attributes);
        }

        return $attribute->newInstance()($function);
    }
}
