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
		case "projects-open-tasks":
				include('content-projects-open-tasks.php');
				include ('sidebar-projects-open-tasks.php'); 
				break;
		case "projects-open-milestones":
				include('content-projects-open-milestones.php');
				include ('sidebar-projects-open-milestones.php'); 
				break;
		case "projects-open-todo":
				include('content-projects-open-todo.php');
				include ('sidebar-projects-open-todo.php'); 
				break;
		case "projects-open-discussion":
				include('content-projects-open-discussions.php');
				include ('sidebar-projects-open-discussions.php'); 
				break;
        case "projects-open-notes":
				include('content-projects-open-notes.php');
				include ('sidebar-projects-open-notes.php'); 
				break;
        case "projects-open-files":
				include('content-projects-open-files.php');
				include ('sidebar-projects-open-files.php'); 
				break;
        case "projects-open-repository":
				include('content-projects-open-repository.php');
				include ('sidebar-projects-open-repository.php'); 
				break;
        case "projects-open-time":
				include('content-projects-open-time.php');
				include ('sidebar-projects-open-time.php'); 
				break;
        case "projects-open-staff":
				include('content-projects-open-staff.php');
				include ('sidebar-projects-open-staff.php'); 
				break;
		case "projects-edit":
				include('content-projects-edit.php');
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