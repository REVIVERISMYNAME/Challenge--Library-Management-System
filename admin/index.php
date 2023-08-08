<?php

//index.php

include '../database_connection.php';

include '../function.php';

if(!is_admin_login())
{
	header('location:../admin_login.php');
}


include '../header.php';

?>

<body>
<div >
	<h1>Dashboard</h1>
	<div>
		
		<div >
			<h1><?php echo Count_total_issue_book_number($connect); ?></h1>
			<h5>Total Book Issue</h5>
		</div>
			
		<div >
			<h1><?php echo Count_total_returned_book_number($connect); ?></h1>
			<h5>Total Book Returned</h5>
		</div>
		
		<div >
			<h1><?php echo Count_total_not_returned_book_number($connect); ?></h1>
			<h5>Total Book Not Return</h5>
		</div>		
		
		<div >
			<h1><?php echo get_currency_symbol($connect) . Count_total_fines_received($connect); ?></h1>
			<h5>Total Fines Received</h5>
		</div>

		<div >
			<h1><?php echo Count_total_book_number($connect); ?></h1>
			<h5>Total Book</h5>
		</div>

		<div >
			<h1><?php echo Count_total_author_number($connect); ?></h1>
			<h5>Total Author</h5>
		</div>

		<div >
			<h1><?php echo Count_total_category_number($connect); ?></h1>
			<h5>Total Category</h5>
		</div>

		<div >
			
			<h1><?php echo Count_total_location_rack_number($connect); ?></h1>
			<h5>Total Location Rack</h5>
				
		</div>
	</div>
</div>

</body>
</html>