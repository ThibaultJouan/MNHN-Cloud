# Log #
* ## Point d'attention :
    * Les paths dans log.php sont fait avec des /, sous windows il faudras surement les transformer en \\\
    * ### Configuration : le logger est configurer en INFO pour le moment. Les autres configurations sont disponnible dans les tests.
		* Pour la prod : remplacer "/var/www/html/" par "/volume1/web/" dans ./config/config.xml
* ## Exemple d'utilisation :
```php
    <?php
        $logger = new Log();
        $log = $logger->getLog();
        $log->warn("warning!");
    ?>

