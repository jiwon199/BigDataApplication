<HTML>

<HEAD>
    <TITLE>Retaurant List</TITLE>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    .mypage {
        width: 100%;
        margin: 20px;
    }
    </style>
</HEAD>

<BODY>
    <?php
     if(isset($_POST[ 'flag' ])){
        $flag=$_POST[ 'flag' ];
        if ($flag==1)
            $currentOpt="rating order-no review, no shown";
        else if($flag==2)
            $currentOpt="cheap price order";
        else
            $currentOpt="default order";
    }
    else{
        $flag=0; 
        $currentOpt="default order";
    }
         
        
    ?>
    <div class='mypage'>
        <a href="mypage.php" class="btn btn-outline-primary">My Page</a>
    </div>



    <div class="searchOption">


        <form action="restList.php" method=post>
            <b> Order Option</b><br>
            <span id='scoreText'> <?php echo $currentOpt; ?> </span><br><br>
            <select name="flag">
                <option value=0 selected>default order
                <option value=1> rating order
                <option value=2> cheap price order
            </select>

            <input type=submit value="ok" class='btn btn-outline-primary'>
        </form>
    </div>

    <?php
      
       
       
      function QueryRun($sql,$flag) {
        require_once "config.php";
       
        $res = mysqli_query($mysqli,$sql);
        if ($res) {
            while($newArray=mysqli_fetch_array($res,MYSQLI_ASSOC)){
                $restName=$newArray['restname'];
                $passVal = str_replace(" ", "%20", $restName);
                 
        
                 echo "<tr style=cursor:pointer; onClick=location.href='./restList_specific.php?";
                 echo "restName=$passVal' >";     


              
                 
                if($flag==1){
                    $rate=$newArray['average'];
                    $avg=$newArray['avg(rev.score)'];
                    echo "<td>" . $rate . "</td>";
                    echo "<td >" .$restName . "</td>";
                    echo "<td>" . round($avg,1) . "</td>";
                    
                   
                }
                else if($flag==2){
                    $cheapOrder=$newArray['cheapOrder'];
                    $priceAvg=$newArray['priceAvg'];
                    echo "<td>" . $cheapOrder . "</td>";
                    echo "<td >" .$restName . "</td>";                   
                    echo "<td>" . round($priceAvg,1) . "</td>";
                    
                }
                else  {
                    $restType=$newArray['resttype'];
                    echo "<td >" .$restName . "</td>";
                    echo "<td>" . $restType . "</td>";
                     
                }
                 
               
              
                
                
                echo "</tr>";
                 
     
               
            }
         
        } else {
        printf("error: %s\n", mysqli_error($mysqli));
        }
        //$count=mysqli_num_rows($res);
         
        mysqli_close($mysqli);
        }
     
         
         
 
?>


    <table class="type11">
        <tr>
            <?php
            
                if($flag==1){
                     
                    echo " <th>rating order</th><th>name</th> <th>avg score</th></tr> <tr>";
                    $sql="select rest.restname, row_number() over (order by avg(rev.score)) as average ,avg(rev.score)
                    from restList as rest, reviews as rev
                    where rest.restname = rev.restname group by restname order by average;";
                    QueryRun($sql,$flag);
                }
                else if($flag==2){
                    echo " <th>cheap order</th><th>name</th> <th>avg price</th></tr> <tr>";
                    $sql="select restname, rank() over (order by priceAvg) as cheapOrder,priceAvg
                    from  
                    (select restname, avg(foods.price) as priceAvg from foods group by restname
                    ) as priceT;";
                    QueryRun($sql,$flag);
                }
                //0이거나 null이면 normal order;
                else{
                    echo " <th>name</th><th>type</th> </tr> <tr>";
                    $sql = "select * from restList";
                    QueryRun($sql,$flag);
                }
                
                
             
              

        ?>
        </tr>

    </table>
    <BR>


</BODY>

</HTML>
