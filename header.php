<?php

//header.php

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="generator" content="">
        <title>Library Management System</title>
        <link rel="canonical" href="">
        <link rel="stylesheet" href="./Library_stylesheet.css">
    </head>

    <?php 

    if(is_admin_login())
    {

    ?>
    <body>

        <nav>
            <!-- Navbar Brand-->
            <a href="index.php">Library System</a>
            <!-- Sidebar Toggle-->
            <button  id="sidebarToggle" href="#!"><i></i></button>
            <form>
                
            </form>
            <!-- Navbar-->
            <ul>
                <li>
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i></i></a>
                    <ul aria-labelledby="navbarDropdown">
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="setting.php">Setting</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav id="sidenavAccordion">
                    <div>
                        <div class="nav">
                            <a href="category.php">Category</a>
                            <a href="author.php">Author</a>
                            <a href="location_rack.php">Location Rack</a>
                            <a href="book.php">Book</a>
                            <a href="user.php">User</a>
                            <a href="issue_book.php">Issue Book</a>
                            <a href="logout.php">Logout</a>

                        </div>
                    </div>
                    
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>


    <?php 
    }
    else
    {

    ?>

    <body>

    	<main>

    		<div >

    			<header>
                    <div>
        				<div>
                            <a href="index.php">
                                <span> >>Home<< </span>
                            </a>
                        </div>
                        <div>
                            <?php 

                            if(is_user_login())
                            {
                            ?>
                            <ul>
                                <li><?php echo $_SESSION['user_id']; ?></li>
                                <li><a href="issue_book_details.php">Issue Book</a></li>
                                <li><a href="search_book.php">Search Book</a></li>
                                <li><a href="profile.php">Profile</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                            <?php 
                            }

                            ?>
                        </div>
                    </div>

    			</header>
    <?php 
    }
    ?>
    			