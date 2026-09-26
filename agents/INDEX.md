# ./ (project root)

### Directories
**`project`**

| Directory | Summary |
|---|---|
| [src](src/INDEX.md) | The extension source: the `MainModule` bootstrap module, the `Pages/` directory, and `errorMessages.txt`. |
| [prompts](prompts/AGENTS_WORKING_KNOWLEDGE.md) | Agent prompts and the Working Knowledge sub-process instructions. |

## Purpose
`pradosoft/prado-composer-extension` is the minimal template for a PRADO 4.3.3 Composer
extension (composer "type" `prado4-extension`).  PRADO reads the `["extra"]["bootstrap"]`
class from each installed package's `composer.json` (via `vendor/composer/installed.json`,
see `Prado\TApplicationConfiguration::getComposerExtensionBootStraps()`) and instantiates
that class as a module when an application uses the package name as a module id.

## Key files
- `composer.json` — package name, `type`, PSR-4 autoload (`PradoComposerExtension\` → `src`), `extra.bootstrap`, and the dev tool scripts.
- `src/MainModule.php` — the bootstrap module, see [MainModule](src/MainModule.md).
- `tests/test_tools/phpunit_bootstrap.php` — constructs the global `TApplication` from `tests/unit/app` for unit tests.
- `tests/unit/MainModuleTest.php` — unit tests of the bootstrap module.
- `.php-cs-fixer.dist.php`, `phpstan.neon.dist`, `phpunit.xml` — the check configurations, synchronized with PRADO 4.3.3.
- `.github/workflows/prado-composer-extension.yml` — CI: composer validate, php-cs-fixer, phpstan, phpunit on PHP 8.1-8.3.

## PRADO integration points
- `Prado\Util\TPluginModule::init()` attaches `attachPageServiceBehavior` to `TApplication::onBeginRequest`
  and registers `errorMessages.txt` with `TException::addMessageFile()`.
- `TPageService::createPage()` raises `onAdditionalPagePaths` when a page is not in the application
  `BasePath`; each returned path must be within the `Application` path alias (the standard PRADO layout
  installs `vendor/` inside `protected/`, so extension pages qualify).
- The `PluginContentId` application parameter is the `TContent` ID used by extension pages.
