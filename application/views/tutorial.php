<?php
	include "template/header.php";
?>

<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-file-video-o"></i> Tutorial</h3>
        </div>
        <!-- form's div -->
        <div class="panel-body">
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="<?php echo base_url(); ?>video/test.mp4" allowfullscreen></iframe>
        </div>
        <label ><?php echo $title; ?></label>
        </div>
        <!-- end of form's div -->
    </div>
</div>

<?php
    include "template/footer.php";
?>