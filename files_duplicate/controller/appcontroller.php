<?php
/**
 * ownCloud - files_duplicate
 * @author Lukas Koschmieder <lukas.koschmieder@rwth-aachen.de>
 * @copyright Lukas Koschmieder 2017
 */

namespace OCA\Files_Duplicate\Controller;

use \OCP\IRequest;
use \OCP\AppFramework\Controller;
use \OCP\Files\NotPermittedException;

class AppController extends Controller {
	private $userId;
	private $userFolder;

	public function __construct($appName, IRequest $request, $userId, $userFolder){
		parent::__construct($appName, $request);
		$this->userId = $userId;
		$this->userFolder = $userFolder;
	}

        /**
         * @NoAdminRequired
         */
	public function duplicate($dirname, $basename) {
		$srcInternalPath = $dirname . "/" . $basename;
		$dstInternalPath = $this->userFolder->getNonExistingName($srcInternalPath);

		$srcNode = $this->userFolder->get($srcInternalPath);
		$dstFullPath = $this->userFolder->getFullPath($dstInternalPath);

                try {
                    $srcNode->copy($dstFullPath);
                } catch (NotPermittedException $exception) {
                    return array('success' => false, 'message' => 'Permission denied');
                }

		return array('success' => true, 'message' => 'File created: ' . $dstInternalPath);
	}
}
