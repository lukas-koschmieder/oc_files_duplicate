<?php
/**
 * ownCloud - files_duplicate
 * @author Lukas Koschmieder <lukas.koschmieder@rwth-aachen.de>
 * @copyright Lukas Koschmieder 2017
 */

namespace OCA\Files_Duplicate\AppInfo;

use \OCP\AppFramework\App;
use \OCP\IContainer;
use \OCP\Util;

// Register global frontend scripts and styles
Util::addScript('files_duplicate', "files_duplicate");

// Register hook
class Application extends App {
  public function __construct(array $urlParams=array()) {
    parent::__construct('files_duplicate', $urlParams);

    $container = $this->getContainer();
    $container->registerService('userFolder', function (IContainer $c) {
      return $c->query('ServerContainer')->getUserFolder();
    });
  }
}
