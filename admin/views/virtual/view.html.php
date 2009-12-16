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

class mtwMultipleViewVirtual extends JView
{

	function display($tpl = null) {
		global $mainframe;
		
		JToolBarHelper::title( JText::_( 'Virtual Hosts' ), 'config.png' );
        JToolBarHelper::back();
		JToolBarHelper::apply();
		JToolBarHelper::save();
		JToolBarHelper::cancel();
		JToolBarHelper::spacer();

		jimport('joomla.filesystem.file');

        $configFile = JPATH_COMPONENT.DS.'mtwmultiple.virtualhost.conf';

        if (!JFile::exists( $configFile )) {
			JFile::copy( $configFile . '.orig', $configFile );
		}

		$virtual = JFile::read($configFile);

		$configFile = JPATH_COMPONENT.DS.'mtwmultiple_config.php';
		if (JFile::exists( $configFile )) {
			include( $configFile );
		}

        $this->assignRef('config', $mtwCFG);
        $this->assignRef('virtual', $virtual);

		parent::display($tpl);
	}
}
