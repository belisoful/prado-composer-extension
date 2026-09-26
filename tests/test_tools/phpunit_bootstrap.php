<?php

/**
 * PHPUnit bootstrap for the PRADO Composer Extension unit tests.
 *
 * The Composer autoloader has loaded both the extension (PSR-4 "PradoComposerExtension\")
 * and the PRADO framework ("Prado\").  A global {@see \Prado\TApplication} is constructed,
 * but not run, from the minimal test application at tests/unit/app so that unit tests
 * which require {@see \Prado\Prado::getApplication()} can run.
 */

require_once(__DIR__ . '/../../vendor/autoload.php');

// For unit tests requiring a global TApplication object,
//  construct -which sets {@see Prado::getApplication()}- but do not run
$appPath = realpath(__DIR__ . '/../unit/app');
$application = new \Prado\TApplication($appPath, false);
