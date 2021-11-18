<?php
    require_once "config.php";

    session_start();
    
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_SESSION["username"];
        $sql = "DELETE from users WHERE username = '$username'";
        $res = mysqli_query($mysqli,$sql);
        if($res){

            $_SESSION = array();

            session_destroy();

            header("location: restList.php");
            exit;
        }else{
            echo 'error';
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
        body{ font: 14px sans-serif; }
        
    </style>

</head>
<body>
    <div class="container">
        <br>
        <p>Are you sure? :(</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
           
            <div class="form-group">
                <input type="submit" name="submit" class="btn btn-success" value="yes">
            </div>
            
        </form>
        
    </div>

</body>

</html>