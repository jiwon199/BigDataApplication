<HTML>

<HEAD>
    <link rel="stylesheet" href="style.css">
    <h2>modify comment</h2>
</HEAD>

<BODY>


    <?php
    
    $comment=$_POST['comment'];
    $name=$_POST['name'];
    require_once "config.php";

    
    if(isset($_POST[ 'contentArea' ])){
        $val=$_POST[ 'contentArea' ];
        
        if($val!=null&&$val!=""){        
            $sql="update reviews set review='$val' where username='$name' and review = '$comment'";
            $res = mysqli_query($mysqli,$sql);
            
            if(!$res){
                echo "<script>alert('fail');</script>";
                          
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