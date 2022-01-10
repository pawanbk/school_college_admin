<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Login |Baramajhiya Baje ko Peda</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Baramajhiya Baje ko Peda" name="description" />
  <meta content="Pawan bk" name="author" />
  
  <!-- App favicon -->
  <link rel="shortcut icon" href="<?=base_url(); ?>assets/images/favicon.ico">

  <!-- Bootstrap Css -->
  <link href="<?=base_url(); ?>assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

  <!-- Icons Css -->
  <link href="<?=base_url(); ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

  <!-- App Css-->
  <link href="<?=base_url(); ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>
  <div class="account-pages my-5 pt-sm-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
          <div class="card overflow-hidden">
            <div class="bg-soft-primary">
              <div class="row">
                <div class="col-7">
                  <div class="text-primary p-4">
                    <h5 class="text-primary">Baramajhiya Baje ko Peda </h5>
                    <p>Sign in to continue.</p>
                  </div>
                </div>
                <div class="col-5 align-self-end">
                  <img src="<?=base_url(); ?>assets/images/profile-img.png" alt="" class="img-fluid">
                </div>
              </div>
            </div>
            <div class="card-body pt-0"> 
              <div>
                <a href="index.html">
                  <div class="avatar-md profile-user-wid mb-4">
                    <span class="avatar-title rounded-circle bg-light">
                      <img src="<?=base_url(); ?>assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                    </span>
                  </div>
                </a>
              </div>
              <?php 
              echo ($this->session->flashdata('error_msg'))?'<div>'.$this->session->flashdata('error_msg').'</div>': '';
              ?><br>
              <div class="p-2">
                <form class="form-horizontal" method="post" action="<?=site_url('Login')?>">
                  <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" required class="form-control" name="username_info" placeholder="Enter Email Address">
                  </div>

                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" required name="password_info" class="form-control" placeholder="Enter password">
                  </div>

                  <div class="mt-3">
                    <button class="btn btn-primary btn-block waves-effect waves-light" id="checkLogin" name="checkLogin" type="submit">Log In</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
