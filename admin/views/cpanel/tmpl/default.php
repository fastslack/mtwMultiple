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

$version = "v0.1.0";

?>
<style>
/* standard form style table */
table.thisform {
	background-color: #F7F8F9;
	border: solid 1px #d5d5d5;
	width: 100%;
	padding: 10px;
	border-collapse: collapse;
}
table.thisform tr.row0 {
	background-color: #F7F8F9;
}
table.thisform tr.row1 {
	background-color: #eeeeee;
}
table.thisform th {
	font-size: 15px;
	font-weight:normal;
	font-variant:small-caps;
	padding-top: 6px;
	padding-bottom: 2px;
	padding-left: 4px;
	padding-right: 4px;
	text-align: left;
	height: 25px;
	color: #666666;
	background: url(../images/background.gif);
	background-repeat: repeat;
}
table.thisform td {
	padding: 3px;
	text-align: left;
	border: 1px;
	border-style:solid;
	border-bottom-color:#EFEFEF;
	border-right-color:#EFEFEF;
	border-left-color:#EFEFEF;
	border-top-color:#EFEFEF;	
}

table.thisform2 {
	background-color: #F7F8F9;
	border: solid 1px #d5d5d5;
	width: 100%;
	padding: 5px;
}
table.thisform2 td {
	padding: 5px;
	text-align: center;
	border: 1x;
	border-style: solid;
	border-bottom-color:#EFEFEF;
	border-right-color:#EFEFEF;
	border-left-color:#EFEFEF;
	border-top-color:#EFEFEF;
}
.thisform2 td:hover {
	background-color: #B5CDE8;
	border:	1px solid #30559C;
}
</style>
<table class="thisform">
<tr class="thisform">
	<td width="50%" valign="top" class="thisform">
    <table width="100%" class="thisform2">
    <tr class="thisform2">
    	<td align="center" height="100px" width="33%" class="thisform2" colspan="3">
        	<a href="index.php?option=com_mtwmultiple&amp;controller=config&amp;type=global" style="text-decoration:none;">
            	<img src="templates/khepri/images/header/icon-48-config.png" align="middle" border="0"/><br />
				<?php echo JText::_( 'Configuration' ); ?>
            </a>
        </td>
        <td align="center" height="100px" width="33%" class="thisform2">
            <a href="index.php?option=com_mtwmultiple&amp;controller=sites" style="text-decoration:none;">
            	<img src="templates/khepri/images/header/icon-48-plugin.png" align="middle" border="0" />
            	<br />
            	<?php echo JText::_( "Sites") ;?>
            	</a>
        </td>
        <td align="center" height="100px" width="33%" class="thisform2">
            <a href="http://matware.com.ar/foros.html" style="text-decoration:none;">
                <img src="templates/khepri/images/header/icon-48-help_header.png" align="middle" border="0"/>
                <br />
                <?php echo JText::_( "Help" ) ;?>
                </a>
        </td>
	</tr>
         </table>
      </td>
      <td width="50%" valign="top" align="center">
      <table border="1" width="100%" class="thisform">
         <tr class="thisform">
            <th class="cpanel" colspan="2">mtwMultiple Component</th></td>
         </tr>
         <tr class="thisform"><td bgcolor="#FFFFFF" colspan="2"><br />
      <div style="width=100%" align="center">
      <img src="components/com_mtwmultiple/images/logo.png" align="middle" alt="mtwMultiple Logo"/>
      <br /><br /></div>  
      </td></tr>       
         <tr class="thisform">
            <td width="120" bgcolor="#FFFFFF">Installed version:</td>
            <td bgcolor="#FFFFFF"><?php echo $version;?></td>
         </tr>
         <tr class="thisform">
            <td bgcolor="#FFFFFF">Copyright:</td>
            <td bgcolor="#FFFFFF">&copy; 2007 2008 2009 <a href="http://www.matware.com.ar/">http://www.matware.com.ar/</a></td>
         </tr>		  
         <tr class="thisform">
            <td bgcolor="#FFFFFF">License:</td>
            <td bgcolor="#FFFFFF"><a href="http://www.gnu.org/copyleft/gpl.html" target="_blank">GNU GPL</a></td>
         </tr>
      </table>
      </td>
   </tr>
</table>
