pour lancer les tests  lancer les commandes suivantes:
	Exemple:
		testUnitaire de base:
			Linux : php phpunit-5.7.6.phar --bootstrap Exemple/Mail/Email.php Exemple/Mail/EmailTest.php
			Windows : (Path de php.exe sur wamp) + phpunit-5.7.6.phar --bootstrap Exemple/Mail/Email.php Exemple/Mail/EmailTest.php
				C:\wamp64\bin\php\php7.0.10\php.exe phpunit-5.7.6.phar --bootstrap Exemple/Mail/Email.php Exemple/Mail/EmailTest.php
		testUnitaire Provider:
			php phpunit-5.7.6.phar --bootstrap Exemple/URL/URL.php Exemple/URL/URLTest.php
		testUnitaire simulation base de donne:
			php phpunit-5.7.6.phar --bootstrap Exemple/DB/FixtureTestCase.php Exemple/DB/MyTestCase.php
	

