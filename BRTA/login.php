<?php
session_start();
include_once "connection.php";


if (isset($_SESSION['user_id'])) {
  header("Location: dashboard.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $username = $_POST['uname'];
  $password = $_POST['pass'];


  $query = "SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id'];
    header("Location: dashboard.php");
    exit();
  } else {
    header("Location: login.php?err_msg=Login Failed");
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
    }

    form {
      border: 3px solid #f1f1f1;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      background-color: #04AA6D;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      opacity: 0.8;
    }

    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
    }

    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
    }

    img.avatar {
      width: 40%;
      border-radius: 50%;
    }

    .container {
      padding: 16px;
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }

    @media screen and (max-width: 300px) {
      span.psw {
        display: block;
        float: none;
      }

      .cancelbtn {
        width: 100%;
      }
    }


    .navbar {
      background-color: #0b4660;
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
  <br><br>



  <br>
  <br>
  <center>
    <h1>Log In</h1>
  </center>
  <br> <br>

  <?php
  if (isset($_GET["err_msg"])) {
    echo "<div class='alert alert-danger' role='alert'>" . $_GET["err_msg"] . "</div>";
  } else if (isset($_GET["success_msg"])) {
    echo "<div class='alert alert-success' role='alert'>" . $_GET["success_msg"] . "</div>";
  }
  ?>

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="container">
      <label for="uname"><b>Username</b></label>
      <input type="text" placeholder="Enter Username" name="uname" required>

      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="pass" required>

      <button name="login_btn" type="submit">Login</button>
    </div>
  </form>
  <br><br>

  <nav class="navbar">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="license_application.php">Registation</a></li>
      <li><a href="login.php">Log In</a></li>
      <li><a href="map.html">Location</a></li>

    </ul>
  </nav>


</body>

</html>