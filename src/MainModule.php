<?php

/**
 * MainModule class file
 *
 * @author Brad Anderson <belisoful@icloud.com>
 * @link https://github.com/pradosoft/prado-composer-extension
 * @license https://github.com/pradosoft/prado-composer-extension/blob/master/LICENSE
 */

namespace PradoComposerExtension;

use Prado\TPropertyValue;
use Prado\Util\TPluginModule;

/**
 * MainModule class.
 *
 * MainModule is the example bootstrap module of the PRADO Composer Extension.
 * It extends {@see \Prado\Util\TPluginModule}, which has installed the extension's
 * `Pages/` directory into {@see \Prado\Web\Services\TPageService} through the
 * `onAdditionalPagePaths` event and has registered the extension's `errorMessages.txt`
 * with {@see \Prado\Exceptions\TException::addMessageFile()}.
 *
 * The class has been referenced from the `["extra"]["bootstrap"]` field of the
 * extension's `composer.json`.  PRADO has resolved the module class from the Composer
 * package name when the package name is used as the module id, so the module must be
 * configured without a `class` attribute.
 *
 * XML configuration style:
 * ```xml
 * <modules>
 *   <module id="pradosoft/prado-composer-extension" PropertyA="value1" />
 * </modules>
 * ```
 *
 * PHP configuration style:
 * ```php
 * return [
 *     'modules' => [
 *         'pradosoft/prado-composer-extension' => [
 *             'properties' => [
 *                 'PropertyA' => 'value1',
 *             ],
 *         ],
 *     ],
 * ];
 * ```
 *
 * Extension pages have used the `PluginContentId` application parameter as the ID of
 * their {@see \Prado\Web\UI\WebControls\TContent} so they can be placed into the
 * application's own master layout:
 * ```xml
 * <parameters>
 *   <parameter id="PluginContentId" value="Main" />
 * </parameters>
 * ```
 *
 * @author Brad Anderson <belisoful@icloud.com>
 * @since 1.0.0
 */
class MainModule extends TPluginModule
{
	/** @var ?string property A */
	private $_propertya;

	/**
	 * Initializes the module and has called the parent {@see \Prado\Util\TPluginModule::init()}
	 * to register the extension pages and error messages.
	 * @param null|array|\Prado\Xml\TXmlElement $config the module configuration
	 */
	public function init($config)
	{
		parent::init($config);
	}

	/**
	 * @return ?string the Property A of the module, defaults to null.
	 */
	public function getPropertyA()
	{
		return $this->_propertya;
	}

	/**
	 * @param mixed $v the Property A of the module, ensured as a string.
	 */
	public function setPropertyA($v)
	{
		$this->_propertya = TPropertyValue::ensureString($v);
	}
}
