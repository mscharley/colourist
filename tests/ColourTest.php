<?php

class ColourTest extends \PHPUnit\Framework\TestCase
{
  public function testFromHex()
  {
    $colour = \Colourist\Colour::fromHex('#0A141E');
    /** @var \Colourist\RGB $colour */
    $this->assertSame(10, $colour->red());
    $this->assertSame(20, $colour->green());
    $this->assertSame(30, $colour->blue());
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testFromHexNoHash()
  {
    \Colourist\Colour::fromHex('0A141E');
  }

  /**
   * @expectedException \Respect\Validation\Exceptions\AllOfException
   */
  public function testFromHexBadCode()
  {
    \Colourist\Colour::fromHex('oops, this is bad');
  }
}
