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

class mtwMultipleControllerConfig extends mtwMultipleController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

    function display() {

		$type = JRequest::getVar('type');

		$subMenus = array(
			'Global' => 'global',
			'Extensions' => 'extensions',
			'Virtual Hosts' => 'virtual');

			//JSubMenuHelper::addEntry(JText::_( 'Global' ), '#" onclick="javascript:document.adminForm.type.value=\'\';submitbutton(\'extensions\');', !in_array( $task, $subMenus));
			foreach ($subMenus as $name => $extension) {
				//print($extension."-".$task);
				JSubMenuHelper::addEntry(JText::_( $name ), '#" onclick="javascript:document.adminForm.type.value=\''.$extension.'\';submitbutton(\''.$extension.'\');', $extension == $type ? 1 : 0);
			}
		
			//echo $type;
     	JRequest::setVar( 'view', $type );
      
      parent::display();
    }

	function apply() {

		$type = JRequest::getVar('type');
		$model = $this->getModel($type);

		$data = JRequest::get( 'post' );

		//print_r($_POST['virtual']);
		//echo JRequest::_cleanVar($_POST['virtual'], 0);

		$xml = simplexml_load_string($_POST['virtual']);

		print_r($xml);

		if ($model->saveConfig($data)) {
			$msg = JText::_( 'Configuration Applied!' );
		} else {
			$msg = JText::_( 'Error Applying Configuration' );
		}

		//$this->display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		
		$type = JRequest::getVar('type');
		$model = $this->getModel($type);

		$data = JRequest::get( 'post' );

		if ($model->saveConfig($data)) {
			$msg = JText::_( 'Configuration Saved!' );
		} else {
			$msg = JText::_( 'Error Saving Configuration' );
		}

		$link = 'index.php?option=com_mtwmultiple';
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

	function upload() {

		$model = $this->getModel('extensions');

		$data = JRequest::get( 'post' );

		if ($model->upload($data)) {
			$msg = JText::_( 'Extension Added!' );
		} else {
			$msg = JText::_( 'Extension Error' );
		}

		//JRequest::setVar( 'view', 'config' );

		$link = 'index.php?option=com_mtwmultiple&controller=config&type=extensions';
		$this->setRedirect($link, $msg);
	}

}
?>
