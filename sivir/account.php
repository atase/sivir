<?php 
	session_start();

	if(strcmp($_SESSION['token'], "none") == 0 || empty($_SESSION['token'])){
		header('Location: index.php');
	}

?>


<!DOCTYPE html>
<html>
<head>
	<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>Sivir</title>

    <script src="https://platform.instagram.com/en_US/embeds.js"></script>
    <script src="js/account.js"></script>
    <link rel="stylesheet" type="text/css" href="css/account.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  </head>
</head>
<body>

	<!--
		Main page BEGIN

		Hole page as view. 
		Two main sections :
				* User options
				* User display videos 
	-->
	<div class="main_page">


		<!--User informations, searching criterias, video display BEGIN-->
		<div class="center_panel">
			<!--Youtube tab : videos from youtube-->


			<div id="Youtube" class="tabcontent">
				<div class="loading_screen" id="loader_youtube">
					<div class="loader"></div>
				</div>
				<div class="display_videos" id="display_videos_youtube">	
				</div>
				<div class="video_saved" id = "save_confirmation_youtube">
					<div class="video_saved_elements">
						<p>Youtube video has been added to your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationSave('save_confirmation_youtube', 'footerY')"></i>
					</div>
				</div>
				<div id="view_media_youtube">
						<i class="fa fa-window-close" onclick = "hideView('view_media_youtube', 'footerY')"></i>
						<div id="view_media_html_youtube"></div>
				</div>
				<div class="footer" id="footerY">
					<div class="footer_content">
						<div class="footer_refresh"><i class="fa fa-refresh" aria-hidden="true" onclick="document.getElementById('youtubeTab').click()"></i></div>
						<div class="footer_search">
							<input type="text" name="footer_tag" id="yfooter_tag" placeholder="Quick search by tag">
							<i class="fa fa-search" aria-hidden="true" onclick="quickSearchYoutube()"></i>
						</div>
					</div>
				</div>
			</div>

			<!--Instagram tab : videos from instagram
			-->
			<div id="Instagram" class="tabcontent">
				<div class="loading_screen" id="loader_instagram">
					<div class="loader"></div>
				</div>
				<div class="display_videos" id="display_videos_instagram">	
				</div>
				<div class="video_saved" id = "save_confirmation_instagram">
					<div class="video_saved_elements">
						<p>Instagram media has been added to your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationSave('save_confirmation_instagram', 'footerI')"></i>
					</div>
				</div>

				<div id="view_media_instagram">
						<i class="fa fa-window-close" onclick = "hideView('view_media_instagram', 'footerI')"></i>
						<div id="view_media_html_instagram"></div>
				</div>
				<div class="footer" id="footerI">
					<div class="footer_content">
						<div class="footer_refresh"><i class="fa fa-refresh" aria-hidden="true" onclick="document.getElementById('instagramTab').click()"></i></div>
						<div class="footer_search">
							<input type="text" name="footer_tag" id="ifooter_tag" placeholder="Quick search by tag">
							<i class="fa fa-search" aria-hidden="true" onclick="quickSearchInstagram()"></i>
						</div>
					</div>
				</div>
			</div>

			<!--Vimeo tab : videos from vimeo-->
			<div id="Vimeo" class="tabcontent">
				<div class="loading_screen" id="loader_vimeo">
					<div class="loader"></div>
				</div>
				<div class="display_videos" id="display_videos_vimeo">	
				</div>
				<div class="video_saved" id = "save_confirmation_vimeo">
					<div class="video_saved_elements">
						<p>Vimeo video has been added to your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationSave('save_confirmation_vimeo', 'footerV')"></i>
					</div>
				</div>
				<div id="view_media_vimeo">
						<i class="fa fa-window-close" onclick = "hideView('view_media_vimeo', 'footerV')"></i>
						<div id="view_media_html_vimeo"></div>
				</div>
				<div class="footer" id="footerV">
					<div class="footer_content">
						<div class="footer_refresh"><i class="fa fa-refresh" aria-hidden="true" onclick="document.getElementById('vimeoTab').click()"></i></div>
						<div class="footer_search">
							<input type="text" name="footer_tag" id="vfooter_tag" placeholder="Quick search by tag">
							<i class="fa fa-search" aria-hidden="true" onclick="quickSearchVimeo()"></i>
						</div>
					</div>
				</div>
			</div>

			<!--Account tab : account informations-->
			<div id="Account" class="tabcontent">
				<div class="informations_options">
					<div class="profile_picture" style="background-image: url('<?php echo $_SESSION['profile_pic'];?>');"></div>
					<div class="user_informations">
						<div class="info_values">
							<input type="text" id="full_name" value="Full name : <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];?>" readonly><br/>
							<input type="text" id="age" value="Birth : <?php echo $_SESSION['birth'];?>" readonly><br/>
							<input type="text" id="sex" value="Gender : <?php echo $_SESSION['sex'];?>" readonly><br/>
							<input type="text" id="email" value="Email : <?php echo $_SESSION['email'];?>" readonly><br/>
							<input type="text" id="username" value="Username : <?php echo $_SESSION['username'];?>" readonly><br/>
							<input type="text" id="password" value="Password : <?php echo $_SESSION['password'];?>" readonly><br/>
						</div>
					</div>
					<div class="user_options">
						<div class="user_options_buttons">
							<button class="change_picture" onclick="displayOption('option_change_picture')">Change picture</button>
							<button class="change_email" onclick="displayOption('option_change_email')">Change email</button>
							<button class="change_username" onclick="displayOption('option_change_username')">Change username</button>
							<button class="change_password" onclick="displayOption('option_change_password')">Change password</button>
							<button class="delete_account" onclick="displayOption('option_delete_account')">Delete account</button>
						</div>
					</div>
				</div>
				<div id="user_options_input_id" class="user_options_input">

					<div id="option_change_picture">

						<div class="change_confirm user_options_close" id="change_profile_pic_confirm">
							<p>Profile picture changed !</p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_profile_pic_confirm')"></i>
						</div>

						<div class="change_error user_options_close" id="change_profile_pic_error">
							<p>An error occured ! </p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_profile_pic_error')"></i>
						</div>

						<div id="user_options_view_picture" class="user_options_view user_options_close">
							<i class="fa fa-window-close" onclick="hideOption('change_profile_pic_confirm')"></i>

							<form method="POST" action="php/changeProfilePic.php" enctype="multipart/form-data" class="option_changes_input" id="form_change_pic_id">
								 <input type="file" name="profile_picture">
							</form>

							<div class="option_changes_buttons" id="form_change_pic_buttons_id">
								<button type="submit" form="form_change_pic_id">Submit</button>
							</div>
						</div>
					</div>


					<div id="option_change_email">

						<div class="change_confirm user_options_close" id="change_email_confirm">
							<p>Email changed !</p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_email_confirm')"></i>		
						</div>

						<div class="change_error user_options_close" id="change_email_error">
							<p>An error occured ! </p>
							<p>Make sure to confirm email correctly ! </p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_email_error')"></i>		
						</div>

						<div  id="user_options_view_email" class="user_options_view user_options_close">
							<form method="POST" action="php/changeEmail.php" id="form_change_email_id" class="option_changes_input">
								<input type="text" name="new_email" placeholder="Enter new email " required/>
								<input type="text" name="confirm_new_email" placeholder="Confirm new email" required/>
							</form >

							<div class="option_changes_buttons" id="form_change_email_buttons_id">
								<button type="submit" form="form_change_email_id">Submit</button>
							</div>
							<i class="fa fa-window-close" onclick="hideOption('option_change_email')"></i>
						</div>

					</div>


					<div id="option_change_username">
						<div class="change_confirm user_options_close" id="change_username_confirm">
							<p>Username changed !</p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_username_confirm')"></i>	
						</div>

						<div class="change_error user_options_close" id="change_username_error">
							<p>An error occured ! </p>
							<p>Make sure to confirm username correctly ! </p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_username_error')"></i>	
						</div>
						<div id="user_options_view_username" class="user_options_view user_options_close">
							<form  method="POST" action="php/changeUsername.php" id="form_change_username_id" class="option_changes_input">
								<input type="text" name="new_username" placeholder="Enter new username" required/>
								<input type="text" name="confirm_new_username" placeholder="Confirm new username" required/>
							</form >

							<div class="option_changes_buttons" id="form_change_username_buttons_id">
								<button type="submit" form="form_change_username_id">Submit</button>
							</div>
							<i class="fa fa-window-close" onclick="hideOption('option_change_username')"></i>
						</div>
					</div>

					<div id="option_change_password">

						<div class="change_confirm user_options_close" id="change_password_confirm">
							<p>Password changed !</p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_password_confirm')"></i>
						</div>

						<div class="change_error user_options_close" id="change_password_error">
							<p>An error occured ! </p>
							<p>Make sure to confirm password correctly ! </p>
							<i class="fa fa-window-close" onclick="confirmationHideOption('change_password_error')"></i>
						</div>

						<div id="user_options_view_password" class="user_options_view user_options_close">
							<form method="POST" action="php/changePassword.php" id="form_change_password_id" class="option_changes_input">
								<input type="text" name="new_password" placeholder="Enter new password" required/>
								<input type="text" name="confirm_new_password" placeholder="Confirm new password" required/>
							</form>

							<div class="option_changes_buttons" id="form_change_password_buttons_id">
								<button type="submit" form="form_change_password_id">Submit</button>
							</div>
							<i class="fa fa-window-close" onclick="hideOption('option_change_password')"></i>
						</div>
					</div>


					<div id="option_delete_account" class="user_options_view user_options_close">
						<i class="fa fa-window-close" onclick="hideOption('option_delete_account')"></i>

						<div class="option_changes_input">
							<p>All your personal data will be deleted !</p>
							<p>Are you sure you want to delete your account ? </p>
							<form method="POST" action="php/deleteAccount.php" id="form_delete_account_id">
							</form>
						</div>

						<div class="option_changes_buttons">
							<button type="submit" form="form_delete_account_id">Delete</button>
						</div>

					</div>
				</div>
			</div>

			<!-- Searching criterias tab -->
			<div id="Criterias" class="tabcontent">
				<div class="search">
					<form class="search_form">
						<input list="browse_emotion" name="emotion" id="emotion" placeholder="How are you feeling today ? "required/>
						<datalist id="browse_emotion">
							<option value="happy"></option>
							<option value="sad"></option>
							<option value="nervous"></option>
							<option value="bored"></option>
						</datalist>
						<br/>
						<input type="text" name="title" id="title" placeholder="Do you prefer any title ? "/><br/>
						<input type="text" name="location" id="country" placeholder="Would like to see something from a specific country ?"/><br/>

						<input list="browse_length" name="length" id="length" placeholder="How much free time do you have ? "/>
						<datalist id="browse_length">
							<option value="any"></option>
							<option value="long"></option>
							<option value="medium"></option>
							<option value="short"></option>
						</datalist><br/>
						<input type="text" name="tags" id="tags" placeholder="Tell me some tags !"/><br/>
						<textarea name="description" id="description" placeholder="Describe the video if you want ." rows="10" cols="77"></textarea><br/>
					</form>
					<button class="search_button not_pressed" id="big_search_button" onclick="setParams()">Apply</button>
				</div>
				<div id="search_settings_window">
						<div class="search_settings_alert user_options_close">
							<p>You must set at least one field !</p>
							<i class="fa fa-window-close" onclick = "hideView('search_settings_window','none')"></i>
						</div>
					</div>
			</div>

			<div id="Library" class="tabcontent">
			
				<div class="display_videos" id="saved_media"></div>

				<div class="video_deleted" id = "deleted_confirmation_youtube">
					<div class="video_deleted_elements">
						<p>Youtube video has been deleted from your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationDelete('deleted_confirmation_youtube')"></i>
					</div>
				</div>


	
				<div class="video_deleted" id = "deleted_confirmation_vimeo">
					<div class="video_deleted_elements">
						<p>Vimeo video has been deleted from your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationDelete('deleted_confirmation_vimeo')"></i>
					</div>
				</div>

				<div class="video_deleted" id = "deleted_confirmation_instagram">
					<div class="video_deleted_elements">
						<p>Instagram media has been deleted from your library !</p>
						<i class="fa fa-window-close" onclick = "hideConfirmationDelete('deleted_confirmation_instagram')"></i>
					</div>
				</div>

				<div id="view_media">
						<i class="fa fa-window-close" onclick = "hideView('view_media','none')"></i>
						<div id="view_media_html"></div>
				</div>
			</div>
			<div class="banner" id="nav_bar">
			<div class="navigation">
				<div class="nav1_opt">
					<i class="fa fa-search tablinks" aria-hidden="true" onclick="openTab('Criterias')"  id="defaultOpen"></i>
				</div>
				<div class="nav2_opt">
					<i class="fa fa-vimeo tablinks" aria-hidden="true" onclick="openTab('Vimeo')" id="vimeoTab"></i>
				</div>
				<div class="nav3_opt">
					<i class="fa fa-youtube-play tablinks" aria-hidden="true" onclick="openTab('Youtube')" id="youtubeTab"></i>
				</div>
				<div class="nav4_opt">
					<i class="fa fa-instagram tablinks" aria-hidden="true" onclick="openTab('Instagram')" id="instagramTab"></i>
				</div>
				<div class="nav5_opt">
					<i class="fa fa-book tablinks" aria-hidden="true" onclick="openTab('Library')"></i>
				</div>
				<div class="nav6_opt">
					<i class="fa fa-user tablinks" aria-hidden="true" onclick="openTab('Account')" id="account_info_id"></i>
				</div>
				<div class="nav7_opt">
					<i class="fa fa-sign-out tablinks" aria-hidden="true" onclick="signout()" id="signout"></i>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>
	<!--
		Main page END
	-->
	<script type="text/javascript">
		document.getElementById("defaultOpen").click();
		setSessionUserId("<?php echo $_SESSION['id']; ?>");
	</script>

	<?php
	if(isset($_GET['change_email'])){
        echo '<script>
          	document.getElementById("account_info_id").click();
          	document.getElementById("user_options_input_id").style.display = "block";
          	document.getElementById("option_change_email").style.display="block";
          	document.getElementById("user_options_view_email").style.display="none";
        </script>';
        if($_GET['change_email']==1){
        	echo '<script>
        	document.getElementById("change_email_error").style.display="none";
			document.getElementById("change_email_confirm").style.display = "block";
        </script>';
        }else if($_GET['change_email']==0){
        	echo '<script>
        	document.getElementById("change_email_error").style.display="block";
			document.getElementById("change_email_confirm").style.display = "none";
        </script>';
        }
      }

      if(isset($_GET['account_info_display']) && $_GET['account_info_display']==1){
        echo '<script>
          	document.getElementById("account_info_id").click();
        </script>';
      }


      if(isset($_GET['change_username'])){
        echo '<script>
          	document.getElementById("account_info_id").click();
          	document.getElementById("user_options_input_id").style.display = "block";
          	document.getElementById("option_change_username").style.display="block";
          	document.getElementById("user_options_view_username").style.display="none";
        </script>';
        if($_GET['change_username']==1){
        	echo '<script>
        	document.getElementById("change_username_error").style.display="none";
			document.getElementById("change_username_confirm").style.display = "block";
        </script>';
        }else if($_GET['change_username']==0){
        	echo '<script>
        	document.getElementById("change_username_error").style.display="block";
			document.getElementById("change_username_confirm").style.display = "none";
        </script>';
        }
      }

      if(isset($_GET['change_password'])){
        echo '<script>
          	document.getElementById("account_info_id").click();
          	document.getElementById("user_options_input_id").style.display = "block";
          	document.getElementById("option_change_password").style.display="block";
          	document.getElementById("user_options_view_password").style.display="none";
        </script>';
        if($_GET['change_password']==1){
        	echo '<script>
        	document.getElementById("change_password_error").style.display="none";
			document.getElementById("change_password_confirm").style.display = "block";
        </script>';
        }else if($_GET['change_password']==0){
        	echo '<script>
        	document.getElementById("change_password_error").style.display="block";
			document.getElementById("change_password_confirm").style.display = "none";
        </script>';
        }
      }

      if(isset($_GET['change_profile_pic'])){
        echo '<script>
          	document.getElementById("account_info_id").click();
          	document.getElementById("user_options_input_id").style.display = "block";
          	document.getElementById("option_change_picture").style.display="block";
          	document.getElementById("user_options_view_picture").style.display="none";
        </script>';
        if($_GET['change_profile_pic']==1){
        	echo '<script>
        	document.getElementById("change_profile_pic_error").style.display="none";
			document.getElementById("change_profile_pic_confirm").style.display = "block";
        </script>';
        }else if($_GET['change_profile_pic']==0){
        	echo '<script>
        	document.getElementById("change_profile_pic_error").style.display="block";
			document.getElementById("change_profile_pic_confirm").style.display = "none";
        </script>';
        }
      }

     ?>

</body>
</html>