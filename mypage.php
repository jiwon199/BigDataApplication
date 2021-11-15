<?php
require_once "config.php";

session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


$sql = "SELECT * FROM user_favorites WHERE username = '".$_SESSION["username"]."'";

$result = mysqli_query($link, $sql);

echo "<table class=\"table\" >
<thead>
<tr>
<th>username</th>
<th>restaurant name</th>
</tr>
</thead>";

if (mysqli_num_rows($result) > 0) {
    
    echo "<tbody>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['username'] . "</td>";
        echo "<td>" . $row['restaurant_name'] . "</td>";
        echo "</tr>";
      
    }
    echo "</tbody>";
    
} else {
    echo "0 results";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 100%; padding: 20px; margin-left: auto; margin-right: auto;}
        .table{ width:500px; margin-left: auto; margin-right: auto;}
    </style>
</head>
<body>
  


<div class="wrapper">
    <h1 class="my-5">This is <?php echo htmlspecialchars($_SESSION["username"]); ?>'s Page</h1>
    <a href="restlist.php" class="btn btn-primary">Back to main</a>
    <p></p>
    <a href="reset-password.php" class="btn btn-outline-secondary">Reset Password</a>
    <a href="logout.php" class="btn btn-outline-danger">Logout</a>
<br><br><br>
    <h5>❤ My favorites ❤</h5>
</div>
</body>
</html>