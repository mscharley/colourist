<?php

namespace Colourist;

use Colourist\Exception\SaturationUnsupportedException;
use Respect\Validation\Validator as v;

class HSL extends SaturatableColour
{
  /** @var float */
  protected $hue;
  /** @var float */
  protected $lightness;

  /**
   * Create a new RGB from the given red, green and blue channels.
   *
   * @param float $hue
   *   Hue is a value between 0 and 360 representing the hue of this colour. If
   *   a number outside this range is provided it will be wrapped to fit inside
   *   this range.
   * @param float $saturation
   *   Saturation of this colour.
   * @param float $lightness
   *   Lightness of this colour.
   * @param Colour $original
   *   A colour that this was transformed from.
   */
  public function __construct($hue, $saturation, $lightness, Colour $original = NULL)
  {
    v::numeric()->assert($hue);
    Colour::validatePercentage($saturation);
    Colour::validatePercentage($lightness);

    $this->hue = self::bcfmod($hue, 360, self::$bcscale);
    if ($this->hue < 0) {
      $this->hue = bcadd($this->hue, 360, self::$bcscale);
    }
    $this->saturation = bcdiv($saturation, 100, self::$bcscale);
    $this->lightness = bcdiv($lightness, 100, self::$bcscale);

    $this->chroma = bcmul($this->saturation, bcsub(1, abs(bcmul(2, $this->lightness, self::$bcscale) - 1), self::$bcscale), self::$bcscale);

    $this->hsl = $this;
    if (isset($original)) {
      $this->rgb = $original->rgb;
      $this->hsb = $original->hsb;
    }
  }

  /**
   * @inheritDoc
   */
  public function lighten($amount)
  {
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation(), $this->lightness() + $amount);
  }

  /**
   * @inheritDoc
   */
  public function darken($amount)
  {
    $this->validatePercentage($amount);
    return new HSL($this->hue(), $this->saturation(), $this->lightness() - $amount);
  }

  /**
   * {@inheritdoc}
   */
  public function saturate($amount)
  {
    $this->validatePercentage($amount);
    if ($this->chroma == 0) {
      throw new SaturationUnsupportedException('Saturation is unsupported for greyscales.');
    }

    return new HSL($this->hue(), $this->saturation() + $amount, $this->lightness());
  }

  /**
   * {@inheritdoc}
   */
  public function desaturate($amount)
  {
    $this->validatePercentage($amount);
    if ($this->chroma == 0) {
      throw new SaturationUnsupportedException('Saturation is unsupported for greyscales.');
    }

    return new HSL($this->hue(), $this->saturation() - $amount, $this->lightness());
  }

  /**
   * {@inheritdoc}
   */
  public function toHsl()
  {
    return $this;
  }

  /**
   * Convert this colour to an RGB colour.
   *
   * @return RGB
   *   The RGB transformation of this colour.
   */
  public function toRgb()
  {
    if (!isset($this->rgb)) {
      $Hd = bcdiv($this->hue, 60, self::$bcscale);
      $m = bcsub($this->lightness, bcdiv($this->chroma, 2, self::$bcscale), self::$bcscale);
      $X = bcmul($this->chroma, bcsub(1, abs(bcsub(self::bcfmod($Hd, 2, self::$bcscale), 1, self::$bcscale)), self::$bcscale), self::$bcscale);

      if ($Hd < 1) {
        list($red, $green, $blue) = [$this->chroma, $X, 0];
      } elseif ($Hd < 2) {
        list($red, $green, $blue) = [$X, $this->chroma, 0];
      } elseif ($Hd < 3) {
        list($red, $green, $blue) = [0, $this->chroma, $X];
      } elseif ($Hd < 4) {
        list($red, $green, $blue) = [0, $X, $this->chroma];
      } elseif ($Hd < 5) {
        list($red, $green, $blue) = [$X, 0, $this->chroma];
      } else {
        list($red, $green, $blue) = [$this->chroma, 0, $X];
      }

      $this->rgb = new RGB(
          bcmul(bcadd($red, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          bcmul(bcadd($green, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          bcmul(bcadd($blue, $m, self::$bcscale), RGB::MAX_RGB, self::$bcscale),
          $this
      );
    }

    return $this->rgb;
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
      $this->hsb = $this->toRgb()->toHsb();
    }

    return $this->hsb;
  }

  /**
   * @return int
   */
  public function hue()
  {
    return (int) round($this->hue);
  }

  /**
   * @return int
   */
  public function lightness()
  {
    return (int) round(bcmul($this->lightness, 100, self::$bcscale));
  }
}
