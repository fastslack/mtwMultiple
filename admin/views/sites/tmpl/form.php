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
<script language="javascript" type="text/javascript">
<!--
	function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
                }

		var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&]", "i");
                
		// do field validation
		if (trim(form.name.value) == "") {
			alert( "You must provide a name." );
		} else if (form.title.value == "") {
			alert( "You must provide a title." );
                } else if (trim(form.email.value) == "") {
                  alert( "You must provide an e-mail address." );
		} else if (trim(form.password.value) == "") {
			alert( "You must provide password" );
                } else if (((trim(form.password.value) != "") || (trim(form.password2.value) != "")) && (form.password.value != form.password2.value)){
                  alert( "Passwords Do Not Match." );
                } else {
			submitform( pressbutton );
		}
	}

//-->
</script>


<form action="index.php" method="post" name="adminForm">
<div id="editcell">

<table border="0" width="100%">
<tr>
	<td width="50%" valign="top">

	<table class="adminlist">
	<tr>
		<td colspan="2">
			<h3><?php echo JText::_( "Add Joomla Site" ); ?></h3> </td>
	</tr>
	<tr>
		<td align="right">
			<?php echo JText::_( "Site Name" ); ?>
		</td>
		<td>
			<input type="text" name="name" value="<?php echo $this->items['name'];?>" />
		</td>
        </tr>
	<tr>
		<td align="right">
			<?php echo JText::_( "Site Title" ); ?>
		</td>
		<td>
			<input type="text" name="title" value="<?php echo $this->items['title'];?>" />
		</td>
        </tr>

    <tr>
        <td align="right">
            <?php echo JText::_( "E-Mail" ); ?>
        </td>
        <td>
			<input type="text" name="email" value="<?php echo $this->items['email'];?>" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <?php echo JText::_( "Password" ); ?>
        </td>
        <td>
			<input type="password" name="password" />
        </td>
    </tr>
    <tr>
        <td align="right">
            <?php echo JText::_( "Confirm Password" ); ?>
        </td>
        <td>
			<input type="password" name="password2" />
        </td>
    </tr>





	</table>

	</td>

</tr>
</table>



</div>

<input type="hidden" name="option" value="com_mtwmultiple" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="sites" />


</form>
