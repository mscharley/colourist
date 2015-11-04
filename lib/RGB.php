<?php

namespace Colourist;

use Respect\Validation\Validator as v;

class RGB extends Colour
{
  /** @var float */
  protected $red;
  /** @var float */
  protected $green;
  /** @var float */
  protected $blue;

  /** @var float */
  protected $M;
  /** @var float */
  protected $m;

  const MAX_RGB = 0xff;

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

    // Store normalised values for channels.
    $this->red = $red / self::MAX_RGB;
    $this->green = $green / self::MAX_RGB;
    $this->blue = $blue / self::MAX_RGB;

    // Store some helpful points of interest.
    $this->M = max($this->red, $this->green, $this->blue);
    $this->m = min($this->red, $this->green, $this->blue);
    $this->chroma = $this->M - $this->m;

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
   * Helper to determine the 'darkness' of this colour.
   *
   * Low is dark, high is light. 130 is considered the cutover from dark to
   * light.
   *
   * @return float
   */
  protected function darknessCoefficient()
  {
    return ($this->red() * 299 + $this->green() * 587 + $this->blue() * 114) / 1000;
  }

  /**
   * {@inheritdoc}
   */
  public function isLight()
  {
    return $this->darknessCoefficient() > 130;
  }

  /**
   * {@inheritdoc}
   */
  public function isDark()
  {
    return $this->darknessCoefficient() <= 130;
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
   * @return HSL
   *   The HSL transformation of this colour.
   */
  public function toHsl()
  {
    if (!isset($this->hsl)) {
      $lightness = ($this->M + $this->m) / 2;
      $saturation = $this->chroma === 0 ? 0 : $this->chroma / (1 - abs(2 * $lightness - 1));
      $this->hsl = new HSL($this->calculateHue(), $saturation * 100, $lightness * 100, $this);
    }

    return $this->hsl;
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return RGB
   *   The RGB transformation of this colour.
   */
  public function toHsb()
  {
    if (!isset($this->hsb)) {
      $saturation = $this->chroma === 0 ? 0 : $this->chroma / $this->M;
      $this->hsb = new HSB($this->calculateHue(), $saturation * 100, $this->M * 100, $this);
    }

    return $this->hsb;
  }

  /**
   * @return float
   */
  protected function calculateHue()
  {
    // Chroma could be an integer or a floating point depending on what PHP
    // decides to do.
    if ((is_int($this->chroma) || is_float($this->chroma)) && $this->chroma == 0) {
      return 0;
    }

    if ($this->M === $this->red) {
      $h = fmod(($this->green - $this->blue) / $this->chroma, 6);
    } elseif ($this->M === $this->green) {
      $h = 2 + (($this->blue - $this->red) / $this->chroma);
    } else {
      // Blue is the maximum.
      $h = 4 + (($this->red - $this->green) / $this->chroma);
    }

    return 60 * $h;
  }
}
