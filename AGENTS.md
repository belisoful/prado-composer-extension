# PRADO Composer Extension Agent Guidelines

## Build, Lint, and Test Commands

### Running Tests
- **All Unit Tests**: `vendor/bin/phpunit --testsuite unit` - runs all unit tests
- **Test Filter**: `vendor/bin/phpunit --testsuite unit --filter <test function, class, or directory>`

### Linting and Code Analysis
- **PHPStan Analysis**: `vendor/bin/phpstan analyse src/ --memory-limit=512M`
- **PHP CS Fixer (Dry-run)**: `vendor/bin/php-cs-fixer fix --dry-run src/` (check)
- **PHP CS Fixer (Fix)**: `vendor/bin/php-cs-fixer fix src/` (apply fixes)

### Build Commands
- **Install Dependencies**: `composer install` - installs all dependencies
- **Updating Dependencies**: `composer update` - updates all dependencies
- **Composer Scripts**: `composer fix`, `composer stan`, `composer unittest`, `composer fulltest`

## Code Style Guidelines
- "if" has a statement block after
- Use php-cs-fixer to correct code styles

### PHP Coding Standards
- Follow PSR-4 autoloading standard
- All PHP files must begin with `<?php` tag (short open tags not allowed)
- Use 1 tab for indentations (no spaces)
- All class properties must be declared with visibility modifiers (public, protected, private)
- Uniform Access Principal - Self Encapsulation is required; for an example see vendor/pradosoft/prado/framework/TApplication.php
- Extract Method → Predicate/Guard Clause (Fowler) is suggested

### Naming Conventions
- Class names: `PascalCase` (eg. `MainModule`); PRADO framework classes are prefixed `T*` (eg. `TComponent`, `TApplication`)
- Method names: `camelCase` (eg. `getComponent`)
- Variables: `camelCase` (eg. `$componentName`)
- Class Constants: `SCREAMING_SNAKE_CASE` (eg. `MAX_RETRY_COUNT`)
- Enumerated Constants: `PascalCase` (eg. `DeepSkyBlue`)
- Class properties: `_camelCase` (eg. `_propertyOfClass`, `_styleFieldNames`)
- Namespace: `PradoComposerExtension\{Module}` for the extension; `Prado\{Module}` for the framework (eg. `Prado\Web\UI\TControl`)
- MasterClass and Template file extension: ".tpl"
- Web Page template file extensions: ".page" with ".php" backing

### Documentation Standards
- All public methods must have PHPDoc comments with:
  - `@param` for parameters
  - `@return` for return values  
  - `@throws` for exceptions
- Classes must have a clear and comprehensive docblock at the top with class description with:
  - Examples, where necessary
  - XML and PHP configuration examples for configurable modules
  - `@author` for attribution
  - `@since` for version
  - `@method` for dynamic events with prefix 'dy-'; which are called (on "$this->dy-") but not defined.
- Inline comments should start with `//`
- Use `?` for single nullable types and in doc blocks
- **`@since` tag** — use the next release version when adding new methods or classes; omit the method tag when it matches the class tag
- All comments and documentation must be: **Present Perfect tense**, **American English**, clear, thorough, and technical
- Method Doc Blocks should be **tight**, and have at minimum one sentence in the description.

### Error Handling
- Use try/catch blocks for operations that can fail
- Throw appropriate PRADO exceptions (`TInvalidDataValueException`, `TInvalidOperationException`, etc.)
- Return false or null for methods that are designed to fail gracefully
- All methods should handle edge cases and validate input parameters
- Extension Exceptions use errorCodes specified in src/errorMessages.txt (`code = message`; `#` and `;` comments are allowed); errorMessages.txt is purely for user information display only.
- src/errorMessages.txt has language specific versions at src/errorMessages-<language code>.txt
- PRADO framework error codes are specified in vendor/pradosoft/prado/framework/Exceptions/messages/messages.txt

### Imports and Includes
- Use PSR-4 autoloading - no manual includes required
- All framework classes are accessed via namespace prefixes
- Third-party libraries are loaded via Composer
- Use proper `use` statements for namespaces at the top of PHP files

