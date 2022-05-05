<?php
    //  ----------- LOGIN CONFIGURATION START------------

    define('USERNAME', 'admin');
    define('PASSWORD', 'secret');

    //----------- LOGIN CONFIGURATION END------------

    session_start();

    if (isset($_GET['cmd']) and ($_GET['cmd']=='logout'))
    {
      session_unset();
      //header('Location: '.$_SERVER['PHP_SELF']);
      header("Location: index.php"); // Return to frontend (index.php) 
      exit;
    }

    $relay_states=[];

    function read_current_relay_states(){
      $fh=fopen('relaystate.txt', 'r');//open .txt filefor reading

      $r_state=fgets($fh);// get the file content

      $relay_states=str_split($r_state);

      fclose($fh);
      return $relay_states;
    }

    //if ($_SESSION['IOT_access']!==TRUE)
    if (!isset($_SESSION['IOT_access']))
    {
      if (isset($_POST['username']) and isset($_POST['password']))
      { 
        if (($_POST['username']===USERNAME) and ($_POST['password']===PASSWORD)) 
        {
          $_SESSION['IOT_access']=TRUE;
          $relay_states = read_current_relay_states();
        }
        else
        {
          header("Location: index.php"); // Return to frontend (index.php
        }   
      }
      else
      {
        session_write_close();
        header("Location: index.php"); // Return to frontend (index.php) 
      }
    }
    else 
    {
      $relay_states = read_current_relay_states();
    }
    session_write_close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="EtaNetwork(Daud)">
    <title>IOT Controller</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-switch.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="css/custom.css" rel="stylesheet">
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 760px;">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> An IOT Project</h3>
              </div>
              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <a href="<?php echo $_SERVER['PHP_SELF']; ?>?cmd=logout" class="text-right h4">Logout</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Appliance Control Panel</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p class="text-muted font-13 m-b-30">
                      Use the switch below to turn ON/OFF Appliance
                    </p>
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>S/N</th>
                          <th>Appliance</th>
                          <th>Appliance State</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $n=1; foreach($relay_states as $relay_state):?>
                        <tr>
                          <td><?php echo $n;?></td>
                          <td>APPLIANCE <?php echo $n;?></td>
                          <td>
                            <input type="checkbox" onChange="javascript:toggle(<?php echo $n;?>)" 
                            <?php echo $relay_state=='1'?"checked":"";?> name="Appliance_<?php echo $n;?>" />
                          </td>
                        </tr>
                      <?php  $n++; endforeach;?>                       
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>        
    <!-- /page content -->
    <!-- footer content -->
    <footer>
      <div class="pull-right">
         © 2022 EDLAC<a href="#"></a>
      </div>
      <div class="clearfix"></div>
    </footer>
    <!-- /footer content -->
    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.js"></script>
    <script src="js/bootstrap-switch.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="js/switch.js"></script> 
  </body>
</html>