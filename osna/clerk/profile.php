<?php
session_start();
include '../db.php'; // Database connection file

// Check if clerk is logged in by verifying the session variable
if (!isset($_SESSION['clerk_username'])) { 
    header("Location: /osna/doctor2/login.php");
    exit();
}

// Retrieve the clerk's username from session
$clerk_username = $_SESSION['clerk_username']; 

// Fetch clerk information using prepared statements
$query = "SELECT clerk_name, clerk_image FROM clerk_log WHERE username = $1"; 
$stmt = pg_prepare($con, "fetch_clerk_info", $query);
$stmt = pg_execute($con, "fetch_clerk_info", array($clerk_username));

if ($stmt) {
    $clerk = pg_fetch_assoc($stmt);
    if ($clerk) {
        $name = $clerk['clerk_name'];
        $image = $clerk['clerk_image'];
    } else {
        $name = "Unknown";
        $image = "default.png"; // Fallback image
    }
} else {
    $name = "Unknown";
    $image = "default.png"; // Fallback image
}

?>

<!DOCTYPE html>
<html lang="en">
    
<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:20 GMT -->
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Clerk Profile</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/opd.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="assets/css/feathericon.min.css">
		
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

	

    </head>
    <body>
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="" class="logo">
						<img src="assets/img/opd.png" alt="Logo">
					</a>
					<a href="" class="logo logo-small">
						<img src="assets/img/opd.png" alt="Logo" width="30" height="30">
					</a>
                </div>
				<!-- /Logo -->
				
				<a href="javascript:void(0);" id="toggle_btn">
					<i class="fe fe-text-align-left"></i>
				</a>
				
				<div class="top-nav-search">
					
				</div>
				
				<!-- Mobile Menu Toggle -->
				<a class="mobile_btn" id="mobile_btn">
					<i class="fa fa-bars"></i>
				</a>
				<!-- /Mobile Menu Toggle -->
				
				<!-- Header Right Menu -->
				<ul class="nav user-menu">

					
					
					<!-- User Menu -->
					<li class="nav-item dropdown has-arrow">
						<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
							<span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="clerk"></span>
						</a>
						<div class="dropdown-menu">
							<div class="user-header">
								<div class="avatar avatar-sm">
								<span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="clerk"></span>
								</div>
								<div class="user-text">
								<h6><?php echo $clerk_username; ?></h6>
									<p class="text-muted mb-0"><?php echo $name; ?></p>
								</div>
							</div>
							<a class="dropdown-item" href="profile.php">My Profile</a>
							<a class="dropdown-item" href="../clerk/login.php">Logout</a>
						</div>
					</li>
					<!-- /User Menu -->
					
				</ul>
				<!-- /Header Right Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<li class="menu-title"> 
								<span>Main</span>
							</li>
							<li class="active"> 
								<a href="clerk_dash.php"><i class="fe fe-home"></i> <span>Dashboard</span></a>
							</li>
							<li class="submenu">
								<a href="#"><i class="fa fa-wheelchair"></i> <span>Manage Patient</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">

									<li><a href="add_patient.php">New Patient</a></li>
										
									<li><a href="view_patient.php">Patient List</a></li>
									
									
								</ul>
								
								<li> 
								<a href="consultation.php"><i class="fa fa-stethoscope"></i> <span>Consultations</span></a>
							</li>

							

								<li> 
							
							

	
						
							
							<li> 
								<a href="profile.php"><i class="fe fe-user-plus"></i> <span>Profile</span></a>
							</li><br><br><br><br><br><br><br>
							<li> 
							<a href="login.php"><i class="fa fa-sign-out"></i> <span>Logout</span></a>
							</li>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
			
			
			<!-- Page Wrapper -->
            <div class="page-wrapper">
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col">
								<h3 class="page-title">Profile</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="admin.php">Dashboard</a></li>
									<li class="breadcrumb-item active">Profile</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="mb-4">
                            <h2 class="text-center">
                                <hr style="border: 2px solid black; width: 100%;">
                            </h2>
                        </div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="profile-header">
								<div class="row align-items-center">
									<div class="col-auto profile-image">
										<a href="#">
										<span class="user-img"><img class="rounded-circle" src="../clerk/Images/<?php echo htmlspecialchars($image); ?>" width="31" alt="clerk"span>
										</a>
									</div>
									<div class="col ml-md-n2 profile-user-info">
										<h4 class="user-name mb-0"><?php echo $clerk_username; ?></h4><h6></h6>
										<h1><?php echo $name; ?></h1>
										
									</div>
									<div class="col-auto profile-btn">
										
									
									</div>
								</div>
							</div>
							
							<div class="tab-content profile-tab-cont">
								
								<!-- Personal Details Tab -->






								<div class="row">
										<div class="col-lg-12">
											<div class="card">
												<div class="card-body">
													<h5 class="card-title d-flex justify-content-between">
														<span>Personal Detail</span> 
														<a class="edit-link" data-toggle="modal" href="#edit_personal_details"><i class="fa fa-edit mr-1"></i>Edit</a>
													</h5>
													<div class="row">
														<p class="col-sm-2 text-muted text-sm-right mb-0 mb-sm-3">Name</p>
														<p class="col-sm-10"><?php echo"$name"?></p>
													</div>
													
												</div>
											</div>
											
											<!-- Edit Details Modal -->
											<?php
include 'db.php'; // Database connection

// Fetch clerk details by ID (replace with the actual ID or a variable if needed)
$clerkId = 2; // Example clerk ID, you may want to make this dynamic

// PostgreSQL query using parameterized query
$query = "SELECT * FROM clerk_log WHERE id = $1";
$result = pg_query_params($con, $query, array($clerkId));

if ($result) {
    if (pg_num_rows($result) > 0) {
        $clerk = pg_fetch_assoc($result);
    } else {
        echo "No record found";
        exit;
    }
} else {
    echo "Error in query execution";
    exit;
}
?>


<div class="modal fade" id="edit_personal_details" aria-hidden="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Personal Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="update_clerk.php" method="POST" enctype="multipart/form-data"> <!-- Update action file -->
                    <div class="row form-row">
                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($clerk['username']); ?>" required>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="clerk_name" value="<?php echo htmlspecialchars($clerk['clerk_name']); ?>" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label>Profile Image</label>
                                <input type="file" class="form-control" name="clerk_image">
                                <!-- Optionally show current image if available -->
                                <?php if ($clerk['clerk_image']): ?>
                                    <img src="Images/<?php echo htmlspecialchars($clerk['clerk_image']); ?>" alt="Current Image" style="max-width: 100px; margin-top: 10px;">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="clerk_id" value="<?php echo $clerk['id']; ?>">
                    <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>




        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="assets/js/jquery-3.2.1.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slimscroll JS -->
        <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
		
		<!-- Custom JS -->
		<script  src="assets/js/script.js"></script>
		
    </body>

<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/profile.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:46 GMT -->
</html>
