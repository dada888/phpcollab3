<?
$page = $_GET['page'];

include ('header.php'); 

	switch ( $_GET['page'] )
	{
		case "dashboard":   
				include('content-dashboard.php'); 
				include ('sidebar-dashboard.php'); 
				break;
		case "projects":   
				include('content-projects.php');
				include ('sidebar-projects.php'); 
				break;
		case "projects-open":
				include('content-projects-open.php');
				include ('sidebar-projects-open.php'); 
				break;
		case "time":   
				include('content-time.php');
				include ('sidebar-time.php'); 
				break;	
		case "calendar":   
				include('content-calendar.php'); 
				include ('sidebar-calendar.php'); 
				break;
		case "users":   
				include('content-users.php');
				include ('sidebar-users.php'); 
				break;
		case "todo":   
				include('content-todo.php');
				include ('sidebar-todo.php'); 
				break;
		case "messages":   
				include('content-messages.php');
				include ('sidebar-messages.php'); 
				break;
		default:        
				include('content.php');
				include ('sidebar.php'); 
				break;
	}




include ('footer.php'); 
?>