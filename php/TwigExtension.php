<?php

/**
 * @file
 * Contains \Netzstrategen\TwigAsset\TwigExtension.
 */

namespace Netzstrategen\TwigAsset;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\Extension\ExtensionInterface;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension implements ExtensionInterface {

  public function getFunctions() {
    return [
      new TwigFunction('asset', [$this, 'getAssetPath'], [
        'needs_environment' => TRUE,
      ]),
    ];
  }

  /**
   * Appends the modification time to the given asset file path.
   *
   * @param Environment $env
   *   The current Twig environment.
   * @param string $path
   *   The path to the asset file relative to the Twig environment.
   * @param bool $add_version
   *   Whether to append the file modification time. Defaults to TRUE.
   *
   * @return string
   */
  public static function getAssetPath(Environment $env, string $path, bool $add_version = TRUE): string {
    $globals = $env->getGlobals();
    if (!empty($globals['asset_path_document_root'])) {
      $asset_root = realpath($globals['asset_path_document_root']);
      $absolute_path = $asset_root . '/' . $path;

      if ($add_version && file_exists($absolute_path)) {
        $query_string = http_build_query([
          'v' => filemtime($absolute_path),
        ]);
        $path .= '?' . $query_string;
      }
    }
    if (!empty($globals['asset_url_prefix'])) {
      $path = $globals['asset_url_prefix'] . $path;
    }
    return $path;
  }

}
