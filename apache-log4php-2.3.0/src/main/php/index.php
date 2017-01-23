<html lang="fr">
<head>
<title>Test Log</title>
</head>
<body>
<?php 
    echo "start   ";
    // Insert the path where you unpacked log4php
    include('Logger.php');
     
    // Tell log4php to use our configuration file.
    Logger::configure('config.xml');
     
    // Fetch a logger, it will inherit settings from the root logger
    $log = Logger::getLogger('myLogger');
     
    // Start logging
    $log->trace("My first message.");   // Not logged because TRACE < WARN
    $log->debug("My second message.");  // Not logged because DEBUG < WARN
    $log->info("My third message.");    // Not logged because INFO < WARN
    $log->warn("My fourth message.");   // Logged because WARN >= WARN
    $log->error("My fifth message.");   // Logged because ERROR >= WARN
    $log->fatal("My sixth message.");   // Logged because FATAL >= WARN
    echo "finish";
 ?>
</body>
</html>