<?php 
require_once "config.php";

session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$username = $_SESSION["username"];
$location = $contact = "";
$sql = "SELECT address, contact FROM userDetails WHERE username = '$username'";
$res = mysqli_query($mysqli,$sql);

if($res){
    while($row = mysqli_fetch_assoc($res)){
        $location = $row['address'];
        $contact = $row['contact'];
    }
    
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }
        .wrapper{ width: 50%; padding: 20px; position: fixed; top: 50%; left: 0%; transform: translate(0%, -50%);}
        .wrapper2{ width: 50%; height: 80%; overflow: auto; padding: 20px; position: fixed; top: 50%; right: 0%; transform: translate(0%, -50%);}
        .table{ width:500px; margin-left: auto; margin-right: auto;}
    </style>

</head>
<body>

    <div class="wrapper">
        <h1 class="my-5"><?php echo htmlspecialchars($_SESSION["username"]); ?>'s Page</h1>
        <h4>My Info.</h4>
        <h6>Location: <?php echo $location ?></h6>
        <h6>Contact: <?php echo $contact ?></h6>
        <br><br>

        <a href="restList.php" class="btn btn-primary">Back to main</a>
        <p></p>
        <a href="reset-password.php" class="btn btn-outline-secondary">Reset Password</a>
        <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        <a href="" onClick="open_win_editar()" class="btn btn-danger">Delete Account</a>

        <script language="javascript">
            function open_win_editar() {
                window.open (
                    'delete_account.php', 'payviewer', 'width=1000, height=80, top=240, left=150'
                );
            }
        </script>
    <br><br><br>
        
    </div>
    <div class="wrapper2">
        <h2>My reviews</h2>
        <br>
        <table class='table'>
            <thead>
                <tr>
                <th scope="col">Restaurant</th>
                <th scope="col">rating</th>
                <th scope="col">review</th>
                </tr>
            </thead>
            <tbody>
                <?php 

                    $sql = "SELECT * FROM reviews WHERE username = '".$_SESSION["username"]."' ORDER BY score desc";

                    $result = mysqli_query($mysqli, $sql);
                    if (mysqli_num_rows($result) > 0) {
    
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['restname'] . "</td>";
                            echo "<td>" . $row['score'] . "</td>";
                            echo "<td>" . $row['review'] . "</td>";
                            echo "</tr>";
                          
                        }
                        
                    } else {
                        echo "0 results";
                    }
                ?>

            </tbody>
        </table>
    </div>

</body>

</html>
