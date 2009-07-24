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

jimport( 'joomla.application.component.view' );

class mtwMultipleViewSites extends JView {

	function display($tpl = null) {
     	global $mainframe;

                
        if($this->getLayout() == 'form') {
                $this->_displayForm($tpl);
                return;
        }

		JToolBarHelper::title(  JText::_( 'mtwMultiple Sites' ), 'plugin.png' );
		JToolBarHelper::back();
		JToolBarHelper::deleteList();
		//JToolBarHelper::editListX();
		JToolBarHelper::addNewX();
		//JToolBarHelper::cancel();
		//JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$filter_order	  = $mainframe->getUserStateFromRequest( 'filter_order', 'filter_order', 's.id', 'cmd' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( 'filter_order_Dir',	'filter_order_Dir', '',	'word' );
		$search		  = $mainframe->getUserStateFromRequest( 'search','search','','string' );

		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart     = $mainframe->getUserStateFromRequest( 'limitstart', 'limitstart', 0, 'int' );

		$where = array();

		if ($search) {
			$where[] = 'LOWER(s.name) LIKE '.$db->Quote( '%'.$db->getEscaped( $search, true ).'%', false );
		}

        if ($filter_order == '') {
          $filter_order = 's.id';
        }

		$where		= count( $where ) ? ' WHERE ' . implode( ' AND ', $where ) : '';
		$orderby	= ' ORDER BY '. $filter_order .' '. $filter_order_Dir;

		// get the total number of records
		$query = 'SELECT COUNT(*)'
		. ' FROM #__mtwmultiple_sites AS s'
		. $where;

		$db->setQuery( $query );
		$total = $db->loadResult();

		jimport('joomla.html.pagination');
		$pageNav = new JPagination( $total, $limitstart, $limit );

		$query = 'SELECT s.*, u.username'
		. ' FROM #__mtwmultiple_sites AS s'
		. ' LEFT JOIN #__users AS u ON u.id = s.created_by'
		. $where
		. $orderby;

		//echo $query;

		$db->setQuery( $query, $pageNav->limitstart, $pageNav->limit );
		$rows = $db->loadObjectList();
		print_r($db->getError());

		// table ordering
		$lists['order_Dir']	= $filter_order_Dir;
		$lists['order']		= $filter_order;

		// search filter
		$lists['search']= $search;

        $this->assignRef('rows', $rows);
        $this->assignRef('lists', $lists);
        $this->assignRef('pageNav', $pageNav);

		parent::display($tpl);
	}

    function _displayForm ($tpl = null) {
		global $mainframe;

		JToolBarHelper::title(  JText::_( 'Add Joomla Site' ), 'plugin.png' );
		//JToolBarHelper::deleteList();
		//JToolBarHelper::editListX();
		//JToolBarHelper::addNewX();
		JToolBarHelper::cancel();
		JToolBarHelper::save();
		JToolBarHelper::spacer();

		$db =& JFactory::getDBO();

		$query = "SELECT e.id, CONCAT(e.name, ' ', e.version) as name"
		. " FROM #__mtwmultiple_extensions AS e"
		. " WHERE e.enable = 1 ORDER BY name ASC";

		//echo $query;

		$db->setQuery( $query );
		$rows = $db->loadObjectList();
	
		//print_r($rows);
	
		/*
			jimport("joomla.html.html.select"); Not work?
		*/
		include_once JPATH_ROOT . "/libraries/joomla/html/html/select.php";
		$options = JHTMLSelect::Options( $rows, "id", "name" );
	
		$this->assignRef('options', $options);
	
		parent::display($tpl);
	} 

}
?>
