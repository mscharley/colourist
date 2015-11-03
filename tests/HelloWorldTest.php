<?php

class HelloWorldTest extends PHPUnit_Framework_TestCase
{
  public function testHello()
  {
    if (true) {
      print "Hello world!";
    } else {
      print "Boo!";
    }
  }
}
