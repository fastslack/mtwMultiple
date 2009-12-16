<?php 
/**
 * mtwMultiple
 *
 * @author      Matias Aguirre
 * @email       maguirre@matware.com.ar
 * @url         http://www.matware.com.ar/
 * @license		GNU/GPL
 */

defined('_JEXEC') or die('Restricted access'); 
?>
<link rel="stylesheet" href="components/com_mtwmultiple/css/mtwmultiple.css" type="text/css" />
<form action="index.php" method="post" name="adminForm">
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td width="50%" valign="top">

	<table class="adminlist">
	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Virtual Hosts Configuration" ); ?></h3>
		</td>
	</tr>
	<tr>
		<td align="right" class="row1" width="35%">
			<b><?php echo JText::_( "Virtual Host Directory" ); ?></b><br />
			<small><i>
			<?php
				echo JText::_( "Every virtual host created with mtwMultiple will be installed in this directory. ");
				echo JText::_( "The name of each site is the site ID number and name. <b>Ex: 001-site.com</b>" );
			?>
			</small></i><br/>			
		</td>
		<td align="top">
			<input type="text" name="vhostpath" value="<?php echo $this->config['virtual'];?>" />
		</td>
    </tr>
    
 	<tr>
		<td align="right" class="row2" valign="top">
			<b><?php echo JText::_( "Apache Virtual Host Template" ); ?></b><br />
			<small><i>
			<?php
				echo JText::_( "Every virtual host created with mtwMultiple will be installed in this directory. ");
				echo JText::_( "The name of each site is the site ID number and name. <b>Ex: 001-site.com</b>" );
			?>
			</small></i><br/>		
		</td>
		<td>
			<textarea class="virt_template" name="virtual" ><?php echo $this->virtual;?></textarea>
		</td>
    </tr>
	<input type="hidden" name="option" value="com_mtwmultiple" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="config" />
	<input type="hidden" name="type" value="virtual" />
	</form>

	</table>
	</td>
</tr>
</table>
</div>


</form>
