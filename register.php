<?php
require_once "config.php";

$username = $password = $confirm_password = $username_err = $password_err = $confirm_password_err = "";

// submit 버튼 누르면
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // username 입력확인
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);
            // username 확인
            if(mysqli_stmt_execute($stmt)){
                
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // username이 이미 존재한다면
                    $username_err = "This username is already taken.";
                } else{
                    // username에 입력을 담는다.
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Error :(";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // password 확인
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // confirm password 확인
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // 앞 과정에서 에러가 있었는지 확인한다.
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // users 테이블에 새로운 유저를 추가할 쿼리
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); 

            if(mysqli_stmt_execute($stmt)){
                // 회원가입 성공 시 로그인 페이지로 이동
                header("location: login.php");
            } else{
                echo "Error :(";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p></p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
            <p>Already have an account? <a href="login.php">Login</a>.</p>
        </form>
    </div>
</body>
</html>