### Framework Specific Guidelines
- All components inherit from `TComponent` base class
- `TComponent` has features for dynamic event and extension by attached Behaviors (__call, __callStatic), dynamic properties (__get, __set, __isset, __unset), __clone, __sleep, __wakeup, and _getZappableSleepProps
- Behaviors can be attached to any `TComponent` to alter its behavior and functionality.
- Use the event-driven programming model with events; like `onLoad`, `onInit`, `onPreRender`
- Methods with prefix 'dy' are dynamic events to call attached and active Behaviors; like 'dyShouldContinue', 'dyClone', and 'dyValidate'
- Behaviors and Events are called in Collection Priority order
- Called Dynamic Events must be documented in the class phpdoc with "@method"
- Dynamic event are implemented by attached behaviors not in the calling class
- The first parameter of a dynamic event is always filtered and returned.
- Optional class methods can directly be called on non-behavior classes as "dynamic events"
- Methods with prefix 'fx' are global events that may or may not be automatically registered depending on getAutoGlobalListen(); like 'fxAttachClassBehavior'
- getAutoGlobalListen() is optimized by class hierarchy for utility and performance
- Follow the TApplication Lifecycle: onConfiguration → onInitComplete (at end of TApplication::initApplication) → onBeginRequest → onLoadState → onLoadStateComplete → onAuthentication → onAuthenticationComplete → onAuthorization → onAuthorizationComplete → onPreRunService → runService → onSaveState → onSaveStateComplete → onPreFlushOutput → flushOutput → onEndRequest or onError (both at end of TApplication::run)
- Follow the TPage Lifecycle (via TPageService::runPage): onPreInit → initRecursive → onInitComplete → loadPageState (POST/Callback) → processPostData (POST/Callback) → onPreLoad → loadRecursive → processPostData (POST/Callback) → raiseChangedEvents (POST/Callback) → raisePostBackEvent (POST-only) → processCallbackEvent (Callback-only) → onLoadComplete → preRenderRecursive  onPreRenderComplete → savePageState → onSaveStateComplete → renderControl (GET/POST) → renderCallbackResponse (Callback-only) → unloadRecursive
- XML and PHP is supported for application configuration
- TPageService::onPreRunPage gives PRADO Modules event access to the TPage Lifecycle before it runs
- Web Pages are PHP classes with a ".page" TTemplate file with the same base name
- UI Portlets are PHP classes with a ".tpl" TTemplate file with the same base name
- Data components should support `TActiveRecord` pattern
- All UI controls should have proper template support and state management
- All changes (eg. method param/return types) in point releases must be backward compatible.
- Minor releases can be breaking, but minimize the breakages where possible.
- A full check consists of the 4 checks (in order): `php -l` compile, php-cs-fixer, phpstan, phpunit (all checks must pass successfully)
- A full check must be done for code to be ready for git commit.
- The per directory "<dir_path>/" information is found at "agents/<dir_path>/INDEX.md" to keep the source uncluttered.
- **The current version is 1.0.1. git HEAD is working on version 1.0.2.**
- **The extension targets PRADO 4.3.3 (the `prado-4.3` branch); PRADO's next release version is 4.4.0.**

### Composer Extension Specific Guidelines
- The extension bootstrap module is `src/MainModule.php`, referenced by composer.json `["extra"]["bootstrap"]`, with composer "type" `prado4-extension`.
- The bootstrap module extends `Prado\Util\TPluginModule` (or `Prado\Util\TDbPluginModule` for database extensions).
- An application configures the extension by using the composer package name (containing "/") as the module id, without a `class` attribute.
- Extension pages live in `src/Pages/` and use `<com:TContent ID=<%$ PluginContentId %>>` so applications can place them in their own layout.
- `TPageService` serves additional page paths within the application base path (the `Application` path alias); the standard PRADO application layout installs `vendor/` inside `protected/`.
- Extension error messages live in `src/errorMessages.txt` and are registered by `TPluginModule::init()`.

