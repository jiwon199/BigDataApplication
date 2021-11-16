


<?php 
require_once "config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        echo '<script>alert("Please fill out the forms")</script>';
    }else{
        $username = $_POST["username"];
        $sql = "SELECT id FROM users WHERE username = '$username'";
        $res = mysqli_query($mysqli,$sql);
        if($res){
            if(mysqli_num_rows($res)!=0){
                echo '<script>alert("username already exits")</script>';
            }else{
                mysqli_free_result($res);
                if(empty(trim($_POST["password"]))){
                    echo '<script>alert("Please fill out the forms")</script>';
                }else{
                    $pw = $_POST["password"];
                    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$pw')";
                    $res = mysqli_query($mysqli,$sql);
                    if($res){
                        header("location: login.php");
                    }else{
                        printf(mysqli_error($mysqli));
                        echo 'error';
                        
                    }
                }
            }
        }else{
            echo 'error';
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
        body{ font: 14px sans-serif; }
        .container{ width: 400px; padding: 20px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);}
    </style>

</head>
<body>
    <div class="container">
        <h3>Create Account</h3>
        <br><br>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" > 
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="submit">
            </div>
            <p>Already have an account? <a href="login.php">Login</a>.</p>
        </form>
    </div>

</body>

</html>