<?php
/**
 * mtwMultiple
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar/
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');


class mtwMultipleModelExtensions extends JModel
{
	function __construct()
	{
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}

	/**
	 * Upload a file
	 *
	 * @since 1.5
	 */
	function upload()
	{
		
		$mainframe = JFactory::getApplication();

		require_once('components/com_mtwmultiple'.DS.'helpers'.DS.'upload.php' );		

		// Check for request forgeries
		//JRequest::checkToken( 'request' ) or jexit( 'Invalid Token' );

		$file 		= JRequest::getVar( 'Filedata', '', 'files', 'array' );
		//$folder		= JRequest::getVar( 'folder', '', '', 'path' );
		$format		= JRequest::getVar( 'format', 'html', '', 'cmd');
		$return		= JRequest::getVar( 'return-url', null, 'post', 'base64' );

		$err		= null;

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');

		// Make the filename safe
		jimport('joomla.filesystem.file');
		$file['name']	= JFile::makeSafe($file['name']);

		if (isset($file['name'])) {
			$filepath = JPath::clean('components/com_mtwmultiple/extensions'.DS.strtolower($file['name']));

			if (!UploadHelper::canUpload( $file, $err )) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = &JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'Invalid: '.$filepath.': '.$err));
					header('HTTP/1.0 415 Unsupported Media Type');
					jexit('Error. Unsupported Media Type!');
				} else {
					JError::raiseNotice(100, JText::_($err));
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return));
					}
					return;
				}
			}

			if (JFile::exists($filepath)) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = &JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'File already exists: '.$filepath));
					header('HTTP/1.0 409 Conflict');
					jexit('Error. File already exists');
				} else {
					JError::raiseNotice(100, JText::_('Error. File already exists'));
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return));
					}
					return;
				}
			}

			if (!JFile::upload($file['tmp_name'], $filepath)) {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = &JLog::getInstance('upload.error.php');
					$log->addEntry(array('comment' => 'Cannot upload: '.$filepath));
					header('HTTP/1.0 400 Bad Request');
					jexit('Error. Unable to upload file');
				} else {
					JError::raiseWarning(100, JText::_('Error. Unable to upload file'));
					// REDIRECT
					if ($return) {
						$mainframe->redirect(base64_decode($return));
					}
					return;
				}
			} else {
				if ($format == 'json') {
					jimport('joomla.error.log');
					$log = &JLog::getInstance();
					$log->addEntry(array('comment' => $folder));
					jexit('Upload complete');
				} else {
					//$mainframe->enqueueMessage(JText::_('Upload complete'));
					// REDIRECT
					//if ($return) {
					//	$mainframe->redirect(base64_decode($return));
					//}
					$this->install($filepath);
					return true;
				}
			}
		} else {
			$mainframe->redirect('index.php', 'Invalid Request', 'error');
		}
	}
	
	/**
	 * Upload a file
	 *
	 * @since 1.5
	 */
	function install($filepath)
	{
		global $mainframe;
		
		//echo $filepath;
		jimport('joomla.installer.helper');
		
		$package = JInstallerHelper::unpack($filepath);
		//print_r($package);

		$files = JFolder::files(JPATH_ADMINISTRATOR.DS.$package['dir'], '\.xml$', 1, true);
		//print_r($files);

		$db =& JFactory::getDBO();


		if (count($files) > 0) {
			foreach ($files as $file) {

				$xml = simplexml_load_file($file);
				//echo $xml->getName() . "<br>";

				if ($xml->getName() == "mosinstall" || $xml->getName() == "install") {
					//print_r($xml);
					//echo $xml["type"];

					$type = $db->quote( $db->getEscaped( $xml["type"] ) );
					$name = $db->quote( $db->getEscaped( $xml->name ) );
					$author = $db->quote( $db->getEscaped( $xml->author ) );
					$creationDate = $db->quote( $db->getEscaped( $xml->creationDate ) );
					$copyright = $db->quote( $db->getEscaped( $xml->copyright ) );
					$license = $db->quote( $db->getEscaped( $xml->license ) );

					// Insert extension
					$query = "INSERT INTO #__mtwmultiple_extensions "
					. " (filename, type, name, author, creationDate, copyright, license, authorEmail, authorUrl, version)"
					. " VALUES ('". basename($filepath) ."', {$type}, {$name}, {$author},"
					. "{$creationDate}, {$copyright}, {$license}, "
					. "'". $xml->authorEmail ."','". $xml->authorUrl ."','". $xml->version ."')";
					$db->setQuery( $query );
					$result = $db->query();				

					echo $query . "<br>";
					echo $xml->getName() . "<br />";
					break;
				}

			}
		}

		jimport('joomla.filesystem.file');
		JFolder::delete(JPATH_ADMINISTRATOR.DS.$package['extractdir']);
	}	
}
?>