## Testing Guidelines
- The testing platform is "phpunit"
- All new code must include unit tests
- Unit test functions must comprehensively assert both typical and edge cases
- Maximal code coverage is required
- Test error conditions and exception handling
- Use mock objects where appropriate
- Functional tests should verify complete user workflows
- Tests should be isolated from each other (no shared state)
- The PHPUnit bootstrap (tests/test_tools/phpunit_bootstrap.php) constructs a global `TApplication` from tests/unit/app but does not run it
- When unit testing one or cluster of classes, only run the unit tests for that class or cluster/directory.
- NEVER add/change phpunit command options when unit testing; only run project unit tests as specified
- phpunit DOES NOT have the cli option "--verbose"

## Development Environment
- PHP 8.1 or higher required
- PHP extensions: ctype, dom, intl, json, pcre, spl (required)
- Optional extensions for additional features: apcu, mbstring, openssl, pdo, soap, xsl, zlib
- Composer for dependency management
- Required developer dependencies for code checking: phpunit/phpunit, phpstan/phpstan, friendsofphp/php-cs-fixer
- Presume that project dependencies are installed

## Directory Structure
```
./
├── agents/                     # The Coding Agents Working Knowledge directory
│   ├── prompts/                # Agent prompts and sub-process instructions
│   └── src/                    # Working Knowledge for ./src/
├── src/                        # The Source Code directory
│   ├── Pages/                  # Extension pages (*.page)
│   ├── MainModule.php          # The bootstrap module
│   └── errorMessages.txt       # Extension error codes and messages
├── tests/                      # Test files
│   ├── initdb_*.sql            # Database initialization files
│   ├── test_tools/             # phpunit and phpstan bootstraps
│   └── unit/                   # phpunit tests for './src/' classes; unit/app is the test application
├── AGENTS.md                   # The Agent guidelines for the directory
├── composer.json               # Package configuration
├── HISTORY.md                  # Version History of important changes
├── README.md                   # Documentation
└── vendor/                     # the container for composer dependencies
```
- This is an abbreviated Directory Structure
- All Directories have more files in them than listed

## Cursor/Copilot Instructions
No specific Cursor or Copilot rules currently defined for this project.

# PRADO Framework Agent Safeguards -- ANTI-PATTERNS
Between the next brackets, it is required without exception:
{
- NEVER (without exception) execute the following "git" commands without asking the developer for approval first: clone, checkout, mv, restore, rm, branch, add, commit, merge, rebase, reset, pull, push, fetch
- NEVER (without exception) execute "rm" commands on any paths without asking the developer for approval first
- NEVER remove composer --dev dependencies because those are a required for development on the Project
- NEVER perform an action that erases or overwrites files for the task of unit testing and fixing; file changes are important and must be kept, because the changes themselves are being unit tested.
- NEVER delete any folders or files until the associated task is absolutely and totally complete.
}

# Working Knowledge - Knowledge Retention Sub-Process Instructions
- The goal of "Working Knowledge" is to make Coding Agents more efficient at project tasks.
- The Working Knowledge directory is "agents/" and contain all Project Working Knowledge files.
- The project directory hierarchy of "./" is replicated in "agents/"
- INDEX.md is the main knowledge file of a directory, functioning like CLAUDE.md
- SUMMARY.md is the optimized brief summary of a directory.
- Every class has a knowledge file with the same relative path, ending in ".md"
- If only a brief summary of a directory is needed, read its SUMMARY.md
- If only a summary of a class is needed, read its "<class name>.md"
- Scan for Project Knowledge (via "find agents/ -type f -name '*.md'") and parse relevant knowledge files relating to directories, classes, summaries, processes, and manuals for tasks at hand
- When class files are updated, its directory Working Knowledge files and summaries must be updated.
- When a directory Working Knowledge file is updated, the parent directory Knowledge files and summaries must be recursively updated; start with the deepest directory paths first
- See agents/prompts/AGENTS_WORKING_KNOWLEDGE.md for the INDEX.md, SUMMARY.md, and class knowledge file formats.
