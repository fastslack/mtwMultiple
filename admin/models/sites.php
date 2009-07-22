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


class mtwMultipleModelSites extends JModel
{
	function __construct()
	{
		parent::__construct();

		//$array = JRequest::getVar('cid',  0, '', 'array');
		//$this->setId((int)$array[0]);
	}


	function addSiteFiles( $post ) {
            global $mainframe;

            jimport('joomla.filesystem.file');

            $configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';
			if (JFile::exists( $configFile )) {
			  include( $configFile );
			}

            //echo $mainframe->getPath( );
            //print_r($mtwCFG);
            //print_r($post);

            /* Insert into Database */
            $my =& JFactory::getUser();      
            $db =& JFactory::getDBO();

            $query = "INSERT INTO #__mtwmultiple_sites (name, title, email, created_by, created, password)"
             ." VALUES ('" . $post['name'] . "', '" . $post['title'] . "', '" . $post['email'] . "', " . $my->id . ", NOW(), '" . $post['password'] . "' )";
            $db->setQuery( $query );
            if (!$db->query()) {
            	return $db->getErrorMsg();
            }

            /* Create Joomla Installation */
            $query = "SELECT name FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
            $db->setQuery( $query );
            $siteName = $db->loadResult();

            $sitesPath = JPATH_SITE.DS.$mtwCFG['path'];
            $newSitePath = $sitesPath .DS. $siteName;
	
			echo $newSitePath;

            if (!JFolder::exists( $sitesPath )) {              
              JFolder::create( $sitesPath );
            }

            JFolder::create( $newSitePath);

            /* index.php and index2.php */
            JFile::copy( JPATH_SITE .DS. 'index.php', $newSitePath.DS.'index.php');
            JFile::copy( JPATH_SITE .DS. 'index2.php', $newSitePath.DS.'index2.php');

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
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_frontpage', $newSitePath .DS. 'administrator/components/com_frontpage');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_installer', $newSitePath .DS. 'administrator/components/com_installer');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_languages', $newSitePath .DS. 'administrator/components/com_languages');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_login', $newSitePath .DS. 'administrator/components/com_login');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_massmail', $newSitePath .DS. 'administrator/components/com_massmail');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_media', $newSitePath .DS. 'administrator/components/com_media');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_menus', $newSitePath .DS. 'administrator/components/com_menus');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_messages', $newSitePath .DS. 'administrator/components/com_messages');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_modules', $newSitePath .DS. 'administrator/components/com_modules');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_newsfeeds', $newSitePath .DS. 'administrator/components/com_newsfeeds');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_plugins', $newSitePath .DS. 'administrator/components/com_plugins');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_poll', $newSitePath .DS. 'administrator/components/com_poll');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_search', $newSitePath .DS. 'administrator/components/com_search');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_sections', $newSitePath .DS. 'administrator/components/com_sections');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_templates', $newSitePath .DS. 'administrator/components/com_templates');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_trash', $newSitePath .DS. 'administrator/components/com_trash');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_users', $newSitePath .DS. 'administrator/components/com_users');
            symlink ( JPATH_ADMINISTRATOR .DS. 'components/com_weblinks', $newSitePath .DS. 'administrator/components/com_weblinks');
            symlink ( JPATH_ADMINISTRATOR .DS. 'help', $newSitePath .DS. 'administrator/help');
            symlink ( JPATH_ADMINISTRATOR .DS. 'images', $newSitePath .DS. 'administrator/images');
            symlink ( JPATH_ADMINISTRATOR .DS. 'includes', $newSitePath .DS. 'administrator/includes');
            JFile::copy( JPATH_ADMINISTRATOR .DS. 'index2.php', $newSitePath.DS.'administrator/index2.php');
            JFile::copy( JPATH_ADMINISTRATOR .DS. 'index3.php', $newSitePath.DS.'administrator/index3.php');
            JFile::copy( JPATH_ADMINISTRATOR .DS. 'index.php', $newSitePath.DS.'administrator/index.php');
            JFolder::create( $newSitePath.DS.'administrator/language');
            symlink ( JPATH_ADMINISTRATOR .DS. 'language/index.html', $newSitePath .DS. 'administrator/language/index.html');
            symlink ( JPATH_ADMINISTRATOR .DS. 'language/en-GB', $newSitePath .DS. 'administrator/language/en-GB');
            symlink ( JPATH_ADMINISTRATOR .DS. 'modules', $newSitePath .DS. 'administrator/modules');
            symlink ( JPATH_ADMINISTRATOR .DS. 'templates', $newSitePath .DS. 'administrator/templates');

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

            /* FIX!! Images Files */
            //JFolder::create( $newSitePath.DS.'images');
            symlink ( JPATH_SITE .DS. 'images', $newSitePath .DS. 'images');

            symlink ( JPATH_SITE .DS. 'includes', $newSitePath .DS. 'includes');
            //symlink ( JPATH_SITE .DS. 'installation', $newSitePath .DS. 'installation');
            symlink ( JPATH_SITE .DS. 'libraries', $newSitePath .DS. 'libraries');

            JFolder::create( $newSitePath.DS.'logs');
            JFolder::create( $newSitePath.DS.'media');
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
            symlink ( JPATH_SITE .DS. 'modules/mod_poll', $newSitePath .DS. 'modules/mod_poll');
            symlink ( JPATH_SITE .DS. 'modules/mod_random_image', $newSitePath .DS. 'modules/mod_random_image');
            symlink ( JPATH_SITE .DS. 'modules/mod_related_items', $newSitePath .DS. 'modules/mod_related_items');
            symlink ( JPATH_SITE .DS. 'modules/mod_search', $newSitePath .DS. 'modules/mod_search');
            symlink ( JPATH_SITE .DS. 'modules/mod_sections', $newSitePath .DS. 'modules/mod_sections');
            symlink ( JPATH_SITE .DS. 'modules/mod_stats', $newSitePath .DS. 'modules/mod_stats');
            symlink ( JPATH_SITE .DS. 'modules/mod_syndicate', $newSitePath .DS. 'modules/mod_syndicate');
            symlink ( JPATH_SITE .DS. 'modules/mod_whosonline', $newSitePath .DS. 'modules/mod_whosonline');
            symlink ( JPATH_SITE .DS. 'modules/mod_wrapper', $newSitePath .DS. 'modules/mod_wrapper');

            /* FIX!! Plugins */
            //JFolder::create( $newSitePath.DS.'plugins');
            symlink ( JPATH_SITE .DS. 'plugins', $newSitePath .DS. 'plugins'); 

            /* FIX!! Templates */
            JFolder::create( $newSitePath.DS.'templates');
            //symlink ( JPATH_SITE .DS. 'templates', $newSitePath .DS. 'templates');
            symlink ( JPATH_SITE .DS. 'templates'.DS.'beez', $newSitePath .DS. 'templates'.DS.'beez');
            symlink ( JPATH_SITE .DS. 'templates'.DS.'ja_purity', $newSitePath .DS. 'templates'.DS.'ja_purity');
            symlink ( JPATH_SITE .DS. 'templates'.DS.'rhuk_milkyway', $newSitePath .DS. 'templates'.DS.'rhuk_milkyway');
            symlink ( JPATH_SITE .DS. 'templates'.DS.'system', $newSitePath .DS. 'templates'.DS.'system');


            JFolder::create( $newSitePath.DS.'tmp');

            symlink ( JPATH_SITE .DS. 'xmlrpc', $newSitePath .DS. 'xmlrpc');


            return true;

	}

	function addSiteDB( ) {
            global $mainframe;

            $db =& JFactory::getDBO();
            $config =& JFactory::getConfig();
            require_once( JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'include'.DS.'helper.php');

            $query = "SELECT id, email, password FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
            $db->setQuery( $query );
            $newsite = $db->loadAssoc();            

            $dbtype = $config->getValue('config.dbtype');
            $host = $config->getValue('config.host');
            $user = $config->getValue('config.user');
            $password = $config->getValue('config.password');
            $dbname = $config->getValue('config.db');
            $dbprefix = "j" . $newsite['id'] . "_";

            $newDB = & JInstallationHelper::getDBO($dbtype, $host, $user, $password, $dbname, $dbprefix);

            //print_r($newDB);

            $dbscheme = JPATH_ADMINISTRATOR.DS.'components'.DS.'com_mtwmultiple'.DS.'sql'.DS.'joomla.sql';
            if (!JInstallationHelper::populateDatabase($newDB, $dbscheme, $errors) > 0 ) {
            	return false;
            }

			$vars['DBtype']	= $dbtype;
			$vars['DBhostname']	= $host;
			$vars['DBuserName']	= $user;
			$vars['DBpassword']	= $password;
			$vars['DBname']	= $dbname;
			$vars['DBPrefix']	= $dbprefix;
			$vars['adminPassword'] = $newsite['password'];
			$vars['adminEmail'] = $newsite['email'];

            if (!JInstallationHelper::createAdminUser($vars) ) {
            	return false;
            }    

            return true;        
        }


	function addSiteConfig( $post ) {
          global $mainframe;

            $db =& JFactory::getDBO();
            $config =& JFactory::getConfig();

            $configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';
			if (JFile::exists( $configFile )) {
			  include( $configFile );
			}

            /* Create Joomla Installation */
            $query = "SELECT id FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
            $db->setQuery( $query );
            $siteID = $db->loadResult();

            $query = "SELECT name FROM #__mtwmultiple_sites ORDER BY id DESC LIMIT 1";
            $db->setQuery( $query );
            $siteName = $db->loadResult();

            /* Create Joomla Installation */
            $sitesPath = JPATH_SITE.DS.$mtwCFG['path'];
            $newSitePath = $sitesPath .DS. $siteName;

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
			$config_array['offset']				= JRequest::getVar('offset', 0, 'post', 'float');

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
		if (JFile::write($fname, $newConfig->toString('PHP', 'config', array('class' => 'JConfig')))) {
			$msg = JText::_('The Configuration Details have been updated');
		} else {
			$msg = JText::_('ERRORCONFIGFILE');
		}

            return true;
        }



}
?>
