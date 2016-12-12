<?php

$mypid = getmypid();
$terminator = __DIR__.'/terminator.php';
while(true) {
    //We run a terminator process that sends this process a SIGKILL signal
    $terminatorPid = exec("php $terminator $mypid > /dev/null 2>&1 & echo $!");

    echo("1 second to handle the job! Terminator PID: $terminatorPid\n");

    //A process that may or may not take long
    usleep(rand(1, 1500000));

    exec("kill -9 $terminatorPid");
    echo "Job done\n";
}
