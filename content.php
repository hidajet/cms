
<?php 
include("includes/connection.php");
include("includes/functions.php");
include("includes/headers.php");

find_selected_page();


?>
<table id="structure">
<tr>
	<td id="navigation">
		<?php echo navigation($select_sub, $select_page,false); ?>
	</td>
	<td id="page">
		<?php if(!is_null($select_sub)){?>
		<h2><?php echo $select_sub["menu_name"]; ?></h2>
			<?php echo "<p>Welcome to {$select_sub[menu_name]} page.</p>"; ?>
		<?php }elseif(!is_null($select_page["menu_name"])){ ?>
		<h2><?php echo $select_page["menu_name"]; ?></h2>
			<div class="page-content">
				<?php echo $select_page["content"]; ?>
			</div>
		<?php }else{ ?>
			<h2>Select the subject or page to edit.</h2>
		<?php } ?>

	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
