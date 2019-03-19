<?php
	include "template/header.php";
?>

<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-upload"></i> Upload</h3>
        </div>
        <!-- form's div -->
        <div class="panel-body">
        <?php echo $error;?>

        <?php echo form_open_multipart('upload/do_upload');?>

        <!--<form action="<?php echo base_url(); ?>upload/act" method="post" target="_blank"> -->
            <!-- upload -->
            <div class="form-group">
                <div class="btn btn-primary btn-sm float-left">
                    <input type="file" name="fupload" size="40"/>
                </div>
                
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
        </div>
        <!-- end of form's div -->
    </div>
</div>
<?php
	include "template/footer.php";
?>