# twig-asset
A simple asset extension for twig which appends the file modification time of the referenced asset to ensure the browser cache invalidates once the asset was updated.

**This repository holds the extension for PHP and JS.**

## Installation
### PHP
1. Install package `$ composer require netzstrategen/twig-asset`
2. Require package, set global twig variable and add to the twig environment:
    ```php
      <?php
   
      use Netzstrategen\TwigAsset\TwigExtension as TwigAsset;
      
      $twig->addGlobal('asset_path_document_root', '<path/to/templates>');
      $twig->addExtension(new TwigAsset());
    ``` 

### JS
1. Install package `$ npm install @netzstrategen/twig-asset --save`
2. Require package and set config for document root:  
    ```js
    const TwigAsset = require('@netzstrategen/twig-asset')({
      asset_path_document_root: __dirname,
    });
3. Register the `asset` function in twig:
    ```js
    yourTwigInstance.extendFunction('asset', TwigAsset.asset);
   // alternatively
    for (const name in TwigAsset) {
      yourTwigInstance.extendFunction(name, TwigAsset[name]);
    } 
    ```
   
#### Config parameters
- **asset_path_document_root**: Path to the document root. *Required*
- **add_version**: determine to add the filemtime version query string. *Defaults to `true`*

### Usage
```twig
<link rel="stylesheet" href="{{ asset('/path/from/root.css') }}">
// /path/from/root.css?v=1565339299
```

### 3rd party integrations
- [Fractal](https://fractal.build)
    ```js
      const twigAdapter = require('@netzstrategen/twig-drupal-fractal-adapter');
      const instance = fractal.components.engine(twigAdapter);
      instance.twig.extendFunction('asset', TwigAsset.asset);
    ``` 

### Alternatives
See Symfony for a more sophisticated solution (PHP only):
- [Symfony Asset Component](https://symfony.com/doc/current/components/asset.html)
- [Symfony Encore](https://symfony.com/doc/current/frontend/encore/versioning.html)
