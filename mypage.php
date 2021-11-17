<?php 
require_once "config.php";

session_start();


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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

</body>

</html>
