# ./ Summary
- [src](src/SUMMARY.md): The extension source; `MainModule` (extends `TPluginModule`) is the composer bootstrap module with the example `PropertyA` property, plus `Pages/Example.page` and `errorMessages.txt`.
- `tests/`: `MainModuleTest` unit tests; `test_tools/` bootstraps construct a global `TApplication` from `tests/unit/app`.
- Configuration: `composer.json` (type `prado4-extension`, `extra.bootstrap`), `.php-cs-fixer.dist.php`, `phpstan.neon.dist` (PRADO PHPStan extensions), `phpunit.xml`.
