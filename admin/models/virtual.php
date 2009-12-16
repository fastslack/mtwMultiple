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


class mtwMultipleModelVirtual extends JModel
{
	function __construct()
	{
		parent::__construct();
	}

/*
 * CHECK FOR SECURITY REASONS WHEN VIRTUAL HOST IS SAVED!!!
 */

	function saveConfig( $post ) {

		require_once('components'.DS.'com_mtwmultiple'.DS.'helpers'.DS.'config.php' );
		jimport('joomla.filesystem.file');

        $configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';
        if (JFile::exists( $configFile )) {
			include( $configFile );
        }else{
			JFile::copy( $configFile . '.orig', $configFile );
		}
		
		$virtual = ConfigHelper::removeSlash( $post['vhostpath'] );

		$configText = "<?php\n";
		$configText .= "\$mtwCFG['path'] = \"" . $mtwCFG['path'] . "\";\n";
		$configText .= "\$mtwCFG['virtual'] = \"" . $virtual . "\";\n";
		$configText .= "?>\n";

		$return = JFile::write($configFile, $configText);

		$virtualFile = JPATH_COMPONENT.DS.'mtwmultiple.virtualhost.conf';
		//$return = JFile::write($virtualFile, $post['virtual']);

		return $return;

	}
}
?>
