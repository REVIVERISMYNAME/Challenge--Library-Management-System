<?php

include 'database_connection.php';
include 'function.php';

if(is_user_login())
{
	header('location:issue_book_details.php');
}

include 'header.php';


?>
<body>
<div>
	<h1>History of our Superheroes Library</h1>
	<p>Please Login to Continue, If you are new here please Sign Up.</p>

</div>

<div>
	
	<div>
		<h2>User Login</h2>

		<p>Click <a href="user_login.php">Here</a> to Login.</p>
		<p>Click <a href="user_registration.php">Here</a> to Sign Up.</p>

	</div>

	<div>
		This section is for Admin Users only: <a href="admin_login.php">Admin Login</a>

	</div>


</div>

</body>
</html>

