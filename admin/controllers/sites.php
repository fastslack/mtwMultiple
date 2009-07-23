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

class mtwMultipleControllerSites extends mtwMultipleController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		//$this->registerTask( 'add'  , 	'edit' );
	}

    function display() {
    
        JRequest::setVar( 'view', 'sites' );

        //echo $task;

        parent::display();
    }

    function add() {
    
        JRequest::setVar( 'view', 'sites' );
        JRequest::setVar( 'layout', 'form'  );

        parent::display();
    }

	function apply() {

		$model = $this->getModel('config');

		$data = JRequest::get( 'post' );

		if ($model->saveConfig($data)) {
			$msg = JText::_( 'Configuration Applied!' );
		} else {
			$msg = JText::_( 'Error Applying Configuration' );
		}

		JRequest::setVar( 'view', 'config' );

		$link = 'index.php?option=com_mtwmultiple&controller=config';
		$this->setRedirect($link, $msg);
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('sites');

		$data = JRequest::get( 'post' );

		if ($model->addSiteFiles($data)) {
			$msg = JText::_( 'Joomla Site Added!' );
		} else {
			$msg = JText::_( 'Error Creating Files' );
		}

		if ($model->addSiteDB() != false) {
			$msg = JText::_( 'Joomla Site Added!' );
		} else {
			$msg = JText::_( 'Error With DB Insertion' );
		}
                
		if ($model->addSiteConfig($data)) {
			$msg = JText::_( 'Joomla Site Added!' );
		} else {
			$msg = JText::_( 'Error Creating Config File' );
		}

		$link = 'index.php?option=com_mtwmultiple&controller=sites';
		$this->setRedirect($link, $msg);
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Configuration Cancelled' );
		$this->setRedirect( 'index.php?option=com_mtwmultiple', $msg );
	}

    function remove()
    {
        // Check for request forgeries
        JRequest::checkToken() or jexit( 'Invalid Token' );

        $this->setRedirect( 'index.php?option=com_mtwmultiple&controller=sites' );

        // Initialize variables
        $db     =& JFactory::getDBO();
        $hid    = JRequest::getVar( 'cid', array(), 'post', 'array' );
        $n      = count( $hid );

        $model = $this->getModel('sites');
        for($count = 0; $count < $n; $count++) {

        	$element = $hid[$count];
			$model->removeSiteDB($hid[$count]);
			$model->removeSiteFiles($hid[count]);
        	$query = 'DELETE FROM #__mtwmultiple_sites'
            . ' WHERE id = ' . implode( ' OR id = ', $hid );

            $db->setQuery( $query );
            if (!$db->query()) {
                JError::raiseWarning( 500, $db->getError() );
            }
        }

        $this->setMessage( JText::sprintf( 'Items removed', $n ) );
    }
}
?>
