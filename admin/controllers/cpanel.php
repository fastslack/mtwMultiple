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

class mtwMultipleControllerCpanel extends mtwMultipleController
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
    
        JRequest::setVar( 'view', 'cpanel' );

        parent::display();
    }


}
?>
