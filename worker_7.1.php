<?php

//A good shutdown function that we can let run after alarm signal:
register_shutdown_function(function() {
    echo "a good shutdown function!\n";
});

//A bad shutdown function that we cannot let run after alarm signal:
register_shutdown_function(function() {
    echo "a bad shutdown function!\n";
    sleep(100);
});

pcntl_async_signals(true);

while(true) {

    pcntl_signal(SIGALRM, function () {
        $myPid = getmypid();
        $terminator = __DIR__.'/terminator.php';
        exec("php $terminator $myPid > /dev/null 2>&1 &");

        echo("Alarm: 1 second to run shutdown functions!\n");

        exit(1);
    });

    pcntl_alarm(1);

    echo("1 second to handle the job!\n");

    //A process that may or may not take long
    usleep(rand(1, 1500000));

    echo "Job done\n";
}
















pcntl_alarm(2);

//A long running process
sleep(100);
