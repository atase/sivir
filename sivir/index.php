<!--

BACKUP BBPROJECT 123123;

-->
<?php  
  if(isset($_GET['auth']) && $_GET['auth'] == 1){
        header('Location: account.php');
      }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>VIVY</title>

    <script src="js/index.js"></script>
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>


  <body>

    
     
    <!-- Account -->
    <div id="display1" class="display">

      <div class="welcome_banner">
        <div class="welcome_banner_logo">
          <a href="index.php"><p>VIVY</p></a>
        </div>
        <div class="functions">
          <div id="login_display" onclick="displayLogin()">
            <p>Login</p>
          </div>
          <div id="register_display" onclick="displayRegister()">
            <p>Register</p>
          </div>
        </div>
      </div>

      <div class="info">
        <div class="container">
          <div class="info_first">
            <h1>One place for you and your friends !</h1>
          </div>
          <div class="info_third">
            <a href="https://www.instagram.com/"><p class="info_insta"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</p></a>
            <a href="https://vimeo.com/"><p class="info_vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i> Vimeo</p></a>
            <a href="https://www.youtube.com/"><p class="info_youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i> Youtube</p></a>
          </div>
        </div>
      </div>

    </div>

    <div id="display2" class="display">
      <div class="info">
        <div class="d2info_intro"><p>About developer</p></div>
        <div class="d2info_container">
          <div class="d2info_photo"></div>
          <div class="d2info_description">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin finibus euismod nisl et feugiat. Etiam risus risus, euismod sit amet pulvinar eget, tincidunt et lectus. <p/> <p>Nunc eros massa, sollicitudin at ante in, convallis egestas ligula. Integer ornare nibh in diam ultricies mattis. Proin vel eleifend tellus. Nam diam lacus, faucibus in felis vel, convallis lacinia libero. Curabitur venenatis tellus finibus odio ullamcorper luctus. In molestie turpis vitae dui finibus sagittis. Mauris consequat nibh posuere enim scelerisque tristique.  <p/> <p>Nunc eros massa, sollicitudin at ante in, convallis egestas ligula. Integer ornare nibh in diam ultricies mattis. Proin vel eleifend tellus. Nam diam lacus, faucibus in felis vel, convallis lacinia libero. Curabitur venenatis tellus finibus odio ullamcorper luctus. In molestie turpis vitae dui finibus sagittis. Mauris consequat nibh posuere enim scelerisque tristique. 
            </p>
          </div>
        </div>
      </div>
    </div>

    <div id="display_servicess" class="display">
      <div class="info">
        <div class="ds_intro"><p>Take a break and enjoy !</p></div>
        <div class="ds_container">
          <div class="ds_description"><p>VIVY (Video Instagram Vimeo Youtube) it's platform which
          offer you a way of watching medias from the most popular social networks. </p> <p>Here you can apply searching criterias to find specific medias on all three platforms in the same time or you can check what's new on the random channels from youtube, vimeo and random users from instagram. If you see a media that you like, don't forget to save it to your library so you can watch any time and also to show it to your friends.</p>
          <p>You can delete your account any time but be carefull that you will lose all your saved medias. </p></div>
        </div>
      </div>
    </div>

    <div id="display3" class="display">
      <div class="info">
        <div class="d3info_intro"><p>Search media or see something new</p></div>
        <div class="d3info_container">
          <div class="d3info_photo"></div>
          <div class="d3info_description"><p>The first things that you see when login VIVY are searching criterias. Set and Aplly and there you go, done! No matter what tab you select -Instagram, Vimeo, Youtube- you will discover videos with your settings.</p>
            <p>Title, tag, description, length, country and even your emotion, just set what fields you want and Apply criterias.</p>
            <p>Don't you know what to look for? Forget about settings and simply select a tab. There is a lot of new medias for you ! From the most popular channels on Youtube and Vimeo to the most popular users on Instagram, you will find something to watch.</p>
            <div class="d3_join">
              <p  onclick="displayRegister()">Join now !</p>
            </div>
          </div>
        </div>
      </div>
    </div>

     <div id="display4" class="display">
      <div class="info">
        <div class="d4info_intro"><p>Discover the world around you !</p></div>
        <div class="d4info_container">
          <div class="d4info_row1">
            <div class="d4row_description"><p>Wonder what's new on Instagram ? Just select Instagram tab and there it is ! Check the feed of the most popular users on Instagram or set criterias as tags, title and even country to filter your results.</p></div>
            <div class="d4row_photo"></div>
          </div>
          <div class="d4info_row2">
            <div class="d4row_description"><p>An elegant platform for all tastes, Vimeo. So many options for all ages and a perfect platform for your needs. Are you feeling sad, bored, nervous ? Then set 'Emotion' in searching criterias and select Vimeo Tab. In a few seconds, you will find the right video to make you happy ! </p></div>
            <div class="d4row_photo"></div>
          </div>
          <div class="d4info_row3">
            <div class="d4row_description"><p>Youtube, a platform for everyone. If you want to laugh, to listen to music, to relax with your friends or your family then just select Youtube tab and enjoy. Don't forget to save the video so you can watch it anytime.</p></div>
            <div class="d4row_photo"></div>
          </div>
        </div>
      </div>
    </div>

     <div id="display5" class="display">
      <div class="info">
        <div class="d5info_container">
          <div class="d5info_map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2712.176742751495!2d27.572722415018255!3d47.173976025757035!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40cafb6227e846bd%3A0x193e4b6864504e2c!2sFacultatea%20de%20Informatic%C4%83!5e0!3m2!1sro!2sro!4v1590754049069!5m2!1sro!2sro" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe></div>
          <div class="d5info_resources">
            <div class="resources1">
              <div class="resources1_title"><p>VIVY Resources</p></div>
              <div class="resources1_links">
                <a href="../docs/guide/index.html">User guide</a><br>
                <a href="../docs/report/index.html">Documentation</a><br>
                <a href="../admin/index.php">Administration board</a><br>
                <a href="#">Tutorial</a><br>
                <a href="../sivir_api/api/">VIVY API</a><br>
              </div>
            </div>
            <div class="resources2">
              <div class="resources2_title"><p>Contact</p></div>
              <div class="resources2_links">
                <p>For any informations about platform</p>
                <p>tase29alex@gmail.com</p>
              </div>
            </div>
            <div class="resources3">
              <div class="resources3_title"><p>Technologies</p></div>
              <div class="resources3_links">
                <a href="https://developers.google.com/youtube/v3">Youtube API</a><br>
                <a href="https://developer.vimeo.com/">Vimeo API</a><br>
                <a href="https://github.com/postaddictme/instagram-php-scraper">Instagram Scrapper</a><br>
                <a href="https://www.apachefriends.org/ro/index.html">XAMPP</a><br>
                <a href="https://www.w3schools.com/">W3School</a><br>
                <a href="https://pixabay.com/ro/">Pixabay</a><br>
              </div>
            </div>

            <div class="resources4">
              <div class="resources4_info">
                <p class="r4_insta"><i class="fa fa-instagram" aria-hidden="true"></i> 
                  <a href="https://www.instagram.com/"> Instagram</a></p>

                <p class="r4_vimeo"><i class="fa fa-vimeo" aria-hidden="true"></i>
                  <a href="https://vimeo.com/"> Vimeo</a>
                </p>

                <p class="r4_youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i><a href="https://www.youtube.com/"> Youtube </a></p>
              </div>
            </div>

          </div>
        </div>
        <div class="d5info_copyright">
          <p>Copyright @Nastasă Petru-Alexandru. All rights reserved.</p>
          <p>University ”Alexandru Ioan Cuza” Iasi</p>
          <p>Faculty of Computer Science</p>
        </div>
      </div>
    </div>
    <!-- End of account -->

    <div class="view" id="login_view">
      <div class="login">
        <div class="login_logo">
          <div class="close_view">
            <i class="fa fa-window-close" aria-hidden="true" onclick="hideLogin()"></i>
          </div>
          <div class="logo_picture">
            <i class="fa fa-smile-o" aria-hidden="true"></i>
          </div>
          <div class="logo_text">
            <p>Welcome!</p>
          </div>
        </div>
        <form id="login_form_id" class="login_form" action="php/auth.php" method="POST">
          <div class="login_input">

            <div class="login_row1">
                  
              <input type="text" class="user" name="username" placeholder="Username"/>
            </div>

            <div class="login_row2">
                  
              <input type="password" class="pass" name="password" placeholder="Password"/>
            </div>

          </div>    
          <div class="login_submit">
            <input type="submit" value="Login"/>
          </div>

          <div class="login_forgot_password">
            <p class="forgot_password_text" onclick="forgotPassword()">I don't remember my password</p>
          </div>

        </form>
      </div>
    </div>

    <div class="notification_view" id="notification_view">

     <div id="account_deleted" class="account_deleted">
      <div class="close_notification_view">
        <i class="fa fa-window-close" aria-hidden="true" onclick="hideNotification('account_deleted')"></i>
      </div>
        <div class="delete_message">
          <i class="fa fa-check" aria-hidden="true"></i>
          <p>Account deleted !</p>
        </div>
      </div>

      <div id="register_confirmation" class="register_confirmation">
        <div class="close_notification_view">
          <i class="fa fa-window-close" aria-hidden="true" onclick="hideNotification('register_confirmation')"></i>
        </div>
        <div class="register_message">
          <i class="fa fa-check" aria-hidden="true"></i>
          <p>Register succesfully !</p>
        </div>
      </div>

      <div id="login_failed" class="login_failed">
        <div class="close_notification_view">
        <i class="fa fa-window-close" aria-hidden="true" onclick="hideNotification('login_failed')"></i>
      </div>
        <div class="login_message">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <p>Login failed !</p>
        </div>
      </div>

    </div>

    <div class="view" id="forgot_password_view">
      <div id="forgot_password" class="forgot_password">
        <div class="close_notification_view">
        <i class="fa fa-window-close" aria-hidden="true" onclick="hideForgotPassword()"></i>
      </div>
        <div class="forgot_message">
          <i class="fa fa-key" aria-hidden="true"></i>
          <input type="text" id="email_forgot_password" placeholder="Email" required/>
          <input type="text" id="birth_forgot_password" placeholder="Birth(1999-06-29)" required/>
          <input type="text" id="name_forgot_password" placeholder="Last name" required/>
          <button type="submit" class="forgot_btn" value="Submit" onclick="forgotPasswordView()">Submit</button>
        </div>
      </div>

    </div>


    <div class="view" id="forgot_password_data">
      <div class="password_data" id="pass_data">
        <div class="close_notification_view">
          <i class="fa fa-window-close" aria-hidden="true" onclick="hidePasswordData()"></i>
        </div>
        <div class="message_data">
          <i class="fa fa-key" aria-hidden="true"></i>
          <p>Hello from VIVY team !</p>
          <p></p>
          <p></p>
        </div>
      </div>

      <div id="pass_failed" class="pass_failed">
        <div class="close_notification_view">
          <i class="fa fa-window-close" aria-hidden="true" onclick="hidePasswordData()"></i>
        </div>
        <div class="pass_message">
          <i class="fa fa-bell" aria-hidden="true"></i>
          <p>Something went wrong !</p>
        </div>
      </div>
    </div>

    <div class="view" id="register_view">
      <div id="register">
        <div class="close_view">
          <i class="fa fa-window-close" aria-hidden="true" onclick="hideRegister()"></i>
        </div>
          <div class="register_logo">
            <div class="register_text">
              <p>Join us and enjoy social-medias from your favorite platforms</p>
            </div>
          </div>
            <div class="register_input">
              <form id="register_form_id" class="register_form" action="php/register.php" method="POST">
                <input type="text" name="first_name" placeholder="First name" required/>
                <input type="text" name="last_name" placeholder="Last name" required/>
                <input type="text" name="birth" placeholder="Date of birth (1999-06-29)" required/>

                <input list="gender" name="sex" placeholder="Gender" required/>
              <datalist id="gender">
                <option value="Doesn't matter">
                <option value="Male">
                <option value="Female">
              </datalist>

            <input type="text" name="email" placeholder="Email" required/>
            <input type="text" name="username" placeholder="Username" required/>
            <input type="text" name="password" placeholder="Password" required/>

              </form>
            </div>
            <div class="register_buttons">
              <button type="submit" form="register_form_id" class="reg_btn" value="Register">Register</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
      window.onscroll = function(){
        var scroll = window.pageYOffset;
        document.getElementById("login_view").style.top = "0%";
        document.getElementById("login_view").style.bottom =  "0%";
        document.getElementById("notification_view").style.top = "0%";
        document.getElementById("notification_view").style.bottom =  "0%";
        document.getElementById("register_view").style.top = "0%";
        document.getElementById("register_view").style.bottom = "0%"
      }
    </script>

    <?php
      if(isset($_GET['reg']) && $_GET['reg']==1){
        $username = $_GET['username'];
        $password = $_GET['password'];
        echo '<script>
          document.getElementById("notification_view").style.display="block";
          document.getElementById("register_confirmation").style.display="block";
        </script>';
      }else if(isset($_GET['reg']) && $_GET['reg']==0){
        echo '<script>
          document.getElementById("forgot_password_data").style.display="block";
          document.getElementById("pass_failed").style.display="block";
        </script>';
      }

      if(isset($_GET['del']) && $_GET['del'] == 1){
        echo'
          <script>
            document.getElementById("notification_view").style.display="block";
            document.getElementById("account_deleted").style.display="block";
          </script>
        ';
      }

      if(isset($_GET['auth']) && $_GET['auth'] == 0){
        echo '<script>
          document.getElementById("notification_view").style.display="block";
          document.getElementById("login_failed").style.display="block";
        </script>';
      }
    ?>
  </body>
</html>

