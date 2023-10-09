<?php

if (!function_exists('call_user_func_with_decorators')) {
    /**
     * @param callable $function
     * @return mixed
     * @throws ReflectionException
     */
    function call_user_func_with_decorators(callable $function, mixed ...$args): mixed
    {
        if (!function_exists('sub_call')) {
            function sub_call(callable $function, array $attributes = null): callable
            {
                $attributes ??= array_reverse(
                    (new ReflectionFunction($function))->getAttributes()
                );

                if ($attributes === []) {
                    return $function;
                }

                $attribute = array_shift($attributes);

                if ([] !== $attributes) {
                    sub_call($function, $attributes);
                }

                return $attribute->newInstance()($function);
            }
        }

        return sub_call($function)(...$args);
    }
}
