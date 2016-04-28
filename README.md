# colourist

[![Build Status](https://travis-ci.org/mscharley/colourist.svg)](https://travis-ci.org/mscharley/colourist)
[![Code Climate](https://codeclimate.com/github/mscharley/colourist/badges/gpa.svg)](https://codeclimate.com/github/mscharley/colourist)
[![Dependency Status](https://gemnasium.com/mscharley/colourist.svg)](https://gemnasium.com/mscharley/colourist)

[![Latest Stable Version](https://poser.pugx.org/mscharley/colourist/v/stable)](https://packagist.org/packages/mscharley/colourist)
[![Total Downloads](https://poser.pugx.org/mscharley/colourist/downloads)](https://packagist.org/packages/mscharley/colourist)

**Source:** [https://github.com/mscharley/colourist](https://github.com/mscharley/colourist)  
**Author:** Matthew Scharley  
**Contributors:** [See contributors on GitHub][gh-contrib]  
**Bugs/Support:** [Github Issues][gh-issues]  
**Copyright:** 2015  
**License:** [MIT license][license]  
**Status:** Active

## Synopsis

`colourist` is a small library for PHP 5.6+ that helps ease working with colours and colour transformations.

## Installation

    $ composer require mscharley/colourist

## Usage

```
$colour = \Colourist\Colour::fromHex('#ffccaa');

// Automatically conversions to calculate values you need.
$h = $colour->hue(); 
$l = $colour->lightness();
$b = $colour->brightness();

// Distinguish between different types of saturation.
$sl = $colour->hslSaturation();
$sb = $colour->hsbSaturation();

// Explicit conversions if you need them. 
$hsl = $colour->toHSL();
$sl == $hsl->saturation();
// Colours are immutable - conversions are highly cached as a result.

// Freely convert between colour spaces as required.
$hsb = $colour->toHSB();
$colour->equals($hsb->toRGB()); // TRUE
```

## Gotchas

```
$colour = \Colourist\Colour::fromHex('#ffccaa');
$colour2 = \Colourist\Colour::fromHex('#aaccff');

// You must use ->equals() for comparing equality.
$colour->equals($colour2); // FALSE
$colour == $colour2; // stack overflow
```

  [gh-contrib]: https://github.com/mscharley/colourist/graphs/contributors
  [gh-issues]: https://github.com/mscharley/colourist/issues
  [license]: https://github.com/mscharley/colourist/blob/master/LICENSE
