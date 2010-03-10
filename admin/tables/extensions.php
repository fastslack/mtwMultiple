<?php
/**
 * mtwMultiple
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar/
 * @license		GNU/GPL
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class TableExtensions extends JTable {

	var $id				 = null;
	var $filename			 = '';
	var $type		 = '';
	var $name     = '';
	var $author = '';
	var $creationDate   = '';
	var $copyright			= '';
	var $license   = '';
	var $authorEmail			= '';
	var $authorUrl   = '';
	var $version			= '';
	var $enabled			= '';

	function __construct(&$_db) {
		parent::__construct('#__mtwmultiple_extensions', 'id', $_db);
	}

	/**
	 * Overloaded check function
	 *
	 * @access public
	 * @return boolean
	 * @see JTable::check
	 * @since 1.5
	 */
	function check() {
		return true;
	}
}
