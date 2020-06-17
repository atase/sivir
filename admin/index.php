<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>Admin</title>
    <script type="text/javascript" src="js/admin_page.js"></script>
    <link rel="stylesheet" type="text/css" href="css/admin_page.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
  	
  	<div class="main_page">
      <h2>SRAdmin</h2>
      <div class="main_page_func">
        <div class="main_page_admin_logo">
          <i class="fa fa-lock" aria-hidden="true"></i>
        </div>
        <div class="main_page_login">
          <form id="admin_login_form" action="php\auth.php" method="POST">
            <input id="username" type="text" name="username" placeholder="Username" required/>
            <input id="password" type="password" name="password" placeholder="Password" required/>
            <input type="submit" class="admin_login_btn" value="Login"/>
          </form>  
        </div>
      </div>
  	</div>

    <div class="notification_view" id="notification_view">
        <div id="login_failed" class="login_failed">
          <div class="close_notification_view">
            <i class="fa fa-window-close" aria-hidden="true" onclick="hideNotification('notification_view')"></i>
        </div>
          <div class="login_message">
            <i class="fa fa-bell" aria-hidden="true"></i>
            <p>Login failed !</p>
          </div>
        </div>
    </div>


    <?php  
      if(isset($_GET['auth']) && $_GET['auth'] == 0){
            echo '<script>
              document.getElementById("notification_view").style.display="block";
            </script>';
          }

    ?>
  </body>


 </html>