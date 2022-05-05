<?php //$base = __DIR__ . '/../'; ?>
<?php 
  function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="EtaNetwork(Daud)">
    <meta name="keyword" content="Appliance Controller (IOT)">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta property="og:title" content="IOT Switch" />
    <meta property="og:description" content="IOT Appliance Switch Interface" />
    <meta property="og:image" content="<?php echo(url().'images/switch.png'); ?>" />
    <meta property="og:url" content="<?php echo(url()); ?>">
    <meta name="twitter:card" content="<?php echo(url().'images/switch.png'); ?>">
    <!--  Non-Essential, But Recommended -->
    <meta property="og:site_name" content="IOT Switch">
    <meta property="og:type" content="website" />
    <meta name="twitter:image:alt" content="<?php echo(url().'images/switch.png'); ?>">
    <title>Device Controller</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>
  <body class="login-body">
    <div class="container">
      <form class="form-signin" action="switch.php" method="post">
        <h2 class="form-signin-heading">DEVICE CONTROLLER</h2>
        <div class="login-wrap">
            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus>
            <input type="password" name="password" class="form-control" placeholder="Password">
            <label class="checkbox">An IOT Project</label>
            <button class="btn btn-lg btn-login btn-block" type="submit">SIGN IN</button>
            <label class="checkbox text-center">© 2022 EDLAC</label>
        </div>
      </form>
    </div>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
  </body>
</html>
