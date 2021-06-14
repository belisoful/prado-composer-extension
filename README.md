PRADO Composer Extension example
=====================================

This is a Minimal base composer extension for PRADO Framework.  This automatically adds the Pages directory to the TPageService::onAdditionalPagePaths and loads the errorMessages.


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

Add the module to the application configuration without the class.  For example, like this:

```xml
<modules>
	<module id="pradosoft/prado-composer-extension" PropertyA='value1' />
</module>
```


Usage
-----

Add the following Application Parameter to your application configuration: PluginContentId. for example like this:

```xml
<parameters>
	<parameer id="PluginContentId" value='my-layout-content-id' />
</parameters>
```

Set the PluginContentId to the name of the main TPlaceholderContent ID of your layout so the plugins can be loaded properly.

Follow the panel link to http://application/web/index.php?page=Example
On the index page you'll see extension specific content.


Extension
---------

The composer.json uses a "type" of "prado4-extension" and will load the class from ["extra"]["bootstrap"] for the module id/package name.  Use these specific parameters and values to designate and use your own prado composer extension.