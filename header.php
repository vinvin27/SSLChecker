<?php
  if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }

  include_once("config.php");
  include_once("lib/functions.php");

  $username = $_SESSION['username'];

  $function = new general();
  $pid = $function->getPID($username, $db);

  if($username == "") {
      $username = "Guest";
  }

  if ($username != 'Guest') {
  $loginout = "<a class='dropdown-item' href='logout.php'><i class='ti-power-off'></i> ".lang('MENU_LOGOUT')."</a>";
	$addserverbutton = "
            <li class='menu-category'>".lang('MENU_ADMIN')."</li>

          <li class='menu-item'>
            <a class='menu-link' href='addserver.php'>
              <span class='icon fa fa-plus'></span>
              <span class='title'>".lang('MENU_ADMIN_ADD')."</span>
            </a>
          </li>

          <li class='menu-item'>
            <a class='menu-link' href='settings.php'>
              <span class='icon fa fa-gear'></span>
              <span class='title'>".lang('MENU_ADMIN_PUSH')."</span>
            </a>
          </li>

          <li class='menu-item'>
            <a class='menu-link' href='cron.php'>
              <span class='icon fa fa-refresh'></span>
              <span class='title'>".lang('MENU_ADMIN_UPDATE')."</span>
            </a>
          </li>
  ";
  } else {
  $loginout = "<a class='dropdown-item' href='login.php'><i class='ti-power-off'></i> ".lang('MENU_LOGIN')."</a>";
	$addserverbutton = "";
  }

	if(isset($_SESSION['admin']) && $_SESSION['admin'] = 1) {
		$title = "Administrator";
		$regdate = "Member since: A while ago";
    $myaccount = "<a class='dropdown-item' href='account.php?pid=$pid'><i class='ti-settings'></i> ".lang('MENU_LOGIN_MYACCOUNT')."</a>";
	} else {
		$title = "Guest";
		$regdate = "Please log in to show statics";
	}

  $extra =  '';//file_get_contents('https://www.peppercloud.nl/res/sslchecker.txt', FILE_USE_INCLUDE_PATH);

echo "
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <meta name='description' content='".lang('PAGE_DESC')." '>
    <meta name='keywords' content='blank, starter'>

    <title>Dashboard &mdash; ".lang('PAGE_BRAND')."</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i' rel='stylesheet'>

    <!-- PepperScript -->
    <script src='assets/plugin/pepperSSL/pepper.js'></script>

    <!-- Styles -->
    <link href='assets/css/core.min.css' rel='stylesheet'>
    <link href='assets/css/app.min.css' rel='stylesheet'>
    <link href='assets/css/style.min.css' rel='stylesheet'>
    <link href='assets/css/pepper.css' rel='stylesheet'>

    <!-- Favicons -->
    <link rel='apple-touch-icon' href='assets/img/apple-touch-icon.png'>
    <link rel='icon' href='assets/img/favicon.png'>
  </head>

  <body onload='updateStatus1();' onload='ajax();'>

    <!-- Preloader -->
    <div class='preloader'>
      <div class='spinner-dots'>
        <span class='dot1'></span>
        <span class='dot2'></span>
        <span class='dot3'></span>
      </div>
    </div>


    <!-- Sidebar -->
    <aside class='sidebar sidebar-icons-right sidebar-icons-boxed sidebar-expand-lg purple'>
      <header class='sidebar-header bg-purple'>
        <a class='logo-icon' href='../index.php'><img src='assets/img/logo-icon-light.png' height='26px' width='26px' alt='logo icon'></a>
        <span class='logo'>
          <a href='../index.php'><img src='assets/img/logo-light.png' height='36px' width='75px' alt='logo'></a>
        </span>
        <span class='sidebar-toggle-fold'></span>
      </header>

      <nav class='sidebar-navigation'>
        <ul class='menu'>


          <li class='menu-item'>
            <a class='menu-link' href='index.php'>
              <span class='icon fa fa-home'></span>
              <span class='title'>".lang('MENU_DASH')."</span>
            </a>
          </li>

          <li class='menu-item'>
            <a class='menu-link' href='https://github.com/pernodpepper/SSLChecker/releases'>
              <span class='icon fa fa-info'></span>
              <span class='title'>".lang('MENU_INFO')."</span>
            </a>
          </li>

          $addserverbutton
          $extra

        </ul>
      </nav>

    </aside>
    <!-- END Sidebar -->
    <!-- Topbar -->
<header class='topbar topbar-inverse bg-purple'>
          <div class='topbar-left'>
            <button class='topbar-btn sidebar-toggler'>☰</button>
            <h3 class='topbar-title'>".lang('PAGE_BRAND')."</h3>
          </div>

          <div class='topbar-right'>
            <ul class='topbar-btns'>
              <li class='dropdown'>
                <span class='topbar-btn' data-toggle='dropdown'><img class='avatar avatar-sm' src='../assets/img/user.jpg' alt='...'></span>
                <div class='dropdown-menu dropdown-menu-right'>
                  $myaccount
                  <div class='dropdown-divider'></div>
                  $loginout
                </div>
              </li>
            </ul>

          </div>
        </header>
    <!-- END Topbar -->
    ";
?>
