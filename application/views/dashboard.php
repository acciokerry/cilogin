<?php
	include "template/header.php";
?>
		<div class="col-md-9">
			<div class="panel panel-default">
			  <div class="panel-heading">
			    <h3 class="panel-title"><i class="fa fa-dashboard"></i> Dashboard</h3>
			  </div>
			  <div class="panel-body">
			  	<iframe width="800" height="600" src="<?php echo $this->session->userdata("power_bi") ?>" frameborder="0" allowFullScreen="true"></iframe>
			  </div>
			</div>
		</div>
	</div>
</div>
<?php
	include "template/footer.php";
?>