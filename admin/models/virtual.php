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

    if (!JFolder::exists( JURI::root() . $virtual )) {
			JFolder::create( JPATH_ROOT .DS. $virtual );
    }

		$configText = "<?php\n";
		$configText .= "\$mtwCFG['path'] = \"" . $mtwCFG['path'] . "\";\n";
		$configText .= "\$mtwCFG['virtual'] = \"" . $virtual . "\";\n";
		$configText .= "?>\n";

		$return = JFile::write($configFile, $configText);

		$virtualFile = JPATH_COMPONENT.DS.'mtwmultiple.virtualhost.conf';

		$vh = $_POST['virtual'];
		$vh = str_replace("\\", "", $vh);

		//print_r($vh);
/*
    for($i = 0; $i < strlen($vh); $i++){
        // Pack this number into a 4-byte string
        // (Or multiple one-byte strings, depending on context.)               
        echo "<b>{$vh[$i]}</b> ".ord($vh[$i]) . "<br>";
        //$str .= pack("N",$v);
    }
*/
		$return = JFile::write($virtualFile, $vh);

		return $return;

	}
}
?>
