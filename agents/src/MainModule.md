# src/MainModule.php

### Directories
[project](../INDEX.md) / [src](INDEX.md) / **`MainModule`**

## Purpose
`PradoComposerExtension\MainModule` is the bootstrap module named in `composer.json`
`["extra"]["bootstrap"]`.  It extends `Prado\Util\TPluginModule`, which:
- attaches `attachPageServiceBehavior` to `TApplication::onBeginRequest`, which in turn attaches
  `additionalPagePaths` to `TPageService::onAdditionalPagePaths` so `src/Pages/*.page` are served;
- registers `src/errorMessages.txt` with `TException::addMessageFile()`.

## Public API
- `init($config)` — calls `TPluginModule::init()`; `$config` is `null|array|TXmlElement`.
- `getPropertyA(): ?string` — the example property, `null` until set.
- `setPropertyA($v)` — stores `TPropertyValue::ensureString($v)`.
- Inherited: `getPluginPath()`, `setPluginPath()`, `getPluginPagesPath()`, `setPluginPagesPath()`,
  `getRelativePagesPath()`, `setRelativePagesPath()`, `getErrorFile()`, `attachPageServiceBehavior()`,
  `additionalPagePaths()`.

## Configuration
XML: `<module id="pradosoft/prado-composer-extension" PropertyA="value1" />` (no `class` attribute).
PHP: `'pradosoft/prado-composer-extension' => ['properties' => ['PropertyA' => 'value1']]`.

## Tests
`tests/unit/MainModuleTest.php` covers construction, composer bootstrap metadata, plugin paths,
`init()` with and without a `Pages/` directory, error message registration and comment parsing,
`attachPageServiceBehavior()` with and without a `TPageService`, `additionalPagePaths()`, and `PropertyA`.
