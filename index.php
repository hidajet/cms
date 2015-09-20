
<?php 
include("includes/connection.php");
include("includes/functions.php");
find_selected_page();
include("includes/headers.php");
?>

<table id="structure">
<tr>
	<td id="navigation">
		<?php echo public_navigation($select_sub, $select_page,true); ?>
	</td>
	<td id="page">
		<?php if(!is_null($select_page)){?>
		<h2><?php echo $select_page['menu_name']; ?></h2>
			<div class="page-content">
				<?php echo $select_page['content']; ?>
			</div>
		<?php }else{ ?>
			<h2>Welcome to Hido & Co.</h2>
		<?php } ?>

	</td>
</tr>
</table>

<?php 
include("includes/footers.php"); 
?>
