<?php

//setting.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}

$message = '';

if(isset($_POST['edit_setting']))
{
	$data = array(
		':library_name'					=>	$_POST['library_name'],
		':library_address'				=>	$_POST['library_address'],
		':library_contact_number'		=>	$_POST['library_contact_number'],
		':library_email_address'		=>	$_POST['library_email_address'],
		':library_total_book_issue_day'	=>	$_POST['library_total_book_issue_day'],
		':library_one_day_fine'			=>	$_POST['library_one_day_fine'],
		':library_currency'				=>	$_POST['library_currency'],
		':library_timezone'				=>	$_POST['library_timezone'],
		':library_issue_total_book_per_user'	=>	$_POST['library_issue_total_book_per_user']
	);

	$query = "
	UPDATE lms_setting 
        SET library_name = :library_name,
        library_address = :library_address, 
        library_contact_number = :library_contact_number, 
        library_email_address = :library_email_address, 
        library_total_book_issue_day = :library_total_book_issue_day, 
        library_one_day_fine = :library_one_day_fine, 
        library_currency = :library_currency, 
        library_timezone = :library_timezone, 
        library_issue_total_book_per_user = :library_issue_total_book_per_user
	";

	$statement = $connect->prepare($query);

	$statement->execute($data);

	$message = '
	<div class="alert alert-success alert-dismissible fade show" role="alert">Data Edited <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
	';
}

$query = "
SELECT * FROM lms_setting 
LIMIT 1
";

$result = $connect->query($query);

include '../header.php';

?>

<div>
	<h1>Setting</h1>

	<ol>
		<li><a href="index.php">Dashboard</a></li>
		<li>Setting</a></li>
	</ol>
	<?php 

	if($message != '')	
	{
		echo $message;
	}

	?>
	<div>
		<div>
			<i></i> Library Setting
		</div>
		<div>

			<form method="post">
				<?php 
				foreach($result as $row)
				{
				?>
				<div>
					<div>
						<div>
							<label>Library Name</label>
							<input type="text" name="library_name" id="library_name" value="<?php echo $row['library_name']; ?>" />
						</div>
					</div>
				</div>
				<div>
					<div>
						<div>
							<label>Address</label>
							<textarea name="library_address" id="library_address"><?php echo $row["library_address"]; ?></textarea>
						</div>
					</div>
				</div>
				<div>
					<div>
						<div>
							<label>Contact Number</label>
							<input type="text" name="library_contact_number" id="library_contact_number" value="<?php echo $row['library_contact_number']; ?>" />
						</div>
					</div>
					<div>
						<div>
							<label>Email Address</label>
							<input type="text" name="library_email_address" id="library_email_address" value="<?php echo $row['library_email_address']; ?>" />
						</div>
					</div>
				</div>
				<div>
					<div>
						<div>
							<label>Book Return Day Limit</label>
							<input type="number" name="library_total_book_issue_day" id="library_total_book_issue_day" value="<?php echo $row['library_total_book_issue_day']; ?>" />
						</div>
					</div>
					<div>
						<div>
							<label>Book Late Return One Day Fine</label>
							<input type="number" name="library_one_day_fine" id="library_one_day_fine" value="<?php echo $row['library_one_day_fine']; ?>" />
						</div>
					</div>
				</div>
				<div>
					<div>
						<div>
							<label>Currency</label>
							<select name="library_currency" id="library_currency">
								<?php echo Currency_list(); ?>
							</select>
						</div>
					</div>
					<div>
						<div>
							<label>Timezone</label>
							<select name="library_timezone" id="library_timezone">
								<?php echo Timezone_list(); ?>
							</select>
						</div>
					</div>
				</div>
				<div>
					<div>
						<label>Per User Book Issue Limit</label>
						<input type="number" name="library_issue_total_book_per_user" id="library_issue_total_book_per_user" value="<?php echo $row['library_issue_total_book_per_user']; ?>" />
					</div>
				</div>
				<div>
					<input type="submit" name="edit_setting" value="Save" />
				</div>
				<script type="text/javascript">

				document.getElementById('library_currency').value = "<?php echo $row['library_currency']; ?>";

				document.getElementById('library_timezone').value="<?php echo $row['library_timezone']; ?>"; 

				</script>
				<?php 
				}
				?>
			</form>

		</div>
	</div>
</div>
