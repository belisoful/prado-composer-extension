# PRADO Composer Extension Analysis

## Overview
This is a minimal base composer extension for the PRADO Framework version 4.3.3 (the `prado-4.3` branch).
It serves as a starting point for creating PRADO extensions that can be installed via Composer.

## Directory Structure
```
prado-composer-extension/
├── agents/                     # Working Knowledge (INDEX.md, SUMMARY.md, class files)
│   ├── prompts/                # Agent prompts and sub-process instructions
│   └── src/                    # Working Knowledge for src/
├── src/
│   ├── MainModule.php          # Main module class
│   ├── Pages/                  # Page templates directory
│   │   └── Example.page        # Example page template
│   └── errorMessages.txt       # Error message definitions
├── tests/                      # Test files
│   ├── test_tools/             # phpunit and phpstan bootstraps
│   ├── unit/                   # Unit test directory
│   │   ├── app/                # Minimal test application (runtime/ is ignored)
│   │   └── MainModuleTest.php  # Unit tests for MainModule
│   └── initdb_*.sql            # Database initialization files
├── composer.json               # Package configuration
├── HISTORY.md                  # Version history
├── README.md                   # Documentation
└── AGENTS.md                   # Agent guidelines
```

## Main Module (MainModule.php)
- Located at `src/MainModule.php`
- Extends `TPluginModule` class from PRADO
- Implements a simple property `PropertyA` with getter/setter methods
- Has a basic `init()` method that calls parent initialization
- Follows PSR-4 autoloading standard with namespace `PradoComposerExtension`
- The module is automatically bootstrapped via composer.json "extra.bootstrap" configuration
- The class docblock documents both the XML and PHP module configuration styles

## Pages Directory
- Contains an example page template `Example.page`
- The page includes a TContent control with ID parameter `PluginContentId`
- This demonstrates how plugin content can be integrated into layouts
- `TPageService::createPage()` only serves additional page paths within the `Application` path alias

## Configuration
- `composer.json` defines:
  - Package name: `pradosoft/prado-composer-extension`
  - Type: `prado4-extension`
  - Autoloading via PSR-4 for `PradoComposerExtension` namespace
  - Requires PHP 8.1 and PRADO Framework `~4.3.3 || dev-prado-4.3`
  - Uses `extra.bootstrap` to specify which class to load as module
  - Scripts `fix`, `stan`, `unittest`, and `fulltest` for the development checks

## Usage Instructions
1. Install via composer: `composer require pradosoft/prado-composer-extension`
2. Configure in PRADO application by adding module to configuration (no `class` attribute):
   ```xml
   <modules>
       <module id="pradosoft/prado-composer-extension" PropertyA='value1' />
   </modules>
   ```
   or in PHP configuration:
   ```php
   'modules' => [
       'pradosoft/prado-composer-extension' => ['properties' => ['PropertyA' => 'value1']],
   ],
   ```
3. Set `PluginContentId` parameter in application config to match layout placeholder, from Application Configuration
4. Access example page at: `http://application/web/index.php?page=Example`

## Testing
- Unit tests located in `tests/unit/` directory
- Uses PHPUnit for testing
- `tests/test_tools/phpunit_bootstrap.php` constructs a global `TApplication` from `tests/unit/app` without running it
- `tests/unit/MainModuleTest.php` covers the module paths, initialization, error messages, page service integration, and `PropertyA`
- The full check is: `php -l`, php-cs-fixer, phpstan (with the PRADO PHPStan extensions), phpunit

## Key Features
- Demonstrates PRADO extension structure
- Shows how to automatically include pages via TPageService
- Includes error message handling (`#` and `;` comments supported since PRADO 4.3.3)
- Implements basic property management
- Follows PRADO Framework conventions and coding standards

## Implementation Notes
- The extension follows PRADO's module system and bootstrap process
- It's designed to be easily extendable by inheritance or modification
- The example page template shows how content can be injected into layouts
- Uses PRADO's built-in property value handling system via TPropertyValue::ensureString()

This extension provides a minimal but complete working example of how to structure a PRADO 4 Composer extension that can be integrated into PRADO applications.
