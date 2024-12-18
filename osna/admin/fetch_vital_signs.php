<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = pg_escape_string($con, $_POST['username']);

    // Fetch vital signs for the given username
    $sql = "SELECT weight, height, bloodpressure, heartrate FROM vitalsigns WHERE username = '$username' ORDER BY id DESC";
    $result = pg_query($con, $sql);

    if (pg_num_rows($result) > 0) {
        echo "<table class='table table-bordered'>
                <thead>
                    <tr>
                        <th>Weight</th>
                        <th>Height</th>
                        <th>Blood Pressure</th>
                        <th>Heart Rate</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = pg_fetch_assoc($result)) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['weight']) . "</td>
                    <td>" . htmlspecialchars($row['height']) . "</td>
                    <td>" . htmlspecialchars($row['bloodpressure']) . "</td>
                    <td>" . htmlspecialchars($row['heartrate']) . "</td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<p>No vital signs found for this user.</p>";
    }
} else {
    echo "<p>Invalid request.</p>";
}
?>
