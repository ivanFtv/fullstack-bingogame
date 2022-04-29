<?php
session_start();
?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Bingo Game Gamma</title>
</head>
<body>

<nav class="navbar navbarbingo navbar-expand-lg navbar-light bg-warning">
<div class="container">
  <a class="navbar-brand" href="index.php"><img src="images/logo_test.png" id="logo" alt="logo"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <div class="col align-items-center d-flex justify-content-end divhead">
      <?php if (isset($_SESSION['logged'])) : ?>
        <p class="m-0 p-head">Hello <span class="font-weight-bold"><?php echo $_SESSION['firstname'] ?></span>, you have <span class="font-weight-bold" id="credits"><?php echo $_SESSION['credits'] ?></span><strong>€</strong> in your account</p>
        <?php endif ?>
    </div>
    <form class="form-inline my-2 my-lg-0 d-flex formheader">
     <!-- Button trigger modal -->
     <?php echo !isset($_SESSION['logged']) ? '<button type="button" class="btn btn-primary mx-2 font-weight-bold" data-toggle="modal" data-target="#exampleModal">Login</button>' : '<button type="button" class="btn btn-danger mx-2" onclick="logout()">Logout</button>' ?>
      <?php if (!isset($_SESSION['logged'])) : ?>
      <span class="text-primary font-weight-bold signup" data-toggle="modal" data-target="#exampleModal1">Sign Up</span>
      <?php endif ?>
    </form>
  </div>
  </div>
</nav>

<!-- Modal register -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Register New Account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="form-group">
    <input type="text" class="form-control" id="registerFirstname" placeholder="Your Firstname">
  </div>

  <div class="form-group">
    <input type="text" class="form-control" id="registerLastname" placeholder="Your Lastname">
  </div>

  <div class="form-group">
    <input type="text" class="form-control" id="registerUsername" placeholder="Choose your Username">
  </div>

  <div class="form-group">
    <input type="email" class="form-control" id="registerEmail" aria-describedby="emailHelp" placeholder="Enter email" onfocusout="checkEmail()">
    <small id="emailHelp" class="text-muted">We'll never share your email with anyone else.</small>
  </div>

  <div class="form-group">
    <input type="password" class="form-control" id="registerPassword" placeholder="Password">
  </div>

  <div class="form-group">
    <input type="password" class="form-control" id="registerPasswordConfirm" placeholder="Confirm Password" onfocusout="checkPass()">
    <small id="passHelp" class="form-text text-danger"></small>
  </div>
  <small id="registerHelp" class="form-text text-danger"></small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="registerSubmit" onclick="register()">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal login -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Login into your account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <input type="email" class="form-control" id="loginUsername" aria-describedby="emailHelp" placeholder="Enter your Username">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
  <div class="form-group">
    <input type="password" class="form-control" id="loginPassword" placeholder="Enter your Password">
  </div>
  <small id="loginHelp" class="form-text text-danger font-weight-bold"></small>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="login()">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal recarge -->
<div class="modal fade" id="recargeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="exampleModalLabel">Recharge your account</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <input type="number" class="form-control" id="recargeamount" aria-describedby="emailHelp" placeholder="50">
    <small id="recageHelp" class="form-text text-muted">How many euros do you want to top up the account?</small>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="recharge()">Recarge Now!</button>
      </div>
      </form>
    </div>
  </div>
</div>