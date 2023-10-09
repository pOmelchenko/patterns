#!/usr/bin/env php
<?php

require_once __DIR__ . '/vendor/autoload.php';


function print_hello_world(): void
{
    echo 'Hello world' . PHP_EOL;
}


#[Attribute(Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
readonly final class dec_without_args {
    public function __invoke(callable $function): callable
    {
        echo 'hello world from decorator without args' . PHP_EOL;

        return $function;
    }
}


#[dec_without_args]
function with_dec_which_has_not_args(): void
{
    echo 'call with_dec_which_has_not_args' . PHP_EOL;
}


#[Attribute(Attribute::TARGET_FUNCTION | Attribute::IS_REPEATABLE)]
readonly final class dec_with_args {
    public function __construct(
        private string $message
    ) {
        // ...
    }

    public function __invoke(callable $function): callable
    {
        echo sprintf('"%s" from decorator with args', $this->message) . PHP_EOL;

        return $function;
    }
}


#[dec_with_args('some message')]
function with_dec_which_has_args(): void
{
    echo 'call with_dec_which_has_args' . PHP_EOL;
}


#[dec_with_args('first')]
#[dec_with_args('second')]
function with_two_decs(): void
{
    echo 'call with_two_decs' . PHP_EOL;
}


#[dec_with_args('first')]
#[dec_with_args('second')]
function with_two_decs_and_args(string $message): void
{
    echo sprintf('call with_two_decs with "%s" in arg', $message) . PHP_EOL;
}


function main(): void
{
    call_user_func_with_decorators('print_hello_world');
    echo PHP_EOL;

    call_user_func_with_decorators('with_dec_which_has_not_args');
    echo PHP_EOL;

    call_user_func_with_decorators('with_dec_which_has_args');
    echo PHP_EOL;

    call_user_func_with_decorators('with_two_decs');
    echo PHP_EOL;

    call_user_func_with_decorators('with_two_decs_and_args', 'some arg');
    echo PHP_EOL;
}


main();
