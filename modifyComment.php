<HTML>

<HEAD>
    <link rel="stylesheet" href="style.css">
    <h2>modify comment</h2>
</HEAD>

<BODY>


    <?php
    $comment=$_POST['comment'];
    $name=$_POST['name'];


    if(isset($_POST[ 'contentArea' ])){
        $val=$_POST[ 'contentArea' ];
        
        if($val!=null&&$val!=""){
        $mysqli = mysqli_connect("localhost","root","1234","restTest_db");
        if (mysqli_connect_errno()) {
            echo "<script>alert('fail');</script>";
       
        } else {
             
            $sql="update comment set comment='$val' where nickname='$name' and comment = '$comment'";
            $res = mysqli_query($mysqli,$sql);
            
            if(!$res){
                echo "<script>alert('fail');</script>";
            }                 
        }
         mysqli_close($mysqli);
   
    }
        
       
        echo "<script>opener.location.reload();window.close();</script>";

    }
  
        
    ?>

    <form action="modifyComment.php" method="post">

        <input type="textarea" class='contentArea' id='contentArea' name='contentArea' maxlength=130
            value='<?php echo $comment;?>'>

        <input type='hidden' name='comment' value='<?php echo $comment;?>'>
        <input type='hidden' name='name' value='<?php echo $name;?>'>
        <input type="submit" id=rep_bt class=re_bt value="modify">
    </form>


</BODY>

</HTML>