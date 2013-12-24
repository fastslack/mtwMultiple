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

class mtwMultipleViewGlobal extends JView
{

	function display($tpl = null) {
		global $mainframe;
		
		JToolBarHelper::title(   JText::_( 'Global Configuration' ), 'config.png' );
        JToolBarHelper::back();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();

		$configFile = JPATH_COMPONENT.'/mtwmultiple_config.php';
		if (JFile::exists( $configFile )) {
			include( $configFile );
		}

        $this->assignRef('config', $mtwCFG);

		parent::display($tpl);
	}
}
