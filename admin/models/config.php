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


class mtwMultipleModelConfig extends JModel
{
	function __construct()
	{
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}


	function saveConfig( $post ) {

		$path = $post['path'];
		$slash = $path[0];
		
		if ($slash == "/" || $slash == "\\") {
			$path = substr($path, 1, strlen($path));	
		}

		$configText = "<?php\n";
		$configText .= "\$mtwCFG['path'] = \"" . $path . "\";\n";
		$configText .= "?>\n";

		jimport('joomla.filesystem.file');

        $configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';

        if (JFile::exists( $configFile )) {
			require_once( $configFile );
        }else{
			JFile::copy( $configFile . '.orig', $configFile );
		}

		$return = JFile::write($configFile, $configText);

		return $return;

	}


}
?>
