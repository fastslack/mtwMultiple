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
  
<form action="index.php" method="post" name="adminForm">
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td width="50%" valign="top">

	<table class="adminlist">
	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Global Configuration" ); ?></h3>
		</td>
	</tr>
	<tr>
		<td align="right" class="row1" width="35%">
			<h2><b><?php echo JText::_( "Sites Path" ); ?></b></h2><br />
			<small><i>
			<?php
				//echo JText::_( "You need to create a directory into the root joomla installation with read/write privileges. " );
				echo JText::_( "Every sites created with mtwMultiple will be installed in this directory. ");
				echo JText::_( "The name of each site is the site ID number. <br />Ex: http://host/{PATH}/1" );
			?>
			</small></i><br/>		
		</td>
		<td>
			<input type="text" name="path" value="<?php echo $this->config['path'];?>" />
		</td>
    </tr>
	<input type="hidden" name="option" value="com_mtwmultiple" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="config" />
	<input type="hidden" name="type" value="global" />
	</form>
	</table>

	</td>
</tr>
</table>
</div>


</form>
