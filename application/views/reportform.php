<?php
	include "template/header.php";
?>

<div class="col-md-9">
    <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-line-chart"></i> Report</h3>
        </div>
        <!-- form's div -->
        <div class="panel-body">
        <form action="<?php echo base_url(); ?>prt/pcs" method="post" target="_blank">
        <?php if($nama!='admin'){ ?>
        <input type="hidden" id="group" value="<?php echo $group; ?>">
        <?php } ?>
        <!-- report's types -->
        <div class="form-group">
            <label for="type">Report Type</label>
            <select class="form-control" id="type" name="type" required="true" >
                <option value="">-- Choose report's type --</option>
                <?php foreach($report_types as $key => $value){ ?>
                    <option value="<?php echo $value; ?>"><?php echo $key;?></option>
                <?php } ?>
            </select>
        </div>
        <!-- end of report's type -->
        <?php if($role['admin']){ ?>
        <!-- groups -->
        <div class="form-group">
            <label for="groups">Integrators</label>
            <select class="form-control" id="groups" name="groups" required="true" >
                <!--<option value="">-- Choose groups' name --</option>-->
                <?php foreach($groups as $key => $value){ ?>
                    <option value="<?php echo $value->Customer_Group; ?>"><?php echo $value->Customer_Group;?></option>
                <?php } ?>
            </select>
        </div>
        <!-- end of groups -->
        <?php } ?>
        <?php if(!$role['customer']){ ?>
        <!-- vendors -->
        <div class="form-group">
            <label for="vendors">Vendors</label>
            <select class="form-control" id="vendors" name="vendors" required="true" >
            <option value="">-- Choose Vendors --</option>
            </select>
        </div>
        <!-- end of vendors -->
        <?php } ?>
        <!-- start date -->
        <div class="form-group">
            <label for="vendors">From</label>
            
            <div class="input-group date" data-provide="datepicker">
                <input type='text' class="form-control" name="from" required="true" id="from" autocomplete="off"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <!-- end of start date -->
        <!-- end date -->
        <div class="form-group">
            <label for="vendors">To</label>
            <div class="input-group date" data-provide="datepicker">
                <input type='text' class="form-control" name="to" required="true" id="to" autocomplete="off"/>
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </div>
        <!-- end of end date -->
        <!-- output -->
        <div class="form-group">
            <label for="outputs">Output</label>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" value="pdf" name="output" class="custom-control-input" required="true" >
                <label class="custom-control-label" for="pdf">PDF</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" value="xls" name="output" class="custom-control-input" required="true" >
                <label class="custom-control-label" for="xls">SpreadSheet</label>
            </div>
        </div>
        <!-- end of output -->
        
        <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
        <!-- end of form's div -->
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url();?>js/encoding.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/form.js"></script>
<?php
	include "template/footer.php";
?>