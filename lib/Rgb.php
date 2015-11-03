<?php

namespace Colourist;

use Respect\Validation\Validator as v;

class Rgb extends Colour
{
  /** @var float */
  protected $red;
  /** @var float */
  protected $green;
  /** @var float */
  protected $blue;

  // MAX_RGB is the maximum number available in two hex digits.
  const MAX_RGB = 2 ** 8 - 1;

  /**
   * Create a new RGB from the given red, green and blue channels.
   *
   * @param float $red
   *   A value between 0 and 255 for the red channel.
   * @param float $green
   *   A value between 0 and 255 for the green channel.
   * @param float $blue
   *   A value between 0 and 255 for the blue channel.
   * @param Colour $original
   *   A colour that this was transformed from.
   */
  public function __construct($red, $green, $blue, Colour $original = NULL)
  {
    $channel = v::numeric()->numeric()->min(0, TRUE)->max(self::MAX_RGB, TRUE);
    $channel->assert($red);
    $channel->assert($green);
    $channel->assert($blue);

    $this->red = $red / self::MAX_RGB;
    $this->green = $green / self::MAX_RGB;
    $this->blue = $blue / self::MAX_RGB;

    $this->rgb = $this;
    if (isset($original)) {
      $this->hsl = $original->hsl;
      $this->hsb = $original->hsb;
    }
  }

  /**
   * The red component of this RGB.
   *
   * @return int
   *   The red component of this RGB.
   */
  public function red()
  {
    return (int) round($this->red * self::MAX_RGB);
  }

  /**
   * The green component of this RGB.
   *
   * @return int
   *   The green component of this RGB.
   */
  public function green()
  {
    return (int) round($this->green * self::MAX_RGB);
  }

  /**
   * The blue component of this RGB.
   *
   * @return int
   *   The blue component of this RGB.
   */
  public function blue()
  {
    return (int) round($this->blue * self::MAX_RGB);
  }

  /**
   * @inheritDoc
   */
  public function toHex()
  {
    return '#' . sprintf('%02X%02X%02X', $this->red(), $this->green(), $this->blue());
  }

  /**
   * {@inheritdoc}
   */
  public function toRgb()
  {
    return $this;
  }

  /**
   * Convert this colour to an HSL colour.
   *
   * @return Hsl
   *   The HSL transformation of this colour.
   */
  public function toHsl()
  {
    // TODO: Implement toHsl() method.
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  public function toHsb()
  {
    // TODO: Implement toHsb() method.
  }
}
