
<?php 
//Cree la factory qui va piocher dans les fichier de conf log

//Warn 
//chemin a configurer pour windows

include(__DIR__.'/../../apache-log4php-2.3.0/src/main/php/Logger.php');
class LogFactory
{
    /**
     * @param string $level niveau de l'erreur
     * @param string $erreur contenue de l'erreur
     * @param string $conf configuration du log
     * @return l'erreur contenue dans le fichier 
    */
     public function creatLog($level, $erreur, $conf){
        if(file_exists(__DIR__.'/../TestLog.log')){
            unlink(__DIR__.'/../TestLog.log');
        }

        //WARN
        // possiblement Config\\ pour windows
        $fileConfig = __DIR__.'/Config/'.$this->configFactory($conf);

        Logger::configure($fileConfig);

        // Fetch a logger, it will inherit settings from the root logger
        $log = Logger::getLogger('myLogger');

        //ecris le log demander a son niveau
        switch ($level) {
            case "trace":
                $log->trace($erreur);
                break;
            case "debug":
                $log->debug($erreur);
                break;
            case "info":
                $log->info($erreur);
                break;
            case "warn":
                $log->warn($erreur);
                break;
            case "error":
                $log->error($erreur);
                break;
            case "fatal":
                $log->fatal($erreur);
                break;
        }

        //si rien n'est ecris retourne ''
        if(!file_exists(__DIR__.'/../TestLog.log')){
            return '';
        }

        //sinon renvois la premiere ligne du fichier
        $file    = fopen( __DIR__.'/../TestLog.log', "r" );
        return fgets($file, 4096);
     }

     /**
     * @param string $conf configuration du log
     * @return string nom du fichier de configuration
     */
     private function configFactory($conf){
        switch ($conf) {
            case "trace":
                return "configTraceLog.xml";
            case "debug":
                return "configDebugLog.xml";
            case "info":
                return "configInfoLog.xml";
            case "warn":
                return "configWarnLog.xml";
            case "error":
                return "configErrorLog.xml";
            case "fatal":
                return "configFatalLog.xml";
        }
        return '';
     }
}
?>