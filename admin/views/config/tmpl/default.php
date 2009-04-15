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
		<td align="right">
			<?php echo JText::_( "Sites Path" ); ?>
		</td>
		<td>
			<input type="text" name="path" value="<?php echo $this->items['path'];?>" />
		</td>
    </tr>
	<tr>
		<td colspan="2">
			<?php
				echo JText::_( "You need to create a directory into the root joomla installation with read/write privileges.<br/>" );
				echo JText::_( "Every sites created with mtwMultiple will be installed in this directory.<br/>");
				echo JText::_( "The name of each site is the site ID number. Ex: http://host/{PATH}/1<br/>" );
			?>
		</td>
    </tr>
<!--
    <tr>
        <td align="right">
            <?php echo JText::_( "Database Name" ); ?>
        </td>
        <td>
			<input type="text" name="dbname" value="<?php echo $this->items['dbname'];?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <?php echo JText::_( "UserName" ); ?>
        </td>
        <td>
            <input type="text" name="username" value="<?php echo $this->items['username'];?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <?php echo JText::_( "Password" ); ?>
        </td>
        <td>
			<input type="password" name="password" value="<?php echo $this->items['password'];?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <?php echo JText::_( "Prefix" ); ?>
        </td>
        <td>
            <input type="text" name="prefix" value="<?php echo $this->items['prefix'];?>" />
        </td>
	</tr>
-->

	</table>

	</td>
</tr>
</table>



</div>

<input type="hidden" name="option" value="com_mtwmultiple" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="config" />
<?
	if ($this->items['ext_cb'] == 1) {
		echo "<input type=\"hidden\" name=\"groups\" value=\"1\" />";
		echo "<input type=\"hidden\" name=\"users\" value=\"1\" />";
	}						
?>

</form>
