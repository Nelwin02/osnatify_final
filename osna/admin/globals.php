<?php
// Include the database connection file
include_once 'db.php';

// Define default global variables
$global_what_we_do = '';
$global_osna_service = 'OSNA Service';
$global_class_lead = 'We offer a range of medical services to meet your health needs. Our dedicated team is here to provide quality care.';
$image = ''; // Initialize image variable

try {
    // Prepare and execute the query using PostgreSQL
    $query = "SELECT what_we_do, osna_service, class_lead_description, image_path FROM admin_settings WHERE id = $1";
    $id = 1; // Assuming ID is static, set it here
    $result = pg_query_params($con, $query, [$id]);

    // Fetch result and assign to global variables
    if ($result && pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        $global_what_we_do = $row['what_we_do'] ?: $global_what_we_do;
        $global_osna_service = $row['osna_service'] ?: $global_osna_service;
        $global_class_lead = $row['class_lead_description'] ?: $global_class_lead;
        $image = $row['image_path'] ?: '';
    } else {
        // Log if no data is retrieved for the specified ID
        error_log("No data found for admin_settings with ID: $id");
    }

    // Free the result resource
    pg_free_result($result);
} catch (Exception $e) {
    // Catch and log any exceptions
    error_log("Error fetching admin settings: " . $e->getMessage());
}

?>
