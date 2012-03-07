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

jimport('joomla.application.component.modellist');

class mtwMultipleModelSites extends JModelList
{
	function __construct()
	{
		parent::__construct();

		jimport('joomla.application.component.model');
		jimport('joomla.filesystem.file');

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}


	function addSiteFiles( $post ) {
    
		$mainframe = JFactory::getApplication();

		// Load the parameters.
		$params = &JComponentHelper::getParams( 'com_mtwmultiple' );

    /* Insert into Database */
    $my =& JFactory::getUser();      
    $db =& JFactory::getDBO();
    
    jimport('joomla.user.helper');
    $adminPassword	= $post['password'];

		// Create random salt/password for the admin user
		$salt = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($adminPassword, $salt);
		$cryptpass = $crypt.':'.$salt;

		$query = "INSERT INTO #__mtwmultiple_sites (name, title, email, created_by, created, password)"
		." VALUES ('" . $post['name'] . "', '" . $post['title'] . "', '" . $post['email'] . "', " . $my->id . ", NOW(), " .$db->Quote($cryptpass)." )";
		$db->setQuery( $query );

		if (!$db->query()) {
			return $db->getErrorMsg();
		}

    /* Create Joomla Installation */
    $query = "SELECT id FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
    $db->setQuery( $query );
    $siteID = $db->loadResult();

    $sitesPath = JPATH_SITE.DS.$params->get( 'path' );
    $newSitePath = $sitesPath .DS. $siteID;

    if (!JFolder::exists( $sitesPath )) {              
      JFolder::create( $sitesPath );
    }

		// Create the directory of the installation
    JFolder::create( $newSitePath);
		// Symlink the title to the installation directory 
		symlink ( $siteID, $sitesPath.DS.$post['title'] );

    /* index.php and index2.php */
    JFile::copy( JPATH_SITE .DS. 'index.php', $newSitePath.DS.'index.php');

    /* Administrator Files */
    JFolder::create( $newSitePath.DS.'administrator');
    JFolder::create( $newSitePath.DS.'administrator/backups');
    JFile::copy( JPATH_SITE .DS. 'cache/index.html', $newSitePath.DS.'administrator/backups/index.html');
    JFolder::create( $newSitePath.DS.'administrator/cache');
    JFile::copy( JPATH_SITE .DS. 'cache/index.html', $newSitePath.DS.'administrator/cache/index.html');
    JFolder::create( $newSitePath.DS.'administrator/components');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_admin', $newSitePath .DS. 'administrator/components/com_admin');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_banners', $newSitePath .DS. 'administrator/components/com_banners');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_cache', $newSitePath .DS. 'administrator/components/com_cache');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_categories', $newSitePath .DS. 'administrator/components/com_categories');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_checkin', $newSitePath .DS. 'administrator/components/com_checkin');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_config', $newSitePath .DS. 'administrator/components/com_config');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_contact', $newSitePath .DS. 'administrator/components/com_contact');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_content', $newSitePath .DS. 'administrator/components/com_content');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_cpanel', $newSitePath .DS. 'administrator/components/com_cpanel');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_finder', $newSitePath .DS. 'administrator/components/com_finder');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_installer', $newSitePath .DS. 'administrator/components/com_installer');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_languages', $newSitePath .DS. 'administrator/components/com_languages');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_login', $newSitePath .DS. 'administrator/components/com_login');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_media', $newSitePath .DS. 'administrator/components/com_media');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_menus', $newSitePath .DS. 'administrator/components/com_menus');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_messages', $newSitePath .DS. 'administrator/components/com_messages');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_modules', $newSitePath .DS. 'administrator/components/com_modules');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_newsfeeds', $newSitePath .DS. 'administrator/components/com_newsfeeds');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_plugins', $newSitePath .DS. 'administrator/components/com_plugins');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_search', $newSitePath .DS. 'administrator/components/com_search');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_templates', $newSitePath .DS. 'administrator/components/com_templates');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_users', $newSitePath .DS. 'administrator/components/com_users');
    symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_weblinks', $newSitePath .DS. 'administrator/components/com_weblinks');
    symlink ( JPATH_ADMINISTRATOR .DS. 'help', $newSitePath .DS. 'administrator/help');
    symlink ( JPATH_ADMINISTRATOR .DS. 'images', $newSitePath .DS. 'administrator/images');
    symlink ( JPATH_ADMINISTRATOR .DS. 'includes', $newSitePath .DS. 'administrator/includes');
    JFile::copy( JPATH_ADMINISTRATOR .DS. 'index.php', $newSitePath.DS.'administrator/index.php');
    JFolder::copy( JPATH_ADMINISTRATOR .DS. 'language/', $newSitePath.DS.'administrator/language/');
    //symlink ( JPATH_ADMINISTRATOR .DS. 'language/index.html', $newSitePath .DS. 'administrator/language/index.html');
    //symlink ( JPATH_ADMINISTRATOR .DS. 'language/en-GB', $newSitePath .DS. 'administrator/language/en-GB');
    symlink ( JPATH_ADMINISTRATOR .DS. 'modules', $newSitePath .DS. 'administrator/modules');
    // Admin Templates
    JFolder::copy( JPATH_ADMINISTRATOR .DS. 'templates/', $newSitePath.DS.'administrator/templates/');


    /* Site Components Files */
    JFolder::create( $newSitePath.DS.'components');
    symlink ( JPATH_SITE .DS. 'components/com_banners', $newSitePath .DS. 'components/com_banners');
    symlink ( JPATH_SITE .DS. 'components/com_contact', $newSitePath .DS. 'components/com_contact');
    symlink ( JPATH_SITE .DS. 'components/com_content', $newSitePath .DS. 'components/com_content');
    symlink ( JPATH_SITE .DS. 'components/com_mailto', $newSitePath .DS. 'components/com_mailto');
    symlink ( JPATH_SITE .DS. 'components/com_media', $newSitePath .DS. 'components/com_media');
    symlink ( JPATH_SITE .DS. 'components/com_newsfeeds', $newSitePath .DS. 'components/com_newsfeeds');
    symlink ( JPATH_SITE .DS. 'components/com_poll', $newSitePath .DS. 'components/com_poll');
    symlink ( JPATH_SITE .DS. 'components/com_search', $newSitePath .DS. 'components/com_search');
    symlink ( JPATH_SITE .DS. 'components/com_user', $newSitePath .DS. 'components/com_users');
    symlink ( JPATH_SITE .DS. 'components/com_weblinks', $newSitePath .DS. 'components/com_weblinks');
    symlink ( JPATH_SITE .DS. 'components/com_wrapper', $newSitePath .DS. 'components/com_wrapper');

    JFolder::copy( JPATH_SITE .DS. 'images/', $newSitePath.DS.'images');

    symlink ( JPATH_SITE .DS. 'includes', $newSitePath .DS. 'includes');
    //symlink ( JPATH_SITE .DS. 'installation', $newSitePath .DS. 'installation');
		JFolder::copy( JPATH_SITE .DS. 'language/', $newSitePath.DS.'language');
    symlink ( JPATH_SITE .DS. 'libraries', $newSitePath .DS. 'libraries');

    JFolder::copy( JPATH_SITE .DS. 'logs/', $newSitePath.DS.'logs');
    JFolder::copy( JPATH_SITE .DS. 'media/', $newSitePath.DS.'media');
    JFolder::create( $newSitePath.DS.'modules');
    symlink ( JPATH_SITE .DS. 'modules/mod_archive', $newSitePath .DS. 'modules/mod_archive');
    symlink ( JPATH_SITE .DS. 'modules/mod_banners', $newSitePath .DS. 'modules/mod_banners');
    symlink ( JPATH_SITE .DS. 'modules/mod_breadcrumbs', $newSitePath .DS. 'modules/mod_breadcrumbs');
    symlink ( JPATH_SITE .DS. 'modules/mod_custom', $newSitePath .DS. 'modules/mod_custom');
    symlink ( JPATH_SITE .DS. 'modules/mod_feed', $newSitePath .DS. 'modules/mod_feed');
    symlink ( JPATH_SITE .DS. 'modules/mod_footer', $newSitePath .DS. 'modules/mod_footer');
    symlink ( JPATH_SITE .DS. 'modules/mod_latestnews', $newSitePath .DS. 'modules/mod_latestnews');
    symlink ( JPATH_SITE .DS. 'modules/mod_login', $newSitePath .DS. 'modules/mod_login');
    symlink ( JPATH_SITE .DS. 'modules/mod_mainmenu', $newSitePath .DS. 'modules/mod_mainmenu');
    symlink ( JPATH_SITE .DS. 'modules/mod_mostread', $newSitePath .DS. 'modules/mod_mostread');
    symlink ( JPATH_SITE .DS. 'modules/mod_newsflash', $newSitePath .DS. 'modules/mod_newsflash');
    symlink ( JPATH_SITE .DS. 'modules/mod_random_image', $newSitePath .DS. 'modules/mod_random_image');
    symlink ( JPATH_SITE .DS. 'modules/mod_related_items', $newSitePath .DS. 'modules/mod_related_items');
    symlink ( JPATH_SITE .DS. 'modules/mod_search', $newSitePath .DS. 'modules/mod_search');
    symlink ( JPATH_SITE .DS. 'modules/mod_sections', $newSitePath .DS. 'modules/mod_sections');
    symlink ( JPATH_SITE .DS. 'modules/mod_stats', $newSitePath .DS. 'modules/mod_stats');
    symlink ( JPATH_SITE .DS. 'modules/mod_syndicate', $newSitePath .DS. 'modules/mod_syndicate');
    symlink ( JPATH_SITE .DS. 'modules/mod_whosonline', $newSitePath .DS. 'modules/mod_whosonline');
    symlink ( JPATH_SITE .DS. 'modules/mod_wrapper', $newSitePath .DS. 'modules/mod_wrapper');

    /* Plugins */
    JFolder::copy( JPATH_SITE .DS. 'plugins/', $newSitePath.DS.'plugins');
    // Install mtwFirstInstall plugin
    $pluginPHP = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_mtwmultiple'.DS.'plugin'.DS.'mtwFirstInstall.php';
    $pluginXML = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_mtwmultiple'.DS.'plugin'.DS.'mtwFirstInstall.xml';
    JFile::copy( $pluginPHP, $newSitePath.DS.'plugins'.DS.'system'.DS.'mtwFirstInstall.php');
    JFile::copy( $pluginXML, $newSitePath.DS.'plugins'.DS.'system'.DS.'mtwFirstInstall.xml');

    /* FIX!! Templates */
		JFolder::copy( JPATH_SITE .DS. 'templates/', $newSitePath.DS.'templates');
		/*
    JFolder::create( $newSitePath.DS.'templates');
    //symlink ( JPATH_SITE .DS. 'templates', $newSitePath .DS. 'templates');
    symlink ( JPATH_SITE .DS. 'templates'.DS.'beez', $newSitePath .DS. 'templates'.DS.'beez');
    symlink ( JPATH_SITE .DS. 'templates'.DS.'ja_purity', $newSitePath .DS. 'templates'.DS.'ja_purity');
    symlink ( JPATH_SITE .DS. 'templates'.DS.'rhuk_milkyway', $newSitePath .DS. 'templates'.DS.'rhuk_milkyway');
    symlink ( JPATH_SITE .DS. 'templates'.DS.'system', $newSitePath .DS. 'templates'.DS.'system');
		*/

    JFolder::create( $newSitePath.DS.'tmp');

    symlink ( JPATH_SITE .DS. 'xmlrpc', $newSitePath .DS. 'xmlrpc');


    return true;

	}

	function addSiteDB( $post ) {
    
		$mainframe = JFactory::getApplication();

    $db =& JFactory::getDBO();
    $config =& JFactory::getConfig();
    require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'include'.DS.'helper.php');

    $dbtype = $config->getValue('config.dbtype');
    $host = $post['c_hostname'];
    $user = $post['c_username'];
    $password = $post['c_password'];
    $dbname = $post['c_database'];
    $dbprefix = $post['c_prefix'];

    $newDB = & JInstallationHelper::getDBO($dbtype, $host, $user, $password, $dbname, $dbprefix);

		// Install original Joomla scheme
    $dbscheme = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'sql'.DS.'joomla.sql';
    if (JInstallationHelper::populateDatabase($newDB, $dbscheme, $errors) > 0 ) {
    	return false;
    }

		// First Install Plugin table
    $dbscheme = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'sql'.DS.'firstinstall.sql';
    if (JInstallationHelper::populateDatabase($newDB, $dbscheme, $errors) > 0 ) {
    	return false;
    }

		$rootVars = new stdClass();
		$rootVars->admin_password = $post['password'];
		$rootVars->admin_user = "admin";
		$rootVars->admin_email = $post['email'];
		$rootVars->db_prefix = $dbprefix;

    if (!$this->_createRootUser($rootVars) ) {
    	return false;
    }   

    return true;        
  }


	function addSiteConfig( $post ) {

    $mainframe = JFactory::getApplication();

    $db =& JFactory::getDBO();
    $config =& JFactory::getConfig();

		$params = &JComponentHelper::getParams( 'com_mtwmultiple' );

    /* Create Joomla Installation */
    $query = "SELECT id FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
    $db->setQuery( $query );
    $siteID = $db->loadResult();

    /* Create Joomla Installation */
    $sitesPath = JPATH_SITE.DS.$params->get( 'path' );
    $newSitePath = $sitesPath .DS. $siteID;

		$newConfig = new JRegistry('config');
		$config_array = array();

		// SITE SETTINGS
		$config_array['offline']	= JRequest::getVar('offline', 0, 'post', 'int');
		$config_array['editor']		= JRequest::getVar('editor', 'tinymce', 'post', 'cmd');
		$config_array['list_limit']	= JRequest::getVar('list_limit', 20, 'post', 'int');
		$config_array['helpurl']	= JRequest::getVar('helpurl', 'http://help.joomla.org', 'post', 'string');

		// DEBUG
		$config_array['debug']		= JRequest::getVar('debug', 0, 'post', 'int');
		$config_array['debug_lang']	= JRequest::getVar('debug_lang', 0, 'post', 'int');

		// SEO SETTINGS
		$config_array['sef']			= JRequest::getVar('sef', 0, 'post', 'int');
		$config_array['sef_rewrite']	= JRequest::getVar('sef_rewrite', 0, 'post', 'int');
		$config_array['sef_suffix']		= JRequest::getVar('sef_suffix', 0, 'post', 'int');

		// FEED SETTINGS
		$config_array['feed_limit']		= JRequest::getVar('feed_limit', 10, 'post', 'int');

		// SERVER SETTINGS
		$config_array['secret']				= JRequest::getVar('secret', 0, 'post', 'string');
		$config_array['gzip']				= JRequest::getVar('gzip', 0, 'post', 'int');
		$config_array['error_reporting']	= JRequest::getVar('error_reporting', -1, 'post', 'int');
		$config_array['xmlrpc_server']		= JRequest::getVar('xmlrpc_server', 0, 'post', 'int');
		$config_array['log_path']			= JRequest::getVar('log_path', $newSitePath.DS.'logs', 'post', 'string');
		$config_array['tmp_path']			= JRequest::getVar('tmp_path', $newSitePath.DS.'tmp', 'post', 'string');
		$config_array['live_site'] 			= rtrim(JRequest::getVar('live_site','','post','string'), '/\\');

		// LOCALE SETTINGS
		$config_array['offset']				= JRequest::getVar('offset', 'UTC', 'post', 'string');

		// CACHE SETTINGS
		$config_array['caching']			= JRequest::getVar('caching', 0, 'post', 'int');
		$config_array['cachetime']			= JRequest::getVar('cachetime', 900, 'post', 'int');
		$config_array['cache_handler']		= JRequest::getVar('cache_handler', 'file', 'post', 'word');
		$config_array['memcache_settings']	= JRequest::getVar('memcache_settings', array(), 'post');

		// FTP SETTINGS
		$config_array['ftp_enable']	= JRequest::getVar('ftp_enable', 0, 'post', 'int');
		$config_array['ftp_host']	= JRequest::getVar('ftp_host', '', 'post', 'string');
		$config_array['ftp_port']	= JRequest::getVar('ftp_port', '', 'post', 'int');
		$config_array['ftp_user']	= JRequest::getVar('ftp_user', '', 'post', 'string');
		$config_array['ftp_pass']	= JRequest::getVar('ftp_pass', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$config_array['ftp_root']	= JRequest::getVar('ftp_root', '', 'post', 'string');

		// DATABASE SETTINGS
		$config_array['dbtype']		= JRequest::getVar('dbtype', $config->getValue('config.dbtype'), 'post', 'word');
		$config_array['host']		= JRequest::getVar('host', $config->getValue('config.host'), 'post', 'string');
		$config_array['user']		= JRequest::getVar('user', $config->getValue('config.user'), 'post', 'string');
		$config_array['db']		= JRequest::getVar('db', $config->getValue('config.db'), 'post', 'string');
		$config_array['dbprefix']	= JRequest::getVar('dbprefix', 'j' . $siteID . '_', 'post', 'string');

		// MAIL SETTINGS
		$config_array['mailer']		= JRequest::getVar('mailer', 'mail', 'post', 'word');
		$config_array['mailfrom']	= JRequest::getVar('mailfrom', '', 'post', 'string');
		$config_array['fromname']	= JRequest::getVar('fromname', 'Joomla 1.5', 'post', 'string');
		$config_array['sendmail']	= JRequest::getVar('sendmail', '/usr/sbin/sendmail', 'post', 'string');
		$config_array['smtpauth']	= JRequest::getVar('smtpauth', 0, 'post', 'int');
		$config_array['smtpuser']	= JRequest::getVar('smtpuser', '', 'post', 'string');
		$config_array['smtppass']	= JRequest::getVar('smtppass', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$config_array['smtphost']	= JRequest::getVar('smtphost', '', 'post', 'string');

		// META SETTINGS
		$config_array['MetaAuthor']	= JRequest::getVar('MetaAuthor', 1, 'post', 'int');
		$config_array['MetaTitle']	= JRequest::getVar('MetaTitle', 1, 'post', 'int');

		// SESSION SETTINGS
		$config_array['lifetime']			= JRequest::getVar('lifetime', 0, 'post', 'int');
		$config_array['session_handler']	= JRequest::getVar('session_handler', 'none', 'post', 'word');

		//LANGUAGE SETTINGS
		//$config_array['lang']				= JRequest::getVar('lang', 'none', 'english', 'cmd');
		//$config_array['language']			= JRequest::getVar('language', 'en-GB', 'post', 'cmd');

		$newConfig->loadArray($config_array);

		//override any possible database password change
		$newConfig->setValue('config.password', $mainframe->getCfg('password'));

		// handling of special characters
		$sitename			= htmlspecialchars( JRequest::getVar( 'sitename', $post['title'], 'post', 'string' ), ENT_COMPAT, 'UTF-8' );
		$newConfig->setValue('config.sitename', $sitename);

		$MetaDesc			= htmlspecialchars( JRequest::getVar( 'MetaDesc', '', 'post', 'string' ),  ENT_COMPAT, 'UTF-8' );
		$newConfig->setValue('config.MetaDesc', $MetaDesc);

		$MetaKeys			= htmlspecialchars( JRequest::getVar( 'MetaKeys', '', 'post', 'string' ),  ENT_COMPAT, 'UTF-8' );
		$newConfig->setValue('config.MetaKeys', $MetaKeys);

		// handling of quotes (double and single) and amp characters
		// htmlspecialchars not used to preserve ability to insert other html characters
		$offline_message	= JRequest::getVar( 'offline_message', '', 'post', 'string' );
		$offline_message	= JFilterOutput::ampReplace( $offline_message );
		$offline_message	= str_replace( '"', '&quot;', $offline_message );
		$offline_message	= str_replace( "'", '&#039;', $offline_message );
		$newConfig->setValue('config.offline_message', $offline_message);

		//purge the database session table (only if we are changing to a db session store)
		if($mainframe->getCfg('session_handler') != 'database' && $newConfig->getValue('session_handler') == 'database')
		{
			$table =& JTable::getInstance('session');
			$table->purge(-1);
		}

		// Get the path of the configuration file
		$fname = $newSitePath.DS.'configuration.php';

		// Get the config registry in PHP class format and write it to configuation.php
		jimport('joomla.filesystem.file');
		if (JFile::write($fname, $newConfig->toString('PHP', array('class' => 'JConfig')))) {
			$msg = JText::_('The Configuration Details have been updated');
		} else {
			$msg = JText::_('ERRORCONFIGFILE');
		}

   	return true;
  }

	function addExtensions($data){

		$params = &JComponentHelper::getParams( 'com_mtwmultiple' );

		$db =& JFactory::getDBO();

		// new site id
		$query = "SELECT id FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
		$db->setQuery( $query );
		$siteID = $db->loadResult();     

		// new site database instance
		$config =& JFactory::getConfig();
		$dbconfig = array();
		$dbconfig['driver'] = $config->getValue('config.dbtype');
		$dbconfig['host'] = $config->getValue('config.host');
		$dbconfig['user'] = $config->getValue('config.user');
		$dbconfig['password'] = $config->getValue('config.password');
		$dbconfig['database']= $config->getValue('config.db');
		$dbconfig['prefix'] = "j" . $siteID . "_";

		$newDB = JDatabase::getInstance( $dbconfig );
		/*
		  @@ TODO -> Check if jDatabase is created correctly

		if ( $newDB->message ) {
			//print_r($this->_externalDB);
			$this->setError($newDB->message);
			return false;
		}
		*/    

		// Setting new site path
    $sitesPath = JPATH_SITE.DS.$params->get( 'path' );
    $newSitePath = $sitesPath .DS. $siteID;

		if (isset($data['select2'])) {
			foreach ($data['select2'] as $id) {

				$query = "SELECT e.*"
				. " FROM #__mtwmultiple_extensions AS e"
				. " WHERE e.enable = 1 AND id = " . $id;
				//echo $query;
				$db->setQuery( $query );
				$rows = $db->loadAssoc();
			
				// Insert extension
				$query = "INSERT INTO #__mtwmultiple_firstinstall"
				. " (`filename`, `type`)"
				. " VALUES ('". $rows['filename'] ."','". $rows["type"] ."')";
				//echo $query."<br>--<br>";
				$newDB->setQuery( $query );
			
				if(!$newDB->query()) {
					echo $newDB->getError();
				}

		    $filepath = JPATH_ADMINISTRATOR .DS. 'components'.DS.'com_mtwmultiple'.DS.'extensions'.DS.$rows['filename'];
		    JFile::copy( $filepath, $newSitePath.DS.'tmp'.DS.$rows['filename']);
			}	
		}

		return true;
	}

	function addVirtual($data){

 		$params = &JComponentHelper::getParams( 'com_mtwmultiple' );

		// Getting site ID
		$db =& JFactory::getDBO();
    $query = "SELECT id FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
    $db->setQuery( $query );
    $siteID = $db->loadResult();
		
		$path = JPATH_ROOT.DS.$params->get( 'path' ).DS.$siteID;

		$vh = JFile::read(JPATH_ADMINISTRATOR .DS.'components'.DS.'com_mtwmultiple'.DS.'mtwmultiple.virtualhost.conf');
		
		$vh = str_replace("{EMAIL}", $data['email'], $vh);
		$vh = str_replace("{DOCROOT}", $path, $vh);
		$vh = str_replace("{SERVER}", $data['domain'], $vh);

		$vhfile = JPATH_ROOT.DS.$params->get( 'virtual' ).DS."{$siteID}-{$data['domain']}";

		//echo $vhfile."<br>";

		if (!JFile::write($vhfile, $vh)) {
			return false;
		}

		return true;
	}


	function removeSiteDB($siteID){
		$db =& JFactory::getDBO();
		$config =& JFactory::getConfig();
		$dbname = $config->getValue('config.db');
		require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'include'.DS.'helper.php');

		$dbprefix = 'j' . $siteID . '_';
		$query = "SHOW TABLES LIKE '$dbprefix%'";
		$db->setQuery($query);
		if ($tables = $db->loadResultArray()){
			foreach ($tables as $table) {
				$query = "DROP TABLE IF EXISTS `$table`";
				$db->setQuery($query);
				$db->query();
				if ($db->getErrorNum())
				{
					$msg = JText::_($db->getErrorMsg());
					JError::raiseWarning( 500, $db->getError() );
				}
			}
		}
	}

	function removeSiteFiles($id){
		jimport('joomla.filesystem.file');

		$site = $this->getSite($id);

 		$params = &JComponentHelper::getParams( 'com_mtwmultiple' );
		$sitesPath = JPATH_SITE.DS.$params->get( 'path' );

		// Remove the directory
		JFolder::delete($sitesPath .DS. $id);
		// Remove the symlink
		JFile::delete($sitesPath .DS. $site->title);

		return true;
	}

	/**
   * @param  int     The id of the site
	 * @return object  Return an object with the data of the site
	 * @since	2.5
	 */
	function getSite($id) {
		// Initiate the db
		$db =& JFactory::getDBO();

    $query = "SELECT * FROM #__mtwmultiple_sites WHERE id = '{$id}' LIMIT 1";
    $db->setQuery( $query );
    return $db->loadObject();
	}

	/**
   * @param  int     The id of the site
	 * @return object  Return an object with the data of the site
	 * @since	2.5
	 */
	function _createRootUser($options)
	{
		// Get a database object.
		//$db = JInstallationHelperDatabase::getDBO($options->db_type, $options->db_host, $options->db_user, $options->db_pass, $options->db_name, $options->db_prefix);
		$db =& JFactory::getDBO();

		// Check for errors.
		if ($db instanceof Exception) {
			$this->setError(JText::sprintf('INSTL_ERROR_CONNECT_DB', (string)$db));
			return false;
		}

		// Check for database errors.
		if ($err = $db->getErrorNum()) {
			$this->setError(JText::sprintf('INSTL_ERROR_CONNECT_DB', $db->getErrorNum()));
			return false;
		}

		// Create random salt/password for the admin user
		$salt = JUserHelper::genRandomPassword(32);
		$crypt = JUserHelper::getCryptedPassword($options->admin_password, $salt);
		$cryptpass = $crypt.':'.$salt;

		// create the admin user
		date_default_timezone_set('UTC');
		$installdate	= date('Y-m-d H:i:s');
		$nullDate		= $db->getNullDate();
		//sqlsrv change
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from($options->db_prefix.'users');
		$query->where('id = 42');

		$db->setQuery($query);

		if($db->loadResult())
		{
		  $query = $db->getQuery(true);
		  $query->update($options->db_prefix.'users');
		  $query->set('name = '.$db->quote('Super User'));
		  $query->set('username = '.$db->quote($options->admin_user));
		  $query->set('email = '.$db->quote($options->admin_email));
		  $query->set('password = '.$db->quote($cryptpass));
		  $query->set('usertype = '.$db->quote('deprecated'));
		  $query->set('block = 0');
		  $query->set('sendEmail = 1');
		  $query->set('registerDate = '.$db->quote($installdate));
		  $query->set('lastvisitDate = '.$db->quote($nullDate));
		  $query->set('activation = '.$db->quote('0'));
		  $query->set('params = '.$db->quote(''));
		  $query->where('id = 42');
		} else {
		 $query = $db->getQuery(true);
		  $columns =  array($db->quoteName('id'), $db->quoteName('name'), $db->quoteName('username'),
							$db->quoteName('email'), $db->quoteName('password'),
							$db->quoteName('usertype'),
							$db->quoteName('block'),
							$db->quoteName('sendEmail'), $db->quoteName('registerDate'),
							$db->quoteName('lastvisitDate'), $db->quoteName('activation'), $db->quoteName('params'));
		  $query->insert($options->db_prefix.'users', true);
		  $query->columns($columns);

		  $query->values('42'. ', '. $db->quote('Super User'). ', '. $db->quote($options->admin_user). ', '.
					$db->quote($options->admin_email). ', '. $db->quote($cryptpass). ', '. $db->quote('deprecated').', '.$db->quote('0').', '.$db->quote('1').', '.
					$db->quote($installdate).', '.$db->quote($nullDate).', '.$db->quote('0').', '.$db->quote(''));
		}
		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseWarning( 500, $db->getErrorMsg() );
			return false;
		}

		// Map the super admin to the Super Admin Group
		$query = $db->getQuery(true);
		$query->select('user_id');
		$query->from($options->db_prefix.'user_usergroup_map');
		$query->where('user_id = 42');

		$db->setQuery($query);

	  if($db->loadResult())
	  {
	    $query = $db->getQuery(true);
	    $query->update($options->db_prefix.'user_usergroup_map');
	    $query->set('user_id = 42');
	    $query->set('group_id = 8');
	  } else {
	    $query = $db->getQuery(true);
	    $query->insert($options->db_prefix.'user_usergroup_map', false);
		$query->columns(array($db->quoteName('user_id'), $db->quoteName('group_id')));
		$query->values('42'. ', '. '8');

	  }

		$db->setQuery($query);
		if (!$db->query()) {
			JError::raiseWarning( 500, $db->getErrorMsg() );
			return false;
		}

		return true;
	}

} // end class
