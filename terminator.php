<?php
sleep(1);
posix_kill($argv[1], SIGKILL);
exec("kill -9 {$argv[1]}");
