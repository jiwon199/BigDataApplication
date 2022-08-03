<?php
require_once "config.php";

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: restList.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $password = "";

    if(empty(trim($_POST["username"]))||empty(trim($_POST["password"]))){
        echo '<script>alert("Please fill out the forms")</script>';
    }else{
        $username = $_POST["username"];
        $password = $_POST["password"];
    }


    if(!empty($username)&&!empty($password)){
        $sql = "SELECT username, password FROM users WHERE username = '$username'";
        $res = mysqli_query($mysqli,$sql);
        if($res){
            if(mysqli_num_rows($res)==0){
                // username이 존재하지 않는다.
                echo '<script>alert("username does not exits")</script>';
            }else{
                while($row = mysqli_fetch_assoc($res)){
                    if($row['password']===$password){
                        session_start();

                        $_SESSION["loggedin"] = true;
                        $_SESSION["username"] = $username;

                        header("location: restList.php");
                    }else{
                        echo '<script>alert("Wrong password")</script>';
                    }
                }
            }


        }

    }

    mysqli_close($mysqli);

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font: 14px sans-serif;
    }

    .container {
        width: 400px;
        padding: 20px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    </style>

</head>

<body>
    <div class="container">
        <h3>Login</h3>
        <br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit">
            </div>
            <p>Don't have an account? <a href="register.php">Create Account</a>.</p>
        </form>
    </div>

</body>

</html>