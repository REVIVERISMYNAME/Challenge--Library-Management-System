<?php

//user_login.php

include 'database_connection.php';

include 'function.php';

if(is_user_login())
{
	header('location:issue_book_details.php');
}

$message = '';

if(isset($_POST["login_button"]))
{
	$formdata = array();

	if(empty($_POST["user_email_address"]))
	{
		$message .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["user_email_address"], FILTER_VALIDATE_EMAIL))
		{
			$message .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['user_email_address'] = trim($_POST['user_email_address']);
		}
	}

	if(empty($_POST['user_password']))
	{
		$message .= '<li>Password is required</li>';
	}	
	else
	{
		$formdata['user_password'] = trim($_POST['user_password']);
	}

	if($message == '')
	{
		$data = array(
			':user_email_address'		=>	$formdata['user_email_address']
		);

		$query = "
		SELECT * FROM lms_user 
        WHERE user_email_address = :user_email_address
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		if($statement->rowCount() > 0)
		{
			foreach($statement->fetchAll() as $row)
			{
				if($row['user_status'] == 'Enable')
				{
					if($row['user_password'] == $formdata['user_password'])
					{
						$_SESSION['user_id'] = $row['user_unique_id'];
						header('location:issue_book_details.php');
					}
					else
					{
						$message = '<li>Wrong Password</li>';
					}
				}
				else
				{
					$message = '<li>Your Account has been disabled</li>';	
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

<div style="height:700px;">
	<div>
		<?php 

		if($message != '')
		{
			echo '<div><ul>'.$message.'</ul></div>';
		}

		?>
		<div>
			<div>User Login</div>
			<div>
				<form method="POST">
					<div>
						<label>Email address</label>
						<input type="text" name="user_email_address" id="user_email_address"/>
					</div>
					<div>
						<label>Password</label>
						<input type="password" name="user_password" id="user_password"/>
					</div>
					<div>
						<input type="submit" name="login_button" value="Login" />
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
