<?php 
foreach($reqData as $data){
?>
	<div class="a">
			<span class="b">
				<br>
		<?php echo $data['First Name']; echo " "; echo $data['Last Name'];?>
			</span>
		<span class="e">
			<?php echo $data['Site Data']; ?>
		</span>	
		<span class ="f">
			<?php echo $data['Location Data']; ?>
		</span>
		<span class = "g">
			<?php echo $data['Instructor Data']; ?>
		</span>
		<br><br><br><br><br>
		<span class="c">
			<?php echo $data['Date']; ?>
		</span>
		<span class="d">
			<?php echo $data['Expiry Date']; ?>
		</span>
	</div>
	<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	
<?php } ?>
<style type="text/css">
	div.a{
		position: relative;
		width: 600px;
		height:140px;
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
		text-align: center;
		width:147px;
		/*border: 3px solid green;*/
	}
	span.d{
		position: absolute;
		text-align: center;
		margin-left:147px;
		width:147px;
		/*border: 3px solid pink;*/
	}
	span.e{
		position: absolute;
		width: 300px;
		margin-left:310px;
		text-align: left;
		/*border: 3px solid black;*/
	}
	span.f{
		position: absolute;
		width: 300px;
		margin-top:41px;
		margin-left:310px;
		text-align: center;
		/*border: 3px solid blue;*/
	}
	span.g{
		position: absolute;
		width: 300px;
		margin-top:75px;
		/*height:41px;*/
		margin-left:310px;
		text-align: right;
		/*border: 3px solid gray;*/
	}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		window.print();
	})
</script>