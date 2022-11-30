<?php
/**
 * MainModule class file
 *
 * @author Brad Anderson <belisoful@icloud.com>
 * @link https://github.com/pradosoft/prado-composer-extension
 * @license https://github.com/pradosoft/prado-composer-extension/blob/master/LICENSE
 */
namespace belisoful\PradoComposerExtension;

use Prado\Exceptions\TConfigurationException;
use Prado\TPropertyValue;
use Prado\Util\TPluginModule;

/**
 * MainModule class.
 *
 * main example bootstrap module class
 *
 * @author Brad Anderson <belisoful@icloud.com>
 * @since 1.0.0
 */
class MainModule extends TPluginModule
{
	/** @var null|string property A */
	private $_propertya;
	
	/**
	 * Initializes the module, call the parent:init.
	 * @param null|array|TXmlElement $config
	 */
	public function init($config)
	{
		parent::init($config);
	}
	
	/**
	 * @return null|string gets the Property A from the module
	 */
	public function getPropertyA()
	{
		return $this->_propertya;
	}
	
	/**
	 * @param null|string $v sets the Property A from the module
	 */
	public function setPropertyA($v)
	{
		$this->_propertya = TPropertyValue::ensureString($v);
	}
	
	/**
	 * an example that throws an error message defined in the extensions errorMessages.txt
	 */
	public function throwCustomException()
	{
		throw new TConfigurationException('my_error_condition');
	}
}
