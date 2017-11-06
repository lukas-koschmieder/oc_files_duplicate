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
										#error_log("bla", 3, "/tmp/log");
                    $dstNode = $srcNode->copy($dstFullPath);
										$dstNode = $srcNode = $this->userFolder->get($dstInternalPath);
										
										//fileinfo=information of new file
										$fileInfo = array(
											'id' => $dstNode->getId(),
											'name' => $dstNode->getName(),
											'etag' => $dstNode->getEtag(),
											'mimetype'=> $dstNode->getMimetype(),
											'size'=> $dstNode->getSize(),
											'mtime'=> $dstNode->getMtime(),
											'type'=>$dstNode->getType(),
											'permissions'=>$dstNode->getPermissions(),
										);
                } catch (NotPermittedException $exception) {
                    return array('success' => false, 'message' => 'Permission denied');
                }

		return array('success' => true, 'message' => $dstInternalPath, 'info' => $fileInfo);
						//$success= array('success' => true, 'message' => 'File created: ' . $dstInternalPath);
						//$success[] = $success;
		//return $success;
	}
}
