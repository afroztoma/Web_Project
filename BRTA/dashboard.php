<?php
include_once "connection.php";
session_start();

if (!isset($_SESSION["user_id"])) {
?>
    <script>
        window.location.href = "logout.php";
    </script>
<?php
}

$sql = "SELECT * FROM `applicants`";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Dashboard</title>
    <style>
        .navbar {
            background-color: #8b8787;
            color: white;
            position: fixed;
            width: 100%;
            top: 0;
            padding: 10px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;

        }

        .navbar li {
            display: inline;
            margin-right: 20px;
            float: left;
        }

        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 4px 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #111;
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="license_application.php">Registation</a></li>
            <li><a href="login.php">Log In</a></li>
            <li><a href="map.html">Location</a></li>

        </ul>
    </nav>
    <br><br><br>
    <center><h1>Dashboard</h1></center>
    <section class="portfolio-block project-no-images">
        <div class="container">
            <div class="heading">
                <h2><span style="font-weight: normal !important; color: rgb(82, 96, 105);">Applicants&nbsp;</span></h2>
            </div>
            <div class="row">
                <?php
                while ($row = $result->fetch_assoc()) {
                ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card-no-image"><img style="border-radius: 11px;margin: 0px;margin-bottom: 12px;" width="100" height="80" src="<?php echo $row["profile_pic"]; ?>">
                            <h3><?php echo $row["name"]; ?></h3><a class="btn btn-outline-primary btn-sm" role="button" href="./applicants_details.php?applicants_email=<?php echo $row["email"]; ?>">Details</a>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </section>
    <br><br><br><br>
    <center>
    <a href="logout.php" class="btn btn-primary">Logout</a>
    </center>
</body>

</html>