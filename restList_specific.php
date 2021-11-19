 <HTML>

 <HEAD>
     <TITLE>restaurant spec</TITLE>
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 </HEAD>

 <BODY>



     <div class="wrapper">
         <b id="restName">
 	     <div class='mypage'>
                 <a href="restList.php" class="btn btn-outline-primary">back to main page</a>
             </div>
             <?php 
             
            session_start();
			$restName=$_GET[ 'restName' ];
			 
            require_once "config.php";
            //restName
            $sql="select * from restList where restName = '$restName' ";
            $res = mysqli_query($mysqli,$sql);            
            if ($res) {
                $row=mysqli_fetch_array($res);              
                $resttype=$row['resttype'];             
                $tel=$row['tel'];
                $location=$row['location'];
                $addr=$row['addr'];
               
            } else {
                printf("error: %s\n", mysqli_error($mysqli));
            }
            $sql2= "select * from foods where restname = '$restName'";
            $res2 = mysqli_query($mysqli,$sql2);
            
            $sql3= "select * from reviews where restname = '$restName'";
            $res3 = mysqli_query($mysqli,$sql3);

            //댓글 입력 부분
            if(isset($_POST[ 'contentArea' ])){
                //transaction 시작 
                mysqli_begin_transaction($mysqli);
                 
                $val=$_POST[ 'contentArea' ];
                $score=$_POST['satisfaction'];                        
                $name=$_SESSION["username"];
                if(!isset($_SESSION["username"]))
                    $name="anon";
                //빈 값이 아닐때만 insert
                if($val!=null&&$val!=""){  
                 
                //같은 사람이 똑같은 리뷰 쓰기 불가능하도록
                 $duplicate= "select * from reviews where review = '$val' and username= '$name' and restname= '$restName'" ;
                 $checkdup = mysqli_query($mysqli,$duplicate);
                 if($checkdup){
                    $num =mysqli_num_rows($checkdup);    
                    if($num<1){
                             //리뷰를 테이블에 넣기
                            $sqlInsert="insert into reviews(restname,review,username,score) values ( '$restName' , '$val' , '$name',$score )  ";
                            $InsertReview=mysqli_query($mysqli,$sqlInsert); 
                            if($InsertReview){
                            //성공하면 커밋
                            mysqli_commit($mysqli);
                            
                            //새로고침
                            echo ("<script>location.href='./restList_specific.php?restName=$restName'</script>") ;
                            }  
                            else{
                                echo "<script> alert('fail');</script>";
                                //실패시 롤백
                                mysqli_rollback($mysqli); 
                            }                                                        
                    }
                 }
                 else{
                    echo "<script> alert('fail');</script>";
                    //실패시 롤백
                    mysqli_rollback($mysqli); 
                 }
                 //d
                                       
                                   
                    }  
         
              
            }

            //삭제하는 부분 
            if(isset($_POST[ 'deletename' ])&&isset($_POST[ 'deletecontent' ])){
                $nameD=$_POST[ 'deletename' ];
                $commentD=$_POST[ 'deletecontent' ];
                $delete="delete from reviews where username= '$nameD' and review='$commentD'";
                $deleteRes = mysqli_query($mysqli,$delete); 
                if($deleteRes){
                    echo "<script> alert('delete complete');</script>";
                    echo ("<script>location.href='./restList_specific.php?restName=$restName'</script>") ;
                     
                }
                else{
                    echo "<script> alert('fail');</script>";
                    printf("error: %s\n", mysqli_error($mysqli));
                }
               
            }
          
          
            
                   
                 
            
             echo   "$restName - $resttype  ";  
        
	    ?>
         </b>

         <div class="specificInfo">


             <?php          
             echo   "location: $location <br>";
             echo   "address: $addr <br>";
             echo   "contact: $tel <br> <br>"; 

             echo " ------------ menu ------------<br>";
             if($res2){
                while($newArray=mysqli_fetch_array($res2,MYSQLI_ASSOC)){
                    $food=$newArray['food'];
                    $price=$newArray['price'];
                    echo "$food : $price won<br>";
                }
            }else{
                printf("error" ); 
            }
            echo "<br>------------ employee ------------<br>";
           $sqlEmployee="select restname, count(*),role from employee group by restname, role having restname= '$restName';";
           $EmployRes = mysqli_query($mysqli,$sqlEmployee);
           if($EmployRes){
            while($newArray=mysqli_fetch_array($EmployRes,MYSQLI_ASSOC)){
                $role=$newArray['role'];
                $peopleNum=$newArray['count(*)'];
                echo "$role : $peopleNum persons<br>";
            }
           }
           else{
            printf("error" ); 
           }
               ?>

         </div>

         <div class="commentArea">


             <br>

             <form action="restList_specific.php?restName=<?php echo $restName;?>&' " method=post>


                 <select name='satisfaction' id='satifaction'>
                     <option value=5 selected>★★★★★
                     <option value=4> ★★★★
                     <option value=3>★★★
                     <option value=2> ★★
                     <option value=1> ★
                 </select>

                 <input type="textarea" class='contentArea' id='contentArea' name='contentArea' maxlength=130>
                 <input type="submit" id=rep_bt class="btn btn-success" value="submit">
             </form>

             <br>comment
             <?php
             $commentN="SELECT restname,COUNT(review) AS commentNum FROM reviews GROUP BY restname having restname= '$restName'; ";
             $countRes = mysqli_query($mysqli,$commentN); 
             if($commentN){
                while($newArray=mysqli_fetch_array($countRes,MYSQLI_ASSOC)){
                    $num=$newArray['commentNum'];
                    echo "($num)" ;
                }
            }else{
                printf("error" ); 
            }
             ?>

             <table class="type22">

                 <?php

                 function testFunc(){
                    echo "<script>alert('fail');</script>";
                 }
              if($res3){
                while($newArray=mysqli_fetch_array($res3,MYSQLI_ASSOC)){
                    $name=$newArray['username'];
                    $comment=$newArray['review'];     
                    $score=$newArray['score']; 
                    if($score==5) $star="★★★★★";
                    else if($score==4) $star="★★★★";
                    else if($score==3) $star="★★★";
                    else if($score==2) $star="★★";
                    else  $star="★";
                                   
                    echo "<tr> <td> <b> $name </b>";    
                    echo " <span id='scoreText'>   $star  </span> " ;   

                    $mysname;
                    if(!isset($_SESSION["username"]))
                        $myname="anonUser";
                    else{
                        $myname=$_SESSION["username"];
                    }        
                        
                    if($name==$myname){ 
                    ?>

                 <form action="modifyComment.php" method="post" target="payviewer"
                     onsubmit="window.open('modifyComment.php', 'payviewer', 'width=1000, height=80, top=240, left=150');">

                     <?php
                     echo "
                      
                     <input type='hidden' name='comment' value='$comment'>
                     <input type='hidden' name='name' value='$name'>
                     <input type='submit' id='updateBtn' value='update'>
                        </form>";
                    ?>

                     <form action="restList_specific.php?restName=<?php echo $restName;?>&' " method=post>

                         <input type="hidden" name='deletename' value='<?php echo $name;?>'>
                         <input type="hidden" name='deletecontent' value='<?php echo $comment;?>'>
                         <input type="submit" id=deleteBtn class=deleteBtn value="delete">
                     </form>

                     <?php
                     }
                     
                    echo " <br> $comment </td></tr>" ;
                    
                 }
                 }else{
                 printf("error" );
                 }


                 mysqli_close($mysqli);



                 ?>



             </table>





         </div>
     </div>


 </BODY>

 </HTML>
