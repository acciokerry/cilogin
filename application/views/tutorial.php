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
        <label for="title"><?php echo $title; ?></label>
        <video width="760" height="580" controls>
            <source src="<?php echo base_url(); ?>video/<?php echo $video; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        </div>
        <!-- end of form's div -->
    </div>
</div>

<?php
    include "template/footer.php";
?>