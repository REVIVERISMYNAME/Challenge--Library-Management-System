<?php

//user.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

if(isset($_GET["action"], $_GET['status'], $_GET['code']) && $_GET["action"] == 'delete')
{
	$user_id = $_GET["code"];
	$status = $_GET["status"];

	$data = array(
		':user_status'		=>	$status,
		':user_updated_on'	=>	get_date_time($connect),
		':user_id'			=>	$user_id
	);

	$query = "
	UPDATE lms_user 
    SET user_status = :user_status, 
    user_updated_on = :user_updated_on 
    WHERE user_id = :user_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:user.php?msg='.strtolower($status).'');
}

$query = "
	SELECT * FROM lms_user 
    ORDER BY user_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>

<div style="min-height: 700px;">
	<h1>User Management</h1>
	<ol>
		<li><a href="index.php">Dashboard</a></li>
        <li>User Management</li>
    </ol>
    <?php 
 	
 	if(isset($_GET["msg"]))
 	{
 		if($_GET["msg"] == 'disable')
 		{
 			echo '<div role="alert">Category Status Change to Disable <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
 		}

 		if($_GET["msg"] == 'enable')
 		{
 			echo '
 			<div role="alert">Category Status Change to Enable <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>
 			';
 		}
 	}

    ?>
    <div>
    	<div>
    		<div>
    			<div>
    				<i></i> User Management
    			</div>
    			<div align="right">
    			</div>
    		</div>
    	</div>
    	<div>
    		<table id="datatablesSimple">
    			<thead>
    				<tr>
    					<th>Image</th>
                        <th>User Unique ID</th>
                        <th>User Name</th>
                        <th>Email Address</th>
                        <th>Password</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th>Email Verified</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Action</th>
    				</tr>
    			</thead>
    			<tfoot>
    				<tr>
    					<th>Image</th>
                        <th>User Unique ID</th>
                        <th>User Name</th>
                        <th>Email Address</th>
                        <th>Password</th>
                        <th>Contact No.</th>
                        <th>Address</th>
                        <th>Email Verified</th>
                        <th>Status</th>
                        <th>Created On</th>
                        <th>Updated On</th>
                        <th>Action</th>
    				</tr>
    			</tfoot>
    			<tbody>
    			<?php 
    			if($statement->rowCount() > 0)
    			{
    				foreach($statement->fetchAll() as $row)
    				{
    					$user_status = '';
    					if($row['user_status'] == 'Enable')
    					{
    						$user_status = '<div>Enable</div>';
    					}
    					else
    					{
    						$user_status = '<div>Disable</div>';
    					}
    					echo '
    					<tr>
    						<td><img src="../upload/'.$row["user_profile"].'" width="75" /></td>
    						<td>'.$row["user_unique_id"].'</td>
    						<td>'.$row["user_name"].'</td>
    						<td>'.$row["user_email_address"].'</td>
    						<td>'.$row["user_password"].'</td>
    						<td>'.$row["user_contact_no"].'</td>
    						<td>'.$row["user_address"].'</td>
    						<td>'.$row["user_verification_status"].'</td>
    						<td>'.$user_status.'</td>
    						<td>'.$row["user_created_on"].'</td>
    						<td>'.$row["user_updated_on"].'</td>
    						<td><button type="button" name="delete_button" onclick="delete_data(`'.$row["user_id"].'`, `'.$row["user_status"].'`)">Delete</td>
    					</tr>
    					';
    				}
    			}
    			else
    			{
    				echo '

    				<tr>
    					<td colspan="12">No Data Found</td>
    				</tr>
    				';
    			}
    			?>
    			</tbody>
    		</table>
    	</div>
    </div>
</div>

<script>

	function delete_data(code, status)
	{
		var new_status = 'Enable';

		if(status == 'Enable')
		{
			new_status = 'Disable';
		}

		if(confirm("Are you sure you want to "+new_status+" this User?"))
		{
			window.location.href = "user.php?action=delete&code="+code+"&status="+new_status+"";
		}
	}

</script>

