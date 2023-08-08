<?php

//search_book.php

include 'database_connection.php';

include 'function.php';

if(!is_user_login())
{
	header('location:user_login.php');
}

$query = "
	SELECT * FROM lms_book 
    WHERE book_status = 'Enable' 
    ORDER BY book_id DESC
";

$statement = $connect->prepare($query);

$statement->execute();


include 'header.php';

?>

<div style="min-height: 700px;">

	<h1>Search Book</h1>

	<div>
		<div>
			<div>
				<div>
					<i></i> Book List
				</div>
				<div align="right">

				</div>
			</div>
		</div>
		<div>
			<table id="datatablesSimple">
				<thead>
					<tr>
						<th>Book Name</th>
						<th>ISBN No.</th>
						<th>Category</th>
						<th>Author</th>
						<th>Location Rack</th>
						<th>No. of Available Copy</th>
						<th>Status</th>
						<th>Added On</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>Book Name</th>
						<th>ISBN No.</th>
						<th>Category</th>
						<th>Author</th>
						<th>Location Rack</th>
						<th>No. of Available Copy</th>
						<th>Status</th>
						<th>Added On</th>
					</tr>
				</tfoot>
				<tbody>
				<?php 

				if($statement->rowCount() > 0)
				{
					foreach($statement->fetchAll() as $row)
					{
						$book_status = '';
						if($row['book_no_of_copy'] > 0)
						{
							$book_status = '<div>Available</div>';
						}
						else
						{
							$book_status = '<div>Not Available</div>';
						}
						echo '
							<tr>
								<td>'.$row["book_name"].'</td>
								<td>'.$row["book_isbn_number"].'</td>
								<td>'.$row["book_category"].'</td>
								<td>'.$row["book_author"].'</td>
								<td>'.$row["book_location_rack"].'</td>
								<td>'.$row["book_no_of_copy"].'</td>
								<td>'.$book_status.'</td>
								<td>'.$row["book_added_on"].'</td>
							</tr>
						';
					}
				}
				else
				{
					echo '
					<tr>
						<td colspan="8">No Data Found</td>
					</tr>
					';
				}

				?>
				</tbody>
			</table>
		</div>
	</div>
</div>

