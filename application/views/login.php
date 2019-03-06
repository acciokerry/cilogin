<!DOCTYPE html>
<html>
<head>
    <title>PSA Visualization Login</title>
</head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/css_login.css" type="text/css" media="all" />
<body>
<div class = "container">
    <div class="wrapper">
      <img src="<?php echo base_url(); ?>img/logo_psa.png" style="display: block;margin-left: auto;margin-right: auto;margin-bottom: auto;border:10;">
      <br>
        <form action="<?php echo base_url() ?>index.php/login" method="post" name="Login_Form" class="form-signin">       
            <h3 class="form-signin-heading">Welcome Back!</h3>
              <hr class="colorgraph"><br>
              <input type="text" class="form-control" name="username" placeholder="Username" required="" autofocus="" />
              <?php echo form_error('username'); ?>
              <input type="password" class="form-control" name="password" placeholder="Password" required=""/>            
              <?php echo form_error('password'); ?>
              <button class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit">Login</button>            
        </form>         
    </div>
</div>

</body>
</html>
