	<div class="row">
		<?php 
		foreach($reqData as $data) {
		?>
			<div class="column" style="text-align: center;">
			<?php echo $data['First Name']; echo " "; echo $data['Last Name'];	?>
			<br>
			<?php echo $data['Address']; ?>
			<br>
			<?php echo $data['City']; echo " "; echo $data['State']; echo " ";  echo $data['Zipcode']; ?>
			</div>
		<?php } ?>	
	</div>
<style type="text/css">
	* {
  box-sizing: border-box;
}

/* Create four equal columns that floats next to each other */
.column {
	/*text-align: center;*/
  float: left;
  width: 33%;
  padding: 10px;
  margin-bottom: 10px;
  margin-top: 10px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  /*clear: both;*/
}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	})
</script>