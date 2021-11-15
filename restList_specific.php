 <HTML>

 <HEAD>
     <TITLE>restaurant spec</TITLE>
     <link rel="stylesheet" href="style.css">
 </HEAD>

 <BODY>



     <div class="wrapper">
         <b id="restName">

             <?php 
             
               
			$restName=$_GET[ 'restName' ];
			 
            
            $sql="select * from restList where restName = '$restName' ";
             
            $mysqli = mysqli_connect("localhost","root","1234","restTest_db");
            if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
            } else {
        
            $res = mysqli_query($mysqli,$sql);
             
             
            if ($res) {
                $row=mysqli_fetch_array($res);
                /* echo " wow ".$row['rest_type']." wow "; */
                $resttype=$row['rest_type'];
                $ranking=$row['rate'];
                $tel=$row['tel'];
                $location=$row['location'];
                $addr=$row['addr'];
               
            } else {
                printf("error: %s\n", mysqli_error($mysqli));
            }
            $sql2= "select * from food where rest = '$restName'";
            $res2 = mysqli_query($mysqli,$sql2);
            
            $sql3= "select * from comment where rest = '$restName'";
            $res3 = mysqli_query($mysqli,$sql3);

            
            if(isset($_POST[ 'contentArea' ])){
                $val=$_POST[ 'contentArea' ];
                
                $val2=$val;
                  // 로그인 구현이 안됐으니 일단 이름은 anon으로 insert 
                  
                $name='anon';
                 
                if($val!=null&&$val!=""){  

                    //새로고침시 계속 값 들어가는 걸 막기 위해... 
                    $sql4= "select * from comment where comment = '$val' and nickname= '$name' and rest= '$restName'" ;
                    $res4 = mysqli_query($mysqli,$sql4);
                    if($res4){
                        $num =mysqli_num_rows($res4);
                        echo $num;
                        if($num<1){
                            $sql5="insert into comment(rest,comment,nickname) values ( '$restName' , '$val' , '$name' )  ";
                            mysqli_query($mysqli,$sql5); 
                            echo ("<script>location.href='./restList_specific.php?restName=$restName'</script>") ;
 
                        }
                    }
                    else{
                        printf("error: %s\n", mysqli_error($mysqli));
                    }
                    
                     
                
                                  
                }     
                
                 
               
            }
          
            
                   
                 
            
             echo   "$restName - $resttype  ";  
        }
	    ?>
         </b>

         <div class="specificInfo">


             <?php
             echo   "rate: $ranking <br> "; 
             echo   "location: $location <br>";
             echo   "address: $addr <br>";
             echo   "contact: $tel <br> <br>"; 

             echo " ------------ menu ------------<br>";
             if($res2){
                while($newArray=mysqli_fetch_array($res2,MYSQLI_ASSOC)){
                    $food=$newArray['food'];
                    echo " $food <br>" ;
                }
            }else{
                printf("error" ); 
            }
           
               ?>

         </div>

         <div class="commentArea">
             comment <br>

             <form action="restList_specific.php?restName=<?php echo $restName;?>&' " method=post>

                 <input type="textarea" class='contentArea' id='contentArea' name='contentArea' maxlength=130>
                 <input type="submit" id=rep_bt class=re_bt value="submit">
             </form>




             <table class="type22">

                 <?php
              if($res3){
                while($newArray=mysqli_fetch_array($res3,MYSQLI_ASSOC)){
                    $name=$newArray['nickname'];
                    $comment=$newArray['comment'];     
                                   
                    echo "<tr> <td> <b> $name </b>      ";                  
                    echo" <button id = 'updateBtn'> delete </button>";           
                    echo" <button id = 'deleteBtn'> delete </button>";
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