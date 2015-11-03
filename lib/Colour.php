<?php
/**
 * The Colour class.
 *
 * This is the main intended entry point to the library.
 *
 * @file
 */

namespace Colourist;

/**
 * Class Colour.
 *
 * @package Colourist
 */
abstract class Colour
{
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
}
