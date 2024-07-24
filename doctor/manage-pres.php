<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Manage Prescription</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <?php
  session_start();
  include 'db.php'; 
  ?>


<?php
		if (!isset($_SESSION['username'])) {
			
			header("Location: login.php");
			exit();
		}
		
		$username = $_SESSION['username'];
		
					
			// Fetch doctor information
$username = $_SESSION['username'];
$sql = "SELECT doctor_name, doctor_image FROM doctor_log WHERE username = '$username'";
$result = mysqli_query($con, $sql);

if ($result) {
    $doctor = mysqli_fetch_assoc($result);
    if ($doctor) {
        $name = $doctor['doctor_name'];
        $image = $doctor['doctor_image'];
    } else {
        $name = "Unknown";
        $image = "default.png"; // Fallback image
    }
} else {
    $name = "Unknown";
    $image = "default.png"; // Fallback image
}
?>
</head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <span><img src="img/opd.png" alt="" width="100px"></span>
        </div>
        
        <div class="side-content">
            <div class="profile">
            <div ><img src="../doctor/Images/<?php echo htmlspecialchars($image); ?>" alt="Doctor Image" class="profile-img bg-img"></div>
                <h4>Welcome,</h4>
                <small><?php echo htmlspecialchars($name); ?></small>
            </div>
            
            <div class="side-menu">
                <ul>
                    <li>
                       <a href="doctor_dash.php" class="active">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li>
                       <a href="manage-pres.php">
                            <span class="las la-prescription"></span>
                            <small>Prescription</small>
                        </a>
                    </li>
                    <li>
                       <a href="manage-meds.php">
                            <span class="las la-pills"></span>
                            <small>Medicines</small>
                        </a>
                    </li>
                   
                   
                    
                    <li>
                       <a href="settings.php">
                            <span class="las la-cog"></span>
                            <small>Settings</small>
                        </a>
                    </li>
                    

                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <label for="">
                        <span class=""></span>
                    </label>
                    
                    <div class="">
                       
                        <span class="notify"></span>
                    </div>
                    
                    <div class="notify-icon">
                        <span class="las la-bell"></span>
                        <span class="notify">3</span>
                    </div>
                    
                    
                    
                    
                    <div class="user">
                        <a href="profile.php">
                        <div class="bg-img" style="background-image: url('../doctor/Images/<?php echo htmlspecialchars($image); ?>');" > 
 
</div>
                    </a>
                    <a href="../doctor/login.php">
                        <span class="las la-power-off"></span>
                        <span>Logout</span>
                    </a>
                    </div>
                </div>
            </div>
        </header>
        
        
        <main>
            
            <div class="page-header">
                <h1>Manage Prescription</h1>
                <small>Home / Prescription</small>
            </div>
            
            <div class="page-content">