<?php 
foreach($reqData as $data){
?>
	<div class="a">
			<span class="b">
				<br>
		<?php echo $data['First Name']; echo " "; echo $data['Last Name'];?>
			</span>
		<span class ="c">
			<?php echo $data['Date']; ?>
		</span>
		<span class = "d">
			<?php echo $data['Expiry Date']; ?>	
		</span>
		<span class="e">
			<?php echo $data['Instructor Data'];?>
		</span>
		<!-- <br><br><br><br><br> -->
	</div>
	<br>
	
<?php } ?>
<style type="text/css">
	div.a{
		position: relative;
		width: 600px;
		height:160px;
		/*border: 3px solid red;*/
	}
	span.b{
		position: absolute;
		width: 294px;
		text-align: center;
		/*border: 3px solid yellow;*/
	}
	span.c{
		position: absolute;
		width: 300px;
		margin-top:41px;
		margin-left:310px;
		text-align: left;
		/*border: 3px solid blue;*/
	}
	span.d{
		position: absolute;
		width: 300px;
		margin-top:41px;
		margin-left:310px;
		text-align: right;
		/*border: 3px solid pink;*/
	}
	span.e{
		position: absolute;
		width: 300px;
		margin-top:132px;
		margin-left:310px;
		text-align: right;
		/*border: 3px solid green;*/
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	})
</script>