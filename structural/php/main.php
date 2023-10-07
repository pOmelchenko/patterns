#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';


function print_hello_world(): void
{
    echo 'Hello world' . PHP_EOL;
}


#[Attribute(Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
class dec_without_args {
    public function __invoke(callable $function): void
    {
        echo 'hello world from decorator without args' . PHP_EOL;
        $function();
    }
}


#[dec_without_args]
function with_dec_which_has_not_args(): void
{
    echo 'message from func ' . __FUNCTION__ . PHP_EOL;
}


#[Attribute(Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
class dec_with_args {
    public function __construct(
            private string $message
    ) {
        // ...
    }

    public function __invoke(callable $function): void
    {
        echo "'{$this->message}' from decorator with args" . PHP_EOL;
        $function();
    }
}


#[dec_with_args('some message')]
function with_dec_which_has_args(): void
{
    echo 'message from func ' . __FUNCTION__ . PHP_EOL;
}

#[dec_with_args('some message one')]
#[dec_with_args('some message two')]
function with_two_decs(): void
{
    echo 'message from func ' . __FUNCTION__ . PHP_EOL;
}


if (!function_exists('call_user_func_with_decorator')) {
    function call_user_func_with_decorator(callable $function, mixed ...$args): mixed
    {
        //...
    }
}


function main(): void
{
    echo 'call print_hello_world() function';
    echo PHP_EOL;
    print_hello_world();
    echo PHP_EOL;
    echo PHP_EOL;

    echo 'call with_dec_which_has_not_args() function';
    echo PHP_EOL;
    call_user_func_with_decorator('with_dec_which_has_not_args');
    echo PHP_EOL;
    echo PHP_EOL;

    echo 'call with_dec_which_has_args() function';
    echo PHP_EOL;
    call_user_func_with_decorator('with_dec_which_has_args');
    echo PHP_EOL;
    echo PHP_EOL;

    echo 'call with_two_decs() function';
    echo PHP_EOL;
    call_user_func_with_decorator('with_two_decs');
}


main();
