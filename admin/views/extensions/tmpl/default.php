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
  
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td width="50%" valign="top">

	<table class="adminlist">
	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Upload Extension" );?></h3>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="row1">
            <form action="index.php" name="adminForm" id="uploadForm" method="post" enctype="multipart/form-data">
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
			<input type="hidden" name="option" value="com_mtwmultiple" />
			<input type="hidden" name="task" value="upload" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="controller" value="config" />
			<input type="hidden" name="return-url" value="<?php echo base64_encode('index.php?option=com_mtwmultiple&amp;controller=config'); ?>" />
			<input type="hidden" name="type" value="extensions" />
            </form>
		</td>
    </tr>
	</table>
	<table class="adminlist" cellspacing="1">
		<thead>
			<tr>
				<th class="title" width="10px"><?php echo JText::_( 'Num' ); ?></th>
				<th width="20"><input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" /></th>
				<th class="title" nowrap="nowrap"><?php echo JText::_( 'Currently Installed' ); ?></th>
				<th class="title" width="5%" align="center"><?php echo JText::_( 'Enabled' ); ?></th>
				<th class="title" width="10%" align="center"><?php echo JText::_( 'Version' ); ?></th>
				<th class="title" width="15%"><?php echo JText::_( 'Date' ); ?></th>
				<th class="title" width="25%"><?php echo JText::_( 'Author' ); ?></th>
				<th class="title" width="5%"><?php echo JText::_( 'Type' ); ?></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
			<td colspan="8"><?php //echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>
			<tbody>
<?php
                        $rows = $this->rows;

			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$checked		= JHTML::_('grid.checkedout',   $row, $i );
			?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $row->id; ?>
					</td>
					<td align="center">
						<?php echo $checked; ?>
					</td>
					<td>
						<?php echo $row->name;?>
					</td>
					<td align="center">
						<?php echo $row->enable;?>
					</td>
					<td align="center">
						<?php echo $row->version;?>
					</td>
					<td class="order">
						<?php echo $row->creationDate; ?>
					</td>
					<td align="center">
						<?php echo $row->author;?>
					</td>
					<td class="order">
						<?php echo $row->type; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
	</table>
	</td>
</tr>
</table>
</div>


</form>
