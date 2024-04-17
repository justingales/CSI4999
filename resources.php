<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearest Resources</title>

</head>

<body>
    <img class="logo" src="EaseMindLogo.png" alt="EaseMind Logo" style="width: 200px; height: 200px" />
    <div class="text_box">
        <div class="site_name" style="font-size: 70px">EaseMind</div>
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
    .btn-container {
        margin-top: 10px;
        display: flex;
        justify-content: center;
    }

    .btn {
        padding: 10px 20px;
        margin: 10px 10px;
        
        cursor: pointer;
        background-color: #0792ee;
        color: white;
        border: 2px solid hwb(177 38% 20%);
        border-radius: 25%;
        transform: translateY(290px) translateX(-550px);
        width: 200px;
        text-align: center;
    }

    .btn:hover {
        background-color: hwb(150 32% 11%);
    }

    h2 {
        color: hwb(195 2% 2%);
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f0f0;
    }

    .container {
        width: 800px;
        height: 300px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        overflow-y: auto;
        transform: translateY(90px) translateX(-60px);
        max-width: 100%
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

    .text_box {
        vertical-align: center;
        text-align: center;
        transform: translateX(380px) translateY(-125px);
        color: hwb(195 2% 2%);
        margin-bottom: 10px;
    }

    .logo {
        transform: translateY(-250px) translateX(650px);
    }
</style>