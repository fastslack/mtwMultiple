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

class mtwMultipleViewCpanel extends JView
{

	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'mtwMultiple' ), 'generic.png' );
		//JToolBarHelper::deleteList();
		//JToolBarHelper::editListX();
		//JToolBarHelper::addNewX();

		// Get data from the model
		//$items		= & $this->get( 'Data');

		//$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}
