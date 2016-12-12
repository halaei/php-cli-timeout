# A solution to timeout for a php process (works with all versions of PHP)

Create a child process that is responsible for killing its parent after a specified amount of time.
The parent passes its pid (via `getmypid()`) to the child so that the child knows which process to kill.

As soon as the parent's job is done, it should kill the child before the child kills the parent.
This way, the parent can periodically sets up and cancel timeout in an infinite job processing loop.
If the parent runs the child in the background, it can know of the child pid as well by echoing `$!` special variable:

    $childPid = exec('child & echo $!');

The child process can be a tiny script with minimum overhead. No forking is done.

## Example

    $ php worker.php# handling jobs that each may take more than a second, but we don't let them take that long.

## Cons
1. The overhead of exec may be considerable in some use-cases.
2. This solution doesn't give the long taking parent process a chance for cleanup before termination.

# Alternatives

In PHP >= 7.1, SIGARLM together with pcntl_async_signals(true) can be used. The limitation is that you cannot set a timeout inside a SIGALRM handler.
Mixing the new pcntl_async_signals features in PHP 7.1 and the exec-based solution above can eliminate the cons of both solutions.
See `worker_7.1.php`.

For PHP versions < 7.1, SIGALRM with ticks mechanism is also a possibility, but it has considerable overhead and limitations.
