#!/usr/bin/env python3

def print_hello_world():
    print('Hello world')


def dec_without_args(function):
    def dec():
        print('hello world from decorator without args')
        function()

    return dec


@dec_without_args
def with_dec_which_has_not_args():
    print('call with_dec_which_has_not_args')


def dec_with_args(message: str):
    def wrapper(function):
        def dec():
            print(f'"{message}" from decorator with args')
            function()

        return dec
    return wrapper


@dec_with_args('some message')
def with_dec_which_has_args():
    print('call with_dec_which_has_args')


@dec_with_args('first')
@dec_with_args('second')
def with_two_decs():
    print('call with_two_decs')


def main():
    print_hello_world()
    print()

    with_dec_which_has_not_args()
    print()

    with_dec_which_has_args()
    print()

    with_two_decs()
    print()


if __name__ == '__main__':
    main()
