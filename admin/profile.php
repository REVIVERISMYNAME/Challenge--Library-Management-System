<?php

//profile.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST['edit_admin']))
{

	$formdata = array();

	if(empty($_POST['admin_email']))
	{
		$error .= '<li>Email Address is required</li>';
	}
	else
	{
		if(!filter_var($_POST["admin_email"], FILTER_VALIDATE_EMAIL))
		{
			$error .= '<li>Invalid Email Address</li>';
		}
		else
		{
			$formdata['admin_email'] = $_POST['admin_email'];
		}
	}

	if(empty($_POST['admin_password']))
	{
		$error .= '<li>Password is required</li>';
	}
	else
	{
		$formdata['admin_password'] = $_POST['admin_password'];
	}

	if($error == '')
	{
		$admin_id = $_SESSION['admin_id'];

		$data = array(
			':admin_email'		=>	$formdata['admin_email'],
			':admin_password'	=>	$formdata['admin_password'],
			':admin_id'			=>	$admin_id
		);

		$query = "
		UPDATE lms_admin 
            SET admin_email = :admin_email,
            admin_password = :admin_password 
            WHERE admin_id = :admin_id
		";

		$statement = $connect->prepare($query);

		$statement->execute($data);

		$message = 'User Data Edited';
	}
}

$query = "
	SELECT * FROM lms_admin 
    WHERE admin_id = '".$_SESSION["admin_id"]."'
";

$result = $connect->query($query);


include '../header.php';

?>

<div>
	<h1>Profile</h1>
	<ol>
		<li><a href="index.php">Dashboard</a></li>
		<li>Profile</a></li>
	</ol>
	<div>
		<div>
			<?php 

			if($error != '')
			{
				echo '<div role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button"data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			if($message != '')
			{
				echo '<div role="alert">'.$message.' <button type="button"data-bs-dismiss="alert" aria-label="Close"></button></div>';
			}

			?>
			<div>
				<div>
					<i></i> Edit Profile Details
				</div>
				<div>

				<?php 

				foreach($result as $row)
				{
				?>

					<form method="post">
						<div>
							<label>Email Address</label>
							<input type="text" name="admin_email" id="admin_email" value="<?php echo $row['admin_email']; ?>" />
						</div>
						<div>
							<label>Password</label>
							<input type="password" name="admin_password" id="admin_password" value="<?php echo $row['admin_password']; ?>" />
						</div>
						<div>
							<input type="submit" name="edit_admin" value="Edit" />
						</div>
					</form>

				<?php 
				}

				?>

				</div>
			</div>

		</div>
	</div>
</div>

