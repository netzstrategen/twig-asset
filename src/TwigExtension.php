<?php

/**
 * @file
 * Contains \Netzstrategen\TwigAsset\TwigExtension.
 */

namespace Netzstrategen\TwigAsset;

use Twig_Environment;
use Twig_Extension;
use Twig_ExtensionInterface;
use Twig_SimpleFunction;

class TwigExtension extends Twig_Extension implements Twig_ExtensionInterface {

  public function getFunctions() {
    return [
      new Twig_SimpleFunction('asset', [$this, 'getAssetPath'], [
        'needs_environment' => TRUE,
      ]),
    ];
  }

  /**
   * Appends the modification time to the given asset file path.
   *
   * @param Twig_Environment $env
   *   The current Twig environment.
   * @param string $path
   *   The path to the asset file relative to the Twig environment.
   * @param bool $add_version
   *   Whether to append the file modification time. Defaults to TRUE.
   *
   * @return string
   */
  public static function getAssetPath(Twig_Environment $env, string $path, bool $add_version = TRUE): string {
    $globals = $env->getGlobals();
    $context_publication = $globals['contextPublication'];
    $template_path = realpath($context_publication['templateDir']);
    $absolute_path = $template_path . '/' . $path;

    if ($add_version && file_exists($absolute_path)) {
      $query_string = http_build_query([
        'v' => filemtime($absolute_path),
      ]);
      $path .= '?' . $query_string;
    }

    return $path;
  }

}
