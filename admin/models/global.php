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


class mtwMultipleModelGlobal extends JModel
{
	function __construct()
	{
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}

	function saveConfig( $post ) {

		require_once('components/com_mtwmultiple/helpers/config.php' );
		jimport('joomla.filesystem.file');

        $configFile = JPATH_COMPONENT.'/mtwmultiple_config.php';
        if (JFile::exists( $configFile )) {
			require_once( $configFile );
        }else{
			JFile::copy( $configFile . '.orig', $configFile );
		}
		
		$path = ConfigHelper::removeSlash( $post['path'] );

		$configText = "<?php\n";
		$configText .= "\$mtwCFG['path'] = \"" . $path . "\";\n";
		$configText .= "\$mtwCFG['virtual'] = \"" . $mtwCFG['virtual'] . "\";\n";
		$configText .= "?>\n";

		$return = JFile::write($configFile, $configText);

		return $return;

	}

}
?>
