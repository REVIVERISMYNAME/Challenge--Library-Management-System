<?php

//admin_login.php


include 'database_connection.php';

include 'function.php';


$message = '';

if(isset($_POST["login_button"]))
{

	$formdata = array();

	if(empty($_POST["admin_email"]))
	{
		$message .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["admin_email"], FILTER_VALIDATE_EMAIL))
		{
			$message .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['admin_email'] = $_POST['admin_email'];
		}
	}

	if(empty($_POST['admin_password']))
	{
		$message .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['admin_password'] = $_POST['admin_password'];
	}

	if($message == '')
	{
		$data = array(
			':admin_email'		=>	$formdata['admin_email']
		);

		$query = "
		SELECT * FROM lms_admin 
        WHERE admin_email = :admin_email
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			foreach($statement->fetchAll() as $row)
			{
				if($row['admin_password'] == $formdata['admin_password'])
				{
					$_SESSION['admin_id'] = $row['admin_id'];

					header('location:admin/index.php');
				}
				else
				{
					$message = '<li>Wrong Password</li>';
				}
			}
		}	
		else
		{
			$message = '<li>Wrong Email Address</li>';
		}
	}

}

include 'header.php';

?>

<div style="min-height:700px;">

	<div>

		<?php 
		if($message != '')
		{
			echo '<div><ul>'.$message.'</ul></div>';
		}
		?>

		<div>

			<div>Admin Login</div>

			<div>

				<form method="POST">

					<div>
						<label>Email address</label>

						<input type="text" name="admin_email" id="admin_email"/>

					</div>

					<div>
						<label>Password</label>

						<input type="password" name="admin_password" id="admin_password"/>

					</div>

					<div>

						<input type="submit" name="login_button" value="Login" />

					</div>

				</form>

			</div>

		</div>

	</div>

</div>

