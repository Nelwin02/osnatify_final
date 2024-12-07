<?php
        include 'db.php'; // Include the database connection

        // Fetch admin details by ID (replace with the actual ID or logic for dynamic assignment)
        $adminId = 1; // Example admin ID

        // Query to fetch the admin details
        $query = "SELECT name, date_birth, admin_email, mobile, admin_address 
                  FROM admin_log 
                  WHERE id = $1";

        // Prepare and execute the query
        if ($stmt = pg_prepare($con, "get_admin_details", $query)) {
            $result = pg_execute($con, "get_admin_details", [$adminId]);
            if ($result && pg_num_rows($result) > 0) {
                $admin = pg_fetch_assoc($result);
            } else {
                echo "No record found.";
                exit;
            }
        } else {
            echo "Query preparation failed.";
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
                        <form action="update_admin.php" method="POST">
                            <div class="row form-row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($admin['name'] ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <div class="cal-icon">
                                            <input type="date" class="form-control" name="date_birth" value="<?php echo htmlspecialchars($admin['date_birth'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <input type="email" class="form-control" name="admin_email" value="<?php echo htmlspecialchars($admin['admin_email'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>Mobile</label>
                                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlspecialchars($admin['mobile'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h5 class="form-title"><span>Address</span></h5>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="admin_address" value="<?php echo htmlspecialchars($admin['admin_address'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="new_password" placeholder="Enter new password">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="admin_id" value="<?php echo htmlspecialchars($adminId); ?>">
                            <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // Free result memory
        pg_free_result($result);

        // Close the database connection
        pg_close($con);
        ?>
        <!-- /Edit Details Modal -->
    </div>
</div>
