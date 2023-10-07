def print_hello_world():
    print('Hello world')


def dec_without_args(function):
    def dec():
        print('hello world from decorator without args')
        function()

    return dec


@dec_without_args
def with_dec_which_has_not_args():
    pass


def dec_with_args(message: str):
    def wrapper(function):
        def dec():
            print(f'"{message}" from decorator with args')

        return dec
    return wrapper


@dec_with_args('some message')
def with_dec_which_has_args():
    pass


def main():
    print_hello_world()

    with_dec_which_has_not_args()

    with_dec_which_has_args()


if __name__ == '__main__':
    main()
