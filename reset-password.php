<?php 
require_once "config.php";

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $newPassword = "";

    if(empty(trim($_POST["newPassword"]))){
        echo '<script>alert("Please fill out the forms")</script>';
    }else{
        $newPassword = $_POST["newPassword"];
    }


    if(!empty($newPassword)){

        $tmp = $_SESSION["username"];

        $sql = "UPDATE users SET password = '$newPassword' WHERE username = '$tmp'";
        $res = mysqli_query($mysqli,$sql);
        if($res){
            session_destroy();
            header("location: login.php");
            exit();
        }else{
            echo 'error 1';
        } 

    }else{
        echo 'error';
    }

    mysqli_close($mysqli);

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .container{ width: 400px; padding: 20px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);}
    </style>

</head>
<body>
    <div class="container">
        <h3>Reset Password</h3>
        <br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="newPassword" class="form-control" > 
            </div>
            <br>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit">
            </div>
        </form>
    </div>

</body>

</html>