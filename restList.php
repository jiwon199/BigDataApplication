 <HTML>

 <HEAD>
     <TITLE>Retaurant List</TITLE>
     <link rel="stylesheet" href="style.css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <style>
        .mypage{ width: 100%; margin: 20px;}
    </style>
 </HEAD>

 <BODY>
    <div class='mypage'>
        <a href="mypage.php" class="btn btn-outline-primary">My Page</a>
    </div>

     <div class="searchOption">
         <form action="restList.php" method=post>
             <b> Search filter </b> <br>
             ranking order
             <input type="checkbox" name="ranking">

             restaurant type
             <select name="type">
                 <option value="Casual Dining" selected>Casual Dining
                 <option value="Cafe"> Cafe
             </select>
             restaurant name
             <input type=text size=5 name="resName">
             <input type=submit value="submit">
         </form>
     </div>
     <?php
      
       
       
      function QueryRun($sql) {
        $mysqli = mysqli_connect("localhost","root","pw","BDAproject");
        if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
        } else {
        
        $res = mysqli_query($mysqli,$sql);
        if ($res) {
            while($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC)){
                $restName=$newArray['restName'];
                $restType=$newArray['rest_type'];
                $rank=$newArray['rate'];
                
                echo "<tr  style=cursor:pointer; onClick= location.href='./restList_specific.php?restName=$restName' >";
                echo "<td >" .$restName . "</td>";
                echo "<td>" . $restType . "</td>";
                echo "<td>" . $rank . "</td>";
                
                echo "</tr>";
                 
     
              /*   echo "<tr  > <td>  $restName </td> <td>  $restType </td> <td>  $rank </td></tr>";    */        
                /* echo "The name is ".$restName." the type is ".$restType." the rank is ".$rank."<br/>"; */
            }
         
        } else {
        printf("error: %s\n", mysqli_error($mysqli));
        }
        $count=mysqli_num_rows($res);
         
        mysqli_close($mysqli);
        }
    }
         
         
 
?>


     <table class="type11">
         <tr>
             <th>name</th>
             <th>type</th>
             <th>rank</th>
         </tr>
         <tr>
             <?php

                $sql = "select * from restList";
                QueryRun($sql);
              

?>
         </tr>

     </table>
     <BR>


 </BODY>

 </HTML>