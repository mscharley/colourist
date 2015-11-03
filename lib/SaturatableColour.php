<?php

namespace Colourist;

use Respect\Validation\Validator as v;

abstract class SaturatableColour extends Colour
{
  /** @var float */
  protected $saturation;

  /**
   * Saturate this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to saturate this colour by.
   *
   * @return Colour
   *   This colour saturated by a given amount.
   *
   * @see SaturatableColour::desaturate()
   */
  public abstract function saturate($amount);

  /**
   * Desaturate this colour by a certain amount.
   *
   * @param $amount
   *   A percentage to desaturate this colour by.
   *
   * @return Colour
   *   This colour desaturated by a given amount.
   *
   * @see SaturatableColour::saturate()
   */
  public abstract function desaturate($amount);

  /**
   * @return int
   */
  public function saturation()
  {
    return (int) round($this->saturation * 100);
  }
}
