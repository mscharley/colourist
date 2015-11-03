<?php

namespace Colourist;

class Rgb extends Colour
{
  protected $red;
  protected $green;
  protected $blue;

  /**
   * Create a new RGB from the given red, green and blue channels.
   *
   * @param $red
   *   A value between 0 and 255 for the red channel.
   * @param $green
   *   A value between 0 and 255 for the green channel.
   * @param $blue
   *   A value between 0 and 255 for the blue channel.
   */
  public function __construct($red, $green, $blue)
  {
    $this->red = $red;
    $this->green = $green;
    $this->blue = $blue;
  }

  /**
   * {@inheritdoc}
   */
  public function toRgb()
  {
    return $this;
  }
}
