

<!DOCTYPE html>
<html>
<head>
	<title> PSA Integrator Visualization</title>
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/font-awesome.min.css">
	<link href="<?php echo base_url(); ?>css/prettify.css" rel="stylesheet">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
	<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="<?php echo base_url(); ?>img/logo_psa.png" style="width:70%;border:10;">
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        	<div class="navbar-form navbar-right">
				<a href="<?php echo base_url() ?>index.php/dashboard/logout" type="submit" class="btn btn-success"><i class="fa fa-sign-out"></i> Logout</a>
        	</div>
      </div>
    </nav>
<div class="container" style="margin-top: 80px">
	<div class="row">
		<div class="col-md-3">
			<div class="list-group">
			  <a href="#" class="list-group-item active" style="text-align: center;background-color: black;border-color: black">
			    Welcome, <?php echo $this->session->userdata("user_nama") ?>
			  </a>
			  <a href="<?php echo base_url(); ?>dashboard" class="list-group-item"><i class="fa fa-dashboard"></i> Dashboard</a>
				<?php if(!$role['vendor']){ ?>
				<a href="<?php echo base_url(); ?>prt/reportform" class="list-group-item"><i class="fa fa-line-chart"></i> Report</a>
			<?php } ?>
				<a href="<?php echo base_url(); ?>tutorial" class="list-group-item"><i class="fa fa-file-video-o"></i> Tutorial</a>
				<a href="<?php echo base_url(); ?>upload" class="list-group-item"><i class="fa fa-upload"></i> Upload</a>
			</div>
		</div>