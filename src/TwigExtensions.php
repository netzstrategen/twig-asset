<?php

/**
 * @file
 * Contains \Cue\Twig\TwigExtensions.
 */

namespace Cue\Twig;

use Twig_Extension;

/**
 * @implements Twig_ExtensionInterface
 */
class TwigExtensions extends Twig_Extension {

  /**
   * Returns the extension name.
   *
   * @return string
   *   The extension name.
   */
  public function getName(): string {
    return 'cue_twig_extensions';
  }

}
