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
  /** @var RGB */
  protected $rgb = NULL;
  /** @var HSL */
  protected $hsl = NULL;
  /** @var HSB */
  protected $hsb = NULL;

  /** @var float */
  protected $chroma;

  private static $percentage;
  public static $bcscale = 10;

  /**
   * Validates that the input is a number and is between 0 and 100 inclusive.
   *
   * @param float $value
   *   The value to validate.
   */
  protected static function validatePercentage(&$value)
  {
    if (!isset(self::$percentage)) {
      self::$percentage = v::numeric()->min(0, TRUE)->max(100, TRUE);
    }

    if (is_numeric($value)) {
      $value = round($value, 3);
    }

    self::$percentage->assert($value);
  }

  /**
   * Helper to do floating point modulus with bcmath.
   *
   * @param string $left_operand
   * @param string $modulus
   * @param int $scale
   *
   * @return string
   *
   * @see bcmod()
   */
  protected static function bcfmod($left_operand, $modulus, $scale = NULL)
  {
    if (!isset($scale)) {
      $scale = ini_get('bcmath.scale');
    }

    $div = bcdiv($left_operand, $modulus, 0);
    return bcsub($left_operand, bcmul($div, $modulus, $scale), $scale);
  }

  /**
   * @return float
   */
  public function chroma()
  {
    return $this->chroma;
  }

  /**
   * Adjust hue of the current colour by a certain amount.
   *
   * @param int $amount
   *   A hue value to add to the current colours hue.
   *
   * @return Colour
   *   This colour with hue adjusted by a given amount.
   */
  public function rotateHue($amount)
  {
    return $this->toHsl()->rotateHue($amount);
  }

  /**
   * Lighten this colour by a certain amount.
   *
   * @param int $amount
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
   * @param int $amount
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
   * Determine if this colour is considered 'light'.
   *
   * @return bool
   *   Whether this is a light colour.
   */
  public function isLight()
  {
    return $this->toRgb()->isLight();
  }

  /**
   * Determine if this colour is considered 'dark'.
   *
   * @return bool
   *   Whether this is a dark colour.
   */
  public function isDark()
  {
    return $this->toRgb()->isDark();
  }

  /**
   * Brighten this colour by a certain amount.
   *
   * @param int $amount
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
   * @param int $amount
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
   * @param string $hex
   *   A hex code starting with '#'.
   *
   * @return Colour
   *   The colour represented by the hex code.
   */
  public static function fromHex($hex)
  {
    v::stringType()->startsWith('#')->hexRgbColor()->assert($hex);
    $red = $green = $blue = 0;
    sscanf($hex, '#%2x%2x%2x', $red, $green, $blue);
    return new RGB($red, $green, $blue);
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return RGB
   *   The RGB transformation of this colour.
   */
  abstract public function toRgb();

  /**
   * Convert this colour to an HSL colour.
   *
   * @return HSL
   *   The HSL transformation of this colour.
   */
  abstract public function toHsl();

  /**
   * Convert this colour to an HSB colour.
   *
   * @return HSB
   *   The HSB transformation of this colour.
   */
  abstract public function toHsb();

  /**
   * Check equality of two different Colour's.
   *
   * This is necessary as PHP's == can cause stack overflows when used
   * with self-referential objects like Colours.
   *
   * @param Colour $other
   *   The other colour that is going to be compared.
   *
   * @return bool
   *   Whether the colour is equal.
   */
  abstract public function equals(Colour $other);

  /**
   * Alias for toHsb().
   *
   * HSV and HSB are the same thing but both names are in wide use, so we
   * provide both.
   *
   * @return HSB
   *   The HSB version of this colour.
   */
  public function toHsv()
  {
    return $this->toHsb();
  }

  /**
   * @return string
   *   A string representing the technical version of this colour, including class.
   */
  abstract public function inspect();

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
