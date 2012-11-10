<?php
/**
 * Divvy
 *
 * @link      https://github.com/rmasters/divvy
 * @license   https://github.com/rmasters/divvy/blob/master/LICENSE
 * @author    Ross Masters <ross@rossmasters.com>
 */

use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfiguration;

chdir(dirname(__DIR__));

include __DIR__ . '/../init_autoloader.php';

Zend\Mvc\Application::init(include __DIR__ . '/../config/application.config.php');
