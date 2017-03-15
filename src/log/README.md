# Log #
* ## Point d'attention :
    * Les paths dans log.php sont fait avec des /, sous windows il faudras surement les transformer en \\\
    * ### Configuration : le logger est configurer en INFO pour le moment. Les autres configurations sont disponnible dans les tests.
* ## Exemple d'utilisation :
```php 
    <?php
        $logger = new Log();
        $log = $logger->getLog();
        $log->warn("warning!");
    ?>
        