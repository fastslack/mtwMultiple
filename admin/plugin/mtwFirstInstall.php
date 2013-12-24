<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

/**
 * Example system plugin
 */
class plgSystemmtwFirstInstall extends JPlugin
{
	/**
	 * Constructor
	 *
	 * For php4 compatibility we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @access	protected
	 * @param	object	$subject The object to observe
	 * @param 	array   $config  An array that holds the plugin configuration
	 * @since	1.0
	 */
	function plgSystemmtwFirstInstall( &$subject, $config )
	{
		parent::__construct( $subject, $config );

		// Do some extra initialisation in this constructor if required
	}

	/**
	 * Do something onAfterInitialise 
	 */
	function onAfterInitialise()	{
		global $mainframe;
		
		$my =& JFactory::getUser();
		
		if ($my->id) {
	
			jimport( 'joomla.installer.installer' );
			jimport('joomla.installer.helper');
			$db =& JFactory::getDBO();	
			//print_r($db);
	
			// Get packages to install
			$query = "SELECT fi.*"
			. " FROM #__mtwmultiple_firstinstall AS fi ORDER BY id ASC";

			//echo $query;
			$db->setQuery( $query );
			$rows = $db->loadObjectList();

			foreach ($rows as $p) {
				$filepath = JPATH_SITE.'/tmp/'.$p->filename;
				//print_r($rows);echo "<br>";
				$package = JInstallerHelper::unpack($filepath);
				//echo $package;
				$installer =& JInstaller::getInstance();
				$installer->install($package['dir']);
			
				$query = "DELETE FROM #__mtwmultiple_firstinstall WHERE id = " . $p->id;
				$db->setQuery( $query );
				$db->query();
			}
		}
	}

}
