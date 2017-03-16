# Tests unitaire #

Pour lancer les tests  lancer les commandes suivantes dans le dossier test:
* ## Exemple:
	* ### testUnitaire de base:
		* #### Linux : ```php phpunit-5.7.6.phar --bootstrap Exemple/Mail/Email.php Exemple/Mail/EmailTest.php```
		* #### Windows : ```C:\wamp64\bin\php\php7.0.10\php.exe phpunit-5.7.6.phar --bootstrap Exemple/Mail/Email.php Exemple/Mail/EmailTest.php```
	* ### testUnitaire Provider:
		```php phpunit-5.7.6.phar --bootstrap Exemple/URL/URL.php Exemple/URL/URLTest.php```
	* ### testUnitaire simulation base de donne:
		Pour lancer le test suivant, créer une base de données, et modifier les configs dans le fichier test/TestConfig.php après l'avoir créé dans test/
		```php phpunit-5.7.6.phar --bootstrap Exemple/DB/FixtureTestCase.php Exemple/DB/MyTestCase.php```
	
* ## Log
	* ### testUnitaire:
		```php phpunit-5.7.6.phar --bootstrap Log/LogFactory.php Log/LogTest.php```
	* ### point d'attention:
		* Le design pattern factory est ici utiliser pour configurer le logger.
		* Les path dans LogFactory sont fait avec des / sous windows il faudras surement les transformer en \\\
		
* ## Le contenu du fichier TestConfig.php :
```php
<?php

	class TestConfig{
		const IDENTIFIANT = "";
		const PASSWORD = "";
		const BASE = "";
	}

<<<<<<< HEAD
?>```

ceci est une modification pour un commit de courtoisie
=======
?>```
>>>>>>> master
