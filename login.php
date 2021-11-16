<?php

session_start();

// 이미 로그인 되어있다면 welcome 페이지로 이동
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = $login_err = "";

// submit 버튼 눌렀을 때
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // username 입력 확인
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // password 확인
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // 입력한 username과 password로 회원 확인
    if(empty($username_err) && empty($password_err)){

        // 실행할 쿼리 - username 확인
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($mysqli, $sql)){
            // stmt에 파라미터 연결
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // 파라미터에 값 넣기
            $param_username = $username;

            // stmt 실행
            if(mysqli_stmt_execute($stmt)){

                mysqli_stmt_store_result($stmt);

                // username이 존재한다면 password를 확인한다.
                if(mysqli_stmt_num_rows($stmt) == 1){

                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // 비밀번호 일치
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // welcome 페이지로 이동
                            header("location: welcome.php");
                        } else{
                            // 틀린 비밀번호
                            $login_err = "Wrong password. Try again.";
                        }
                    }
                } else{
                    // username이 존재하지 않는다.
                    $login_err = "Invalid username";
                }
            } else{
                echo "Error :(";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);}

    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p></p>

        <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-success" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>
