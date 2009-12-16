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

//print_r($this->status);
//print_r($this->pageNav);

JHTML::_('behavior.tooltip');

?>
		<form action="index.php?option=com_mtwmultiple" method="post" name="adminForm">
		<table>
		<tr>
			<td align="left" width="100%">
				<?php echo JText::_( 'Filter' ); ?>:
				<input type="text" name="search" id="search" value="<?php echo $lists['search'];?>" class="text_area" onchange="document.adminForm.submit();" />
				<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
				<button onclick="document.getElementById('search').value='';this.form.getElementById('filter_catid').value='0';this.form.getElementById('filter_state').value='';this.form.submit();"><?php echo JText::_( 'Filter Reset' ); ?></button>
			</td>
			<td nowrap="nowrap">
			</td>
		</tr>
		</table>

			<table class="adminlist">
			<thead>
				<tr>
					<th width="20">
						<?php echo JText::_( 'Num' ); ?>
					</th>
					<th width="20">
						<input type="checkbox" name="toggle" value=""  onclick="checkAll(<?php echo count( $rows ); ?>);" />
					</th>
					<th width="20">
						&nbsp;
					</th>
					<th nowrap="20%" class="title">
						<?php echo JHTML::_('grid.sort',  'Name', 's.name', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="30%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Email', 's.email', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="20%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Created by', 'u.username', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
					<th width="20%" nowrap="nowrap">
						<?php echo JHTML::_('grid.sort',   'Date', 's.created', @$lists['order_Dir'], @$lists['order'] ); ?>
					</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="7">
						<?php echo $this->pageNav->getListFooter(); ?>
					</td>
				</tr>
			</tfoot>
			<tbody>
<?php
      $rows = $this->rows;

			$k = 0;
			for ($i=0, $n=count( $rows ); $i < $n; $i++) {
				$row = &$rows[$i];

				$checked		= JHTML::_('grid.checkedout',   $row, $i );
				$url = JURI::root() . $this->config['path'] .DS. $row->id;
			?>
				<tr class="<?php echo "row$k"; ?>">
					<td align="center">
						<?php echo $row->id; ?>
					</td>
					<td align="center">
						<?php echo $checked; ?>
					</td>
					<td align="center">
						<a href="<?php echo $url; ?>" target="_blank"><img src="components/com_mtwmultiple/images/go.jpg"></a>
					</td>
					<td>
						<?php echo $row->name;?>
					</td>
					<td align="center">
						<?php echo $row->email;?>
					</td>
					<td align="center">
						<?php echo $row->username;?>
					</td>
					<td class="order">
						<?php echo $row->created; ?>
					</td>
				</tr>
				<?php
				$k = 1 - $k;
			}
			?>
			</tbody>
			</table>

		<input type="hidden" name="c" value="banner" />
                <input type="hidden" name="option" value="com_mtwmultiple" />
                <input type="hidden" name="controller" value="sites" />

		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $lists['order']; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $lists['order_Dir']; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>

