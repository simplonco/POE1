<?php

require 'app/autoload.php';

use co\simplon\ViewFactory;
use PHPUnit\Framework\TestCase;

class TestViewFactory extends TestCase
{
    public function testCreateView()
    {
        $f = new ViewFactory();
        $this->assertEquals('<div>Hello world</div>', $f->createView());
    }
}


?>