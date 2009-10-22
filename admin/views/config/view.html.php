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

jimport('joomla.application.component.view');
jimport('joomla.filesystem.file');

class mtwMultipleViewConfig extends JView
{

	function display($tpl = null) {
		global $mainframe;
		
		JToolBarHelper::title(   JText::_( 'Global Configuration' ), 'config.png' );
        JToolBarHelper::back();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();

		$configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';
		if (JFile::exists( $configFile )) {
			include( $configFile );
		}

		$db =& JFactory::getDBO();

		$limit	= $mainframe->getUserStateFromRequest('global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart     = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );

		// get the total number of records
		$query = 'SELECT COUNT(*)'
		. ' FROM #__mtwmultiple_extensions AS e';

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$query = "SELECT e.*"
		. " FROM #__mtwmultiple_extensions AS e"
		. " ORDER BY e.type, e.name ASC";

        //echo $query;

	    $db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
        //print_r($db->getError());

        $this->assignRef('config', $mtwCFG);        
        $this->assignRef('rows', $rows);
        $this->assignRef('lists', $lists);
        $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}
}
