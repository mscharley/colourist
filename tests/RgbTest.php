<?php

class RgbTest extends PHPUnit_Framework_TestCase
{
  function testGetters() {
    $colour = new \Colourist\Rgb(10, 20, 30);
    $this->assertSame(10, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  function testRounding() {
    $colour = new \Colourist\Rgb(10.5, 20.3, 29.7);
    $this->assertSame(11, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  function testToHex() {
    $colour = new \Colourist\Rgb(10, 20, 30);
    $this->assertSame('#0A141E', $colour->toHex());
  }
}
