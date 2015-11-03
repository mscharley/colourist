<?php
/**
 * The Colour class.
 *
 * This is the main intended entry point to the library.
 *
 * @file
 */

namespace Colourist;

use Respect\Validation\Validator as v;

/**
 * Class Colour.
 *
 * @package Colourist
 */
abstract class Colour
{
  protected $rgb = NULL;
  protected $hsl = NULL;
  protected $hsb = NULL;

  /**
   * Lighten this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to lighten this colour by.
   *
   * @return Colour
   *   This colour lightened by a given amount.
   *
   * @see Colour::darken()
   * @see Hsl::lighten()
   */
  public function lighten($amount)
  {
    return $this->toHsl()->lighten($amount);
  }

  /**
   * Darken this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to darken this colour by.
   *
   * @return Colour
   *   This colour darkened by a given amount.
   *
   * @see Colour::lighten()
   * @see Hsl::darken()
   */
  public function darken($amount)
  {
    return $this->toHsl()->darken($amount);
  }

  /**
   * Brighten this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to brighten this colour by.
   *
   * @return Colour
   *   This colour brightened by a given amount.
   *
   * @see Colour::dim()
   * @see Hsb::brighten()
   */
  public function brighten($amount)
  {
    return $this->toHsb()->brighten($amount);
  }

  /**
   * Dim this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to dim this colour by.
   *
   * @return Colour
   *   This colour dimed by a given amount.
   *
   * @see Colour::brighten()
   * @see Hsb::dim()
   */
  public function dim($amount)
  {
    return $this->toHsb()->dim($amount);
  }

  /**
   * Convert this colour to an RGB hexcode.
   *
   * @return string
   */
  public function toHex()
  {
    return $this->toRgb()->toHex();
  }

  /**
   * Convert a hex code to a valid Colour implementation.
   *
   * @param $hex
   *   A hex code starting with '#'.
   *
   * @return Colour
   *   The colour represented by the hex code.
   */
  public static function fromHex($hex)
  {
    v::string()->startsWith('#')->hexRgbColor()->assert($hex);
    $red = $green = $blue = 0;
    sscanf($hex, '#%2x%2x%2x', $red, $green, $blue);
    return new Rgb($red, $green, $blue);
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  abstract public function toRgb();

  /**
   * Convert this colour to an HSL colour.
   *
   * @return Hsl
   *   The HSL transformation of this colour.
   */
  abstract public function toHsl();

  /**
   * Convert this colour to an RGB colour.
   *
   * @return Rgb
   *   The RGB transformation of this colour.
   */
  abstract public function toHsb();

  /**
   * Alias for toHsb().
   *
   * HSV and HSB are the same thing but both names are in wide use, so we
   * provide both
   *
   * @return Hsb
   *   The HSB version of this colour.
   */
  public function toHsv()
  {
    return $this->toHsv();
  }

  /**
   * Convert this colour to a string.
   *
   * @return string
   *   The RGB hexcode for this colour.
   */
  public function __toString()
  {
    return $this->toHex();
  }
}
