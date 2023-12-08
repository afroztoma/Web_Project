<?php

include_once "connection.php";

if (isset($_POST["submit_btn"])) {
    $name = htmlspecialchars($_POST["name"]);
    $nid = htmlspecialchars($_POST["nid"]);
    $email = htmlspecialchars($_POST["email"]);
    $vehicleNo = htmlspecialchars($_POST["vehicleNo"]);
    $chassisNo = htmlspecialchars($_POST["chassisNo"]);
    $presentAddress = htmlspecialchars($_POST["presentAddress"]);
    $permanentAddress = htmlspecialchars($_POST["permanentAddress"]);

    $profile_pic = $_FILES["profile_pic"];
    $nidSoftCopy = $_FILES["nidSoftCopy"];

    $sql = "SELECT `email` FROM `applicants` WHERE `email` = '$email';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
?>
        <script>
            window.location.href = "license_application.php?err_msg=This email is already exists"
        </script>
<?php
        exit();
    }

    if ($_FILES["profile_pic"]["error"] == UPLOAD_ERR_OK && $_FILES["nidSoftCopy"]["error"] == UPLOAD_ERR_OK) {
        $targetDir = "./uploads/";

        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $target_file = $_FILES["profile_pic"]["name"];
        $image_tmp_name = $_FILES["profile_pic"]["tmp_name"];
        $imageFileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $profile_pic = "./uploads/" . $email . "." . $imageFileExt;

        $target_file = $_FILES["nidSoftCopy"]["name"];
        $file_tmp_name = $_FILES["nidSoftCopy"]["tmp_name"];
        $FileExt = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $nidSoftCopy = "./uploads/" . $email . "." . $FileExt;


        if ($imageFileExt != "jpg" && $imageFileExt != "png" && $imageFileExt != "jpeg" && $imageFileExt != "gif") {
            header("Location: license_application.php?msg=Sorry, only JPG, JPEG, PNG and GIF files are allowed");
            exit();
        } else if ($FileExt != "pdf") {
            header("Location: license_application.php?msg=Sorry, only PDF allowed");
            exit();
        } else {
            move_uploaded_file($image_tmp_name, $profile_pic) && move_uploaded_file($file_tmp_name, $nidSoftCopy);

            $sql = "INSERT INTO `applicants` (`name`, `nid_no`, `vehicle_no`, `vehicle_chassis_no`, `present_addr`, `permanent_addr`, `profile_pic`, `nid_softcopy`, `id`, `email`) VALUES ('$name', '$nid', '$vehicleNo', '$chassisNo', '$presentAddress', '$permanentAddress', '$profile_pic', '$nidSoftCopy', NULL, '$email')";
            if (mysqli_query($conn, $sql)) {
                header("Location: license_application.php?success_msg=Submition Success");
                exit();
            } else {
                header("Location: license_application.php?err_msg=Submition Failed");
                exit();
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 170vh;
        }


        .navbar {
            background-color:#0b4660;
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



        .container {
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            width: 50%;
            max-width: 500px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input,
        textarea {
            width: calc(100% - 16px);
            padding: 10px;
            margin-bottom: 16px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="file"] {
            margin-bottom: 8px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error {
            color: #ff0000;
        }
    </style>

    <script>
        function validateForm() {

        }
    </script>

    <title>Registation</title>

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



    <div class="container">
        <h2>Registation Form</h2>
        <form name="licenseForm" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
            <?php
            if (isset($_GET["err_msg"])) {
                echo "<div class='alert alert-danger' role='alert'>" . $_GET["err_msg"] . "</div>";
            } else if (isset($_GET["success_msg"])) {
                echo "<div class='alert alert-success' role='alert'>" . $_GET["success_msg"] . "</div>";
            }
            ?>
            <div class="mb-3"><label class="form-label" for="name">Your Name</label><input class="form-control item" type="text" id="name" name="name" required></div>
            <div class="mb-3"><label class="form-label" for="subject">NID No</label><input class="form-control item" type="text" id="nid" name="nid" required></div>
            <div class="mb-3"><label class="form-label" for="email">Email</label><input class="form-control item" type="email" id="email" name="email" required></div>
            <div class="mb-3"><label class="form-label" for="name">Vehicle No</label><input class="form-control item" type="text" id="vehicleNo" name="vehicleNo" required></div>
            <div class="mb-3"><label class="form-label" for="name">Vehicle Chassis No</label><input class="form-control item" type="text" id="chassisNo" name="chassisNo" required></div>
            <div class="mb-3"><label class="form-label" for="name">Present Address</label><input class="form-control item" type="text" id="presentAddress" name="presentAddress" required></div>
            <div class="mb-3"><label class="form-label" for="name">Permanent Address</label><input class="form-control item" type="text" id="permanentAddress" name="permanentAddress" required></div>
            <div class="mb-3"><label class="form-label" for="name">Your Photo</label><input class="form-control" type="file" accept="image/*" id="profile_pic" name="profile_pic" required></div>
            <div class="mb-3"><label class="form-label" for="name">NID Soft Copy (PDF)</label><input class="form-control" accept="application/pdf" id="nidSoftCopy" name="nidSoftCopy" type="file" required></div>
            <div class="mb-3 mt-4"><button class="btn btn-primary btn-lg d-block w-100" name="submit_btn" type="submit">Submit</button></div>

        </form>
    </div>
    <br><br>
</body>

</html>