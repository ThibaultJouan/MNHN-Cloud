<?php
use PHPUnit\Framework\TestCase;
class LogTest extends TestCase
{
    /**
     * @param string $level niveau de l'erreur
     * @param string $erreur contenue de l'erreur
     * @param string $conf configuration du log
     * @param string $expectedResult niveau de l'erreur
     * @dataProvider providerTest
     */
    public function test($level, $erreur, $conf, $expectedResult)
    {
        $factory = new LogFactory();
        $result = $factory->creatLog($level, $erreur, $conf);

        $this->assertEquals($expectedResult, $result);
    }

    public function providerTest()
    {
        return array(

            //test fatal erreur
            array('fatal','erreur fatal','fatal','FATAL - erreur fatal'.PHP_EOL),

            //test error
            array('error','erreur','fatal',''),
            array('error','erreur','error','ERROR - erreur'.PHP_EOL),
            array('fatal','erreur fatal','error','FATAL - erreur fatal'.PHP_EOL),

            //test warn
            array('warn','warning','fatal',''),
            array('warn','warning','error',''),
            array('warn','warning','warn','WARN - warning'.PHP_EOL),
            array('error','erreur','warn','ERROR - erreur'.PHP_EOL),
            array('fatal','erreur fatal','warn','FATAL - erreur fatal'.PHP_EOL),

            //test info
            array('info','information','fatal',''),
            array('info','information','error',''),
            array('info','information','warn',''),
            array('info','information','info','INFO - information'.PHP_EOL),
            array('warn','warning','info','WARN - warning'.PHP_EOL),
            array('error','erreur','info','ERROR - erreur'.PHP_EOL),
            array('fatal','erreur fatal','info','FATAL - erreur fatal'.PHP_EOL),

            //test debug
            array('debug','content debug','fatal',''),
            array('debug','content debug','error',''),
            array('debug','content debug','warn',''),
            array('debug','content debug','info',''),
            array('debug','content debug','debug','DEBUG - content debug'.PHP_EOL),
            array('info','information','debug','INFO - information'.PHP_EOL),
            array('warn','warning','debug','WARN - warning'.PHP_EOL),
            array('error','erreur','debug','ERROR - erreur'.PHP_EOL),
            array('fatal','erreur fatal','debug','FATAL - erreur fatal'.PHP_EOL),
            
            //test trace
            array('trace','content trace','fatal',''),
            array('trace','content trace','error',''),
            array('trace','content trace','warn',''),
            array('trace','content trace','info',''),
            array('trace','content trace','debug',''),
            array('trace','content trace','trace','TRACE - content trace'.PHP_EOL),
            array('debug','content debug','trace','DEBUG - content debug'.PHP_EOL),
            array('info','information','trace','INFO - information'.PHP_EOL),
            array('warn','warning','trace','WARN - warning'.PHP_EOL),
            array('error','erreur','trace','ERROR - erreur'.PHP_EOL),
            array('fatal','erreur fatal','trace','FATAL - erreur fatal'.PHP_EOL),
            

        );
    }
}
?>

