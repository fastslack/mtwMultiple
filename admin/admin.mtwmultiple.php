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

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Require specific controller if requested
$controller = JRequest::getVar('controller', 'sites');

if($controller) {
  $path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';
  //echo $path;
  if (file_exists($path)) {
    require_once $path;
  } else {
    $controller = 'Cpanel';
  }
}

// Create the controller
$classname	= 'mtwMultipleController'.$controller;
$controller = new $classname( );

// Perform the Request task
$controller->execute( JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
