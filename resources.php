<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearest Resources</title>

</head>

<body>
   <div class="header">
        <div class="logo-container">
            <img class="logo" src="EaseMindLogo.png" alt="EaseMind Logo" style="width: 200px; height: 200px" />
            <div class="site_name" style="font-size: 70px; color: hwb(195 2% 2%);">EaseMind</div>
        </div>
    </div>
    <div class="container">
        <h2>Nearest Resources:</h2>
        <?php
        // Function calculates distance between two points using the Haversine formula
        function calculateDistance($lat1, $lon1, $lat2, $lon2)
        {
            $earthRadius = 6371; // Radius of the Earth in kilometers
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);
            $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a)); // Calculates central angle ($c) in the Haversine formula
            $distance = $earthRadius * $c * 0.621371; // Distance in miles
            return $distance;
        }

        // Connecting to MySQL database
        $mysqli = require __DIR__ . "/database.php"; // Require database connection script
        
        // Get user's geolocation
        $user_lat = $_GET['user_lat']; // Retrieved from HTML5 Geolocation API
        $user_lon = $_GET['user_lon'];

        // SQL statement to select facilities closest to user
        $sql = "SELECT id, name, latitude, longitude, address 
            FROM resources 
            ORDER BY SQRT(POW(69.1 * (latitude - $user_lat), 2) + POW(69.1 * ($user_lon - longitude) * COS(latitude / 57.3), 2)), id 
            LIMIT 25";

        $result = $mysqli->query($sql); // Database query using MySQLi extension.
        
        if ($result === false) {
            // Query execution failed
            die("Error executing query: " . $mysqli->error);
        }

        if ($result->num_rows > 0) {
            // Display data of each row
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="facility">
                    <h3><?php echo $row["name"]; ?></h3>
                    <p><strong>Address:</strong> <?php echo $row["address"]; ?></p>
                </div>
                <?php
            }
        } else {
            echo "0 results";
        }
        $mysqli->close(); // Close connection
        ?>
    </div>

    <div class="btn-container">
        <a href="hotline.html"><button class="btn">Hotlines</button></a>
        <a href="online_resources.html"><button class="btn">Online Resources</button></a>
    </div>

</body>

</html>

<style>
       body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

.container {
    width: 680px;
    max-width: 100%;
    margin: 0 auto;
    padding: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #fff;
    overflow-y: auto;
    max-height: 300px; 
    position: relative;
}

.logo {
    width: 150px; /* Adjusted logo width */
    height: 150px; /* Adjusted logo height */
    margin-bottom: 15px; /* Increased margin bottom */
}

.btn-container {
    position: absolute;
    bottom: 18px; /* Increased bottom spacing */
    left: 50%;
    transform: translateX(-50%);
}

.btn {
    padding: 8px 16px;
    margin: 10px 6px; /* Increased margin */
    cursor: pointer;
    background-color: #0792ee;
    color: white;
    border: 2px solid #555;
    border-radius: 15px;
    width: auto;
    font-size: 16px;
}


.btn:hover {
    background-color: hwb(150 32% 11%);
}

h2 {
    color: hwb(195 2% 2%);
    text-align: center;
}

.facility {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.facility a {
    color: hwb(177 38% 20%);
    text-decoration: underline;
}

.facility a:hover {
    color: hwb(195 2% 2%);
}

.logo-container {
    text-align: center;
    margin-bottom: 20px;
}

.site_name {
    color: #333;
    margin-top: -40px; /* Adjust to move the site_name to the top */
}

.logo {
    margin-bottom: 10px;
}

    </style>