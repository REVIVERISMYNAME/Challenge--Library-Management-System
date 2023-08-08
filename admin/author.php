<?php

//author.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

$error = '';

if(isset($_POST["add_author"]))
{
	$formdata = array();

	if(empty($_POST["author_name"]))
	{
		$error .= '<li>Author Name is required</li>';
	}
	else
	{
		$formdata['author_name'] = trim($_POST["author_name"]);
	}

	if($error == '')
	{
		$query = "
		SELECT * FROM lms_author 
        WHERE author_name = '".$formdata['author_name']."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Author Name Already Exists</li>';
		}
		else
		{
			$data = array(
				':author_name'			=>	$formdata['author_name'],
				':author_status'		=>	'Enable',
				':author_created_on'	=>	get_date_time($connect)
			);

			$query = "
			INSERT INTO lms_author 
            (author_name, author_status, author_created_on) 
            VALUES (:author_name, :author_status, :author_created_on)
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=add');
		}
	}
}

if(isset($_POST["edit_author"]))
{
	$formdata = array();

	if(empty($_POST["author_name"]))
	{
		$error .= '<li>Author Name is required</li>';
	}
	else
	{
		$formdata['author_name'] = trim($_POST['author_name']);
	}

	if($error == '')
	{
		$author_id = convert_data($_POST['author_id'], 'decrypt');

		$query = "
		SELECT * FROM lms_author 
        WHERE author_name = '".$formdata['author_name']."' 
        AND author_id != '".$author_id."'
		";

		$statement = $connect->prepare($query);

		$statement->execute();

		if($statement->rowCount() > 0)
		{
			$error = '<li>Author Name Already Exists</li>';
		}
		else
		{
			$data = array(
				':author_name'		=>	$formdata['author_name'],
				':author_updated_on'=>	get_date_time($connect),
				':author_id'		=>	$author_id
			);	

			$query = "
			UPDATE lms_author 
            SET author_name = :author_name, 
            author_updated_on = :author_updated_on  
            WHERE author_id = :author_id
			";

			$statement = $connect->prepare($query);

			$statement->execute($data);

			header('location:author.php?msg=edit');
		}
	}
}

if(isset($_GET["action"], $_GET["code"], $_GET["status"]) && $_GET["action"] == 'delete')
{
	$author_id = $_GET["code"];

	$status = $_GET["status"];

	$data = array(
		':author_status'			=>	$status,
		':author_updated_on'		=>	get_date_time($connect),
		':author_id'				=>	$author_id
	);

	$query = "
	 UPDATE lms_author 
    SET author_status = :author_status, 
    author_updated_on = :author_updated_on 
    WHERE author_id = :author_id
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	header('location:author.php?msg='.strtolower($status).'');
}


$query = "
	SELECT * FROM lms_author 
    ORDER BY author_name ASC
";

$statement = $connect->prepare($query);

$statement->execute();

include '../header.php';

?>

<div style="min-height: 700px;">
	<h1>Author Management</h1>
	<?php 

	if(isset($_GET["action"]))
	{
		if($_GET["action"] == "add")
		{
	?>

	<ol>
		<li><a href="index.php">Dashboard</a></li>
        <li><a href="author.php">Author Management</a></li>
        <li>Add Author</li>
    </ol>

    <div>
    	<div>
    		<?php 

    		if($error != '')
    		{
    			echo '<div class="alert alert-danger alert-dismissible fade show" role="alert"><ul class="list-unstyled">'.$error.'</ul> <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    		}

    		?>
    		<div>
    			<div>
    				<i></i> Add New Author
                </div>
                <div>
                	<form>
                		<div>
                			<label>Author Name</label>
                			<input type="text" name="author_name" id="author_name"/>
                		</div>
                		<div>
                			<input type="submit" name="add_author" value="Add" />
                		</div>
                	</form>
                </div>
            </div>
    	</div>
    </div>

	<?php 
		}
		else if($_GET["action"] == 'edit')
		{
			$author_id = convert_data($_GET["code"], 'decrypt');

			if($author_id > 0)
			{
				$query = "
				SELECT * FROM lms_author 
                WHERE author_id = '$author_id'
				";

				$author_result = $connect->query($query);

				foreach($author_result as $author_row)
				{
	?>

	<ol>
		<li><a href="index.php">Dashboard</a></li>
        <li><a href="author.php">Author Management</a></li>
        <li>Edit Author</li>
    </ol>

    <div>
    	<div>
    		<div>
    			<div>
    				<i></i> Edit Author Details
    			</div>
    			<div>
    				<form method="post">
    					<div class="mb-3">
    						<label>Author Name</label>
    						<input type="text" name="author_name" id="author_name" value="<?php echo $author_row['author_name']; ?>" />
    					</div>
    					<div class="mt-4 mb-0">
    						<input type="hidden" name="author_id" value="<?php echo $_GET['code']; ?>" />
    						<input type="submit" name="edit_author" value="Edit" />
    					</div>
    				</form>
    			</div>
    		</div>
    	</div>
    </div>

	<?php
				}
			}
		}
	}
	else
	{

	?>
	<ol>
		<li><a href="index.php">Dashboard</a></li>
		<li>Author Management</li>
	</ol>
	<?php 

	if(isset($_GET["msg"]))
	{
		if($_GET["msg"] == 'add')
		{
			echo '<div  role="alert">New Author Added<button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET['msg'] == 'edit')
		{
			echo '<div  role="alert">Author Data Edited <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
		if($_GET["msg"] == 'disable')
		{
			echo '<div  role="alert">Author Status Change to Disable <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}

		if($_GET["msg"] == 'enable')
		{
			echo '<div  role="alert">Author Status Change to Enable <button type="button" data-bs-dismiss="alert" aria-label="Close"></button></div>';
		}
	}

	?>
	<div>
		<div>
			<div>
				<div>
					<i></i> Author Management
				</div>
				<div align="right">
					<a href="author.php?action=add">Add</a>
				</div>
			</div>
		</div>
		<div>
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Author Name</th>
						<th>Status</th>
						<th>Created On</th>
						<th>Updated On</th>
						<th>Action</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Author Name</th>
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
						$author_status = '';
						if($row['author_status'] == 'Enable')
						{
							$author_status = '<div class="badge bg-success">Enable</div>';
						}
						else
						{
							$author_status = '<div class="badge bg-danger">Disable</div>';
						}
						
						echo '
						<tr>
							<td>'.$row["author_name"].'</td>
							<td>'.$author_status.'</td>
							<td>'.$row["author_created_on"].'</td>
							<td>'.$row["author_updated_on"].'</td>
							<td>
								<a href="author.php?action=edit&code='.convert_data($row["author_id"]).'">Edit</a>
								<button type="button" name="delete_button" onclick="delete_data(`'.$row["author_id"].'`, `'.$row["author_status"].'`)">Delete</button>
							</td>
						</tr>
						';
					}
				}
				else
				{
					echo '
					<tr>
						<td colspan="4" class="text-center">No Data Found</td>
					</tr>
					';
				}
				?>
				</tbody>
			</table>
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

			if(confirm("Are you sure you want to "+new_status+" this Author?"))
			{
				window.location.href = "author.php?action=delete&code="+code+"&status="+new_status+"";
			}
		}

	</script>

	<?php 

	}

	?>
</div>

