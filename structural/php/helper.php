<?php

if (!function_exists('call_user_func_with_decorators')) {
    /**
     * @param callable $function
     * @param mixed ...$args
     * @return mixed
     */
    function call_user_func_with_decorators(callable $function, mixed ...$args): mixed
    {
        if (!function_exists('call_user_func_decorators')) {
            function call_user_func_decorators(callable $function, array $attributes = null): callable
            {
                $attributes ??= array_reverse(
                    (new ReflectionFunction($function))->getAttributes()
                );

                if ($attributes === []) {
                    return $function;
                }

                $attribute = array_shift($attributes);

                if ([] !== $attributes) {
                    call_user_func_decorators($function, $attributes);
                }

                return $attribute->newInstance()($function);
            }
        }

        return call_user_func_decorators($function)(...$args);
    }
}
