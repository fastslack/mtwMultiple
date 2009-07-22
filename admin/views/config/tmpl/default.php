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
			<h3><?php echo JText::_( "Configuration" ); ?></h3>
		</td>
	</tr>
	<tr>
		<td align="right" class="row1">
			<?php echo JText::_( "Sites Path" ); ?>
		</td>
		<td>
			<input type="text" name="path" value="<?php echo $this->items['path'];?>" />
		</td>
    </tr>
	<tr>
		<td colspan="2" class="row1">
			<?php
				echo JText::_( "You need to create a directory into the root joomla installation with read/write privileges. " );
				echo JText::_( "Every sites created with mtwMultiple will be installed in this directory. ");
				echo JText::_( "The name of each site is the site ID number. Ex: http://host/{PATH}/1<br/>" );
			?>
		</td>
    </tr>
	<input type="hidden" name="option" value="com_mtwmultiple" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
	<input type="hidden" name="controller" value="config" />
	</form>

	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Upload Component" );echo JRequest::getVar('task'); ?></h3>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="row1">
            <form action="index.php" id="uploadForm" method="post" enctype="multipart/form-data">
                <fieldset>
                    <legend><?php echo JText::_( 'Upload File' ); ?> [ <?php echo JText::_( 'Max' ); ?>&nbsp; 10M ]</legend>
                    <fieldset class="actions">
                        <input type="file" id="file-upload" name="Filedata" />
                        <input type="submit" id="file-upload-submit" value="<?php echo JText::_('Start Upload'); ?>"/>
                        <span id="upload-clear"></span>
                    </fieldset>
                    <ul class="upload-queue" id="upload-queue">
                        <li style="display: none" />
                    </ul>
                </fieldset>
                <input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_media'); ?>" />
			<input type="hidden" name="option" value="com_mtwmultiple" />
			<input type="hidden" name="task" value="upload" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="controller" value="config" />
			<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_mtwmultiple&amp;controller=config'); ?>" />
            </form>
		</td>
    </tr>
	</table>

	</td>
</tr>
</table>
</div>


</form>
