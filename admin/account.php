<?php 
  session_start();

  if(empty($_SESSION["token"])){
    header('Location: index.php');
  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-control" content="no-cache">
    <title>Admin</title>
    <script type="text/javascript" src="js/administration_page.js"></script>
    <link rel="stylesheet" type="text/css" href="css/administration_page.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body onload="setAdminToken('<?php echo $_SESSION['token']?>')">
  	<div class="administration_page">
      <div class="top_options">
        <div class="logo_display">
          <h3>SIVIR Administration Board</h3>
        </div>
        <div class="functions_display">
          <div class="administration_logout">
            <i class="fa fa-sign-out" onclick = "logOut();"> Sign out</i>
          </div>
        </div>
      </div>

      <div class="right_options">
        <div class="api_resources">
          <div class="api_resources_banner">
            <h3>API Resources</h3>
          </div>
          <div class="api_resources_links">
            <ul>
              <li><a href="https://developers.google.com/youtube/v3">Youtube DATA API</a></li>
              <li><a href="https://developer.vimeo.com/">Vimeo API</a></li>
              <li><a href="https://github.com/postaddictme/instagram-php-scraper">Instagram Scrapper</a></li>
            </ul>
          </div>
        </div>
        <div class="server_informations">
          <div class="server_informations_banner">
            <h3>SIVIR informations</h3>
          </div>
          <div class="server_informations_links">
            <ul>
              <li><a href="../docs/report/index.html">Sivir Doc</a></li>
              <li><a href="../docs/guide/index.html">User Guide</a></li>
              <li><a href="https://www.apachefriends.org/ro/index.html">XAMP</a></li>
              <li><a href="https://www.phpmyadmin.net/">phpMyAdmin</a></li>
              <li><a href="https://httpd.apache.org/">Apache</a></li>
              <li><a href="https://github.com/atase/">Developer github</a></li>
            </ul>
          </div>
        </div>
      </div>
      
      <div class="center_options">
        <div class="files_section">
          <h3>FILES</h3>
          <div class="files_structure_display">
            <i class="fa fa-folder" onclick="view_project_structure()"> Project structure</i>
          </div>
          <div class="api_structure_display">
            <i class="fa fa-folder" onclick="view_api_structure()"> API structure</i>
          </div>
          <div class="launch_project_display">
            <i class="fa fa-external-link-square" onclick="launch_project()"> Launch project</i>
          </div>
          <div class="backup_display">
            <i class="fa fa-hdd-o" onclick="directory_backup()"> Files & Directory Backup</i>
          </div>
          <div class="restoration_display">
            <i class="fa fa-upload" onclick="directory_restoration()"> Files & Directory Restoration</i>
          </div>
        </div>
        <div class="database_section">
            <h3>DATABASE</h3>
             <div class="tables_structure_display">
              <i class="fa fa-table" onclick="view_db_tables()"> Database tables</i>
            </div>
            <div class="export_all_tables_display">
              <i class="fa fa-file-excel-o" onclick="view_db_export()"> Export tables</i>
            </div>
            <div class="launch_phpmyadmin_display">
              <i class="fa fa-database" onclick="launch_phpmyadmin()"> Launch phpMyAdmin</i>
            </div>
            <div class="database_backup_display">
              <i class="fa fa-hdd-o" onclick="database_backup()"> Database Backup</i>
            </div>
            <div class="database_restoration_display">
              <i class="fa fa-upload" onclick="database_restoration()"> Database Restoration</i>
            </div>
            <div class="add_admin_display">
              <i class="fa fa-user" onclick="addAdmin()"> Add admin</i>
            </div>
        </div>    
      </div>
  	
      <div class="option_view" id="view">
        <div class="viewer" id="structure_viewer">
          <i class="fa fa-window-close" onclick = "hideView('structure_viewer')"></i>
          <div class="strviewer_container" id="strviewer"></div>
          <div class="str_selector" id="selector">
            <i class="fa fa-folder" onclick = "displaySelector('strviewer')"></i>
          </div>
        </div>
        <div class="viewer" id="action_viewer">
          <i class="fa fa-window-close" onclick = "hideView('action_viewer')"></i>
          <div class="actviewer_container" id="actviewer"></div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      window.onscroll = function(){
        var scroll = window.pageYOffset;
        document.getElementById("view").style.top = "0%";
        document.getElementById("view").style.bottom =  "0%";
      }
    </script>
  </body>


 </html>