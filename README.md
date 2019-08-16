# Twig asset()

A simple asset function for Twig, which appends the file modification time of the referenced asset file to ensure the browser reloads the resource when it changes. (cache invalidation)

This repository holds the extension for PHP and JS.


## Installation

### PHP

1. Add the package to your project.
    ```sh
    $ composer require netzstrategen/twig-asset
    ```

2. Add the extension and configuration to your Twig environment.
    ```php
    <?php

    use Netzstrategen\TwigAsset\TwigExtension as TwigAsset;

    $twig->addGlobal('asset_path_document_root', '<path/to/templates>');
    $twig->addExtension(new TwigAsset());
    ``` 

### JS

1. Add the package to your project.
    ```sh
    $ npm install @netzstrategen/twig-asset --save
    ```

2. Load the extension with your configuration in your project.
    ```js
    const TwigAsset = require('@netzstrategen/twig-asset')({
      asset_path_document_root: __dirname,
    });

3. Register the function in your Twig environment:
    ```js
    for (const name in TwigAsset) {
      twig.extendFunction(name, TwigAsset[name]);
    } 
    ```

### Third-party integrations

#### [Fractal](https://fractal.build)

```js
const twigAdapter = require('@netzstrategen/twig-drupal-fractal-adapter');
const instance = fractal.components.engine(twigAdapter);
instance.twig.extendFunction('asset', TwigAsset.asset);
``` 


## Configuration

- `asset_path_document_root` (string, required): Path to the document root.

    Acts as a base path. The path passed to the asset() function will be appended
    to this base path in order to retrieve the file's modification time.

## Usage

```twig
<link rel="stylesheet" href="{{ asset('/path/from/root.css') }}">
```
yields:
```html
<link rel="stylesheet" href="/path/from/root.css?v=1565339299">
```

### Parameters

- `add_version` (bool, optional): Whether to append the file modification time. Defaults to `true`.

    Example:
    ```twig
    <link rel="stylesheet" href="{{ asset('/path/from/root.css', false) }}">
    ```
    yields:
    ```html
    <link rel="stylesheet" href="/path/from/root.css">
    ```


## Alternatives to this package

See Symfony for a more sophisticated solution (PHP only):
- [Symfony Asset Component](https://symfony.com/doc/current/components/asset.html)
- [Symfony Encore](https://symfony.com/doc/current/frontend/encore/versioning.html)
