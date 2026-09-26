PRADO Composer Extension example
=====================================

This is a minimal base composer extension for the [PRADO Framework](https://github.com/pradosoft/prado)
version 4.3.3 (the `prado-4.3` branch).  The extension bootstrap module extends
`Prado\Util\TPluginModule`, which automatically adds the extension `Pages/` directory to
`TPageService::onAdditionalPagePaths` and loads the extension `errorMessages.txt`.


Requirements
------------

- PHP 8.1 or higher
- `pradosoft/prado` 4.3.3 or higher (the `prado-4.3` branch until 4.3.3 is tagged)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist pradosoft/prado-composer-extension "*"
```

or add

```
"pradosoft/prado-composer-extension": "*"
```

to the require section of your `composer.json` file.


Setup
-----

Once the extension is installed, load the extension in your Prado application config by specifying the extension name as a module id.

Add the module to the application configuration without the class; PRADO looks up the class
from the extension `composer.json` `["extra"]["bootstrap"]` field.  A module id containing
a "/" is treated as a composer package name.  For example, in XML:

```xml
<modules>
	<module id="pradosoft/prado-composer-extension" PropertyA='value1' />
</modules>
```

or in a PHP application configuration:

```php
return [
	'modules' => [
		'pradosoft/prado-composer-extension' => [
			'properties' => [
				'PropertyA' => 'value1',
			],
		],
	],
];
```

Specifying a `class` for a composer package module id throws a `TConfigurationException`.


Usage
-----

Add the following Application Parameter to your application configuration: PluginContentId. for example like this:

```xml
<parameters>
	<parameter id="PluginContentId" value='my-layout-content-id' />
</parameters>
```

Set the PluginContentId to the name of the main TContentPlaceHolder ID of your layout so the plugins can be loaded properly.

Follow the panel link to http://application/web/index.php?page=Example
On the index page you'll see extension specific content.

`TPageService` serves additional page paths located within the application base path
(the `Application` path alias).  The standard PRADO application layout installs Composer's
`vendor/` directory inside `protected/`, so extension pages are within that path.


Extension
---------

The composer.json uses a "type" of "prado4-extension" and will load the class from ["extra"]["bootstrap"] for the module id/package name.  Use these specific parameters and values to designate and use your own prado composer extension.

- `src/MainModule.php` is the bootstrap module; add your module properties and events here.
- `src/Pages/` holds the extension pages (`*.page` templates with optional `*.php` classes).
- `src/errorMessages.txt` holds the extension error codes (`code = message`, `#` and `;` comments allowed).
  A language variant, eg. `errorMessages-de.txt`, is loaded when it matches the preferred language.


Development
-----------

Install the development dependencies with `composer install`.  The full check before a
commit consists of the four checks, in order:

```
php -l src/MainModule.php
vendor/bin/php-cs-fixer fix --dry-run src/
vendor/bin/phpstan analyse src/ --memory-limit=512M
vendor/bin/phpunit --testsuite unit
```

The composer scripts `composer fix`, `composer stan`, `composer unittest`, and
`composer fulltest` run the same tools.  The unit tests bootstrap a global `TApplication`
from `tests/unit/app`.
