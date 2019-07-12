<?php

/**
 * @file
 * Contains \Cue\twig_extensions\TwigExtensions.
 */

namespace Cue\twig_extensions;

use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;
use Waiter\WaiterConfig;
use Waiter\WaiterHelper;

/**
 * @implements Twig_ExtensionInterface
 */
class TwigExtensions extends Twig_Extension {

  public function getFunctions() {
    return [
      new Twig_SimpleFunction('asset', [$this, 'getAssetPath'], [
        'needs_environment' => TRUE,
      ]),
    ];
  }

  /**
   * Appends the filemtime to the given asset path to ensure cache invalidation.
   *
   * @param Twig_Environment $env
   *   The current Twig environment.
   * @param $asset_path
   *   The given path to the asset.
   * @param bool $is_versioned
   *   If the asset should be versioned by appending the filemtime.
   *
   * @return string
   */
  public static function getAssetPath(Twig_Environment $env, $asset_path, $is_versioned = TRUE): string {
    $globals = $env->getGlobals();
    $context_publication = $globals['contextPublication'];
    $template_path = realpath($context_publication['templateDir']);
    $asset_abspath = $template_path . '/' . $asset_path;

    if (is_dir($template_path) && is_file($asset_abspath) && $is_versioned) {
      $query_string = http_build_query([
        'v' => filemtime($asset_abspath),
      ]);
      $asset_path = $asset_path . '?' . $query_string;
    }

    return $asset_path;
  }

}
