<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>phpCollab 3.0a | Wireframe</title>
<link href="schematic/grid.css" rel="stylesheet" type="text/css" />
<link href="schematic/reset.css" rel="stylesheet" type="text/css" />
<link href="schematic/typography.css" rel="stylesheet" type="text/css" />
<link href="schematic/forms.css" rel="stylesheet" type="text/css" />
<link href="custom.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">
	$(function () {
		var tabContainers = $('div.tabs > div');
		tabContainers.hide().filter(':first').show();
		
		$('div.tabs ul.tabNavigation a').click(function () {
			tabContainers.hide();
			tabContainers.filter(this.hash).show();
			$('div.tabs ul.tabNavigation a').removeClass('selected');
			$(this).addClass('selected');
			return false;
		}).filter(':first').click();
	});
</script>

</head>
<body>
<div class="site-bg">
  <div class="container"> 
    <!-- 950 + 30 -->
    <div id="utility" class="showgrid-off"> Hello, Adam Patterson <a href="#" class="login">Login</a> <a href="settings.html" class="settings">Settings</a> <a href="#" class="help">Help</a>
      <select>
        <option selected="selected">Jump to a project!</option>
        <option>One</option>
        <option>Two</option>
      </select>
    </div>
    <div id="header">
      <div id="application-title">Application/Project Title</div>
      <div id="header-search" class="search-box utility-search right">
        <form id="main-search-form" action="index.php?page=list" method="post">
          <div class="search-button">
            <input class="submit" value="" type="submit" />
          </div>
          <div class="center">
            <input class="search placeholder" name="search" title="Search for a Contact" value="" type="text" />
          </div>
          <div class="left"> </div>
        </form>
      </div>
    </div>
    <div id="navigation">
      <ul>
        <li class="<? if ($page == 'dashboard') { echo 'current_page'; } ?>"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="<? if ($page == 'projects-open') { echo 'current_page'; } ?>"><a href="index.php?page=projects">Projects</a></li>
        <li class="<? if ($page == 'time') { echo 'current_page'; } ?>"><a href="index.php?page=time">Time</a></li>
        <li class="<? if ($page == 'calendar') { echo 'current_page'; } ?>"><a href="index.php?page=calendar">Calendar</a></li>
        <li class="<? if ($page == 'users') { echo 'current_page'; } ?>"><a href="index.php?page=users">Users</a></li>
        <li class="<? if ($page == 'todo') { echo 'current_page'; } ?>"><a href="index.php?page=todo"><span>23</span>To-Do</a></li>
        <li class="<? if ($page == 'messages') { echo 'current_page'; } ?>"><a href="index.php?page=messages"><span>5</span>Messages</a></li>
      </ul>
    </div>
    <!-- #navigation -->
    <div id="wrapper">