<?php

require 'utils.php';

use PHPUnit\Framework\TestCase;

class Test1 extends TestCase
{
    public function testP()
    {
        $contenu = "Yo";
        $this->assertEquals('<p>Yo</p>', p($contenu));
    }

    public function testPWithEmptyString()
    {
        $contenu = "";
        $this->assertEquals('', p($contenu));
    }
}


?>