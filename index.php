  <?php   
 // session_start();
 // $connect = mysqli_connect("localhost", "root", "1234", "test");
 include 'connect_db.php';

 if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["bookid"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["bookid"],  
                     'item_name'               =>     $_POST["hidden_name"],
                     // 'item_price'          =>     $_POST["hidden_price"],  
                     'item_quantity'          =>     $_POST["quantity"] 
                );  
                $_SESSION["shopping_cart"][$count] = $item_array;  
           }  
           else  
           {  
                echo '<script>alert("Item Already Added")</script>';  
                echo '<script>window.location="index.php"</script>';  
           }  
      }  
      else  
      {  
           $item_array = array(  
                'item_id'               =>     $_GET["bookid"],  
                'item_name'               =>     $_POST["hidden_name"],  
                // 'item_price'          =>     $_POST["hidden_price"],  
                'item_quantity'          =>     $_POST["quantity"]
           );  
           $_SESSION["shopping_cart"][0] = $item_array;  
      }  
 }  
 if(isset($_GET["action"]))  
 {  
      if($_GET["action"] == "delete")  
      {  
           foreach($_SESSION["shopping_cart"] as $keys => $values)  
           {  
                if($values["item_id"] == $_GET["bookid"])  
                {  
                     unset($_SESSION["shopping_cart"][$keys]);  
                     echo '<script>alert("Item Removed")</script>';  
                     echo '<script>window.location="index.php"</script>';  
                }  
           }  
      }  
 }
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Webslesson Tutorial | Simple PHP Mysql Shopping Cart</title>            
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

           <?php include('css.php') ?>
           <?php include('datable.php') ?>
      </head>  
      <body>
           <?php include('menu.php') ?>
           <br />  
           <div class="container" ">  
                <h3 align="center">Simple PHP Mysql Shopping Cart</h3><br /><?php echo '<pre>' .print_r($_SESSION, TRUE). '</pre>'; ?>
                <table width="100%" class="table table-striped table-bordered table-hover display" id="dataTables-example" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th ><center>ชื่อเรื่อง</center></th>
                                        <th ><center>ชื่อเรื่อง</center></th>
                                        <th ><center>ผู้จัดทำ</center></th>
                                        <!-- <th style="width: 15%"><center>อาจารย์ที่ปรึกษา</center></th> -->
                                        <!-- <th style="width: 10%"><center>ปีพ.ศ.</center></th> -->
                                        <th style="width: 10%"><center>เลือกยืม</center></th>
                                    </tr>
                                </thead>

                        <tbody>
                <?php  
                $query = "SELECT * FROM book LEFT JOIN advisor ON book.advisorid = advisor.advisorid";  
                $result = mysqli_query($conn, $query);  
                if(mysqli_num_rows($result) > 0)  
                {  
                     while($row = mysqli_fetch_array($result))  
                     {
                ?>  
                     <form method="post" action="index.php?action=add&bookid=<?php echo $row["bookid"]; ?>">                      
                      <tr>
                          <td><?php echo $row['bookid']; ?>   <input type="hidden" name="bookid" value="<?php echo $row["bookid"]; ?>" />    </td>
                          <td><?php echo $row['booknamethai']; ?>   <input type="hidden" name="hidden_name" value="<?php echo $row["booknamethai"]; ?>" />    </td>
                          <td><?php echo $row['student']; ?>    <input type="hidden" name="quantity" class="form-control" value="1" />     </td>
                          <!-- <td><?php echo $row['fname']; ?> <?php echo $row['lname']; ?>    <input type="hidden" name="hidden_price" value="<?php echo $row["advisorid"]; ?>" />    </td> -->
                          <!-- <td><?php echo $row['year']+543; ?>   <input type="hidden" name="year">   </td> -->
                          <td><center>    <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success btn-xs" value="เลือกยืม" /></center>   </td>
                      </tr>
</form>
                <?php } } ?>
                      
                        </tbody>
                </table> 
                     

                <div style="clear:both"></div>  
                <br />  
                <h3>Order Details</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <!-- <th width="20%">Price</th> -->
                               <th width="5%">Action</th>  
                          </tr>  
                          <?php   
                          if(!empty($_SESSION["shopping_cart"]))  
                          {  
                               $total = 0;  
                               foreach($_SESSION["shopping_cart"] as $keys => $values)  
                               {  
                          ?>  
                          <tr>  
                               <td><?php echo $values["item_name"]; ?></td>  
                               <td><?php echo $values["item_quantity"]; ?></td>  
                               <!-- <td><?php echo $values["item_price"]; ?></td>   -->
                               <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php } } ?>
                     </table>  
                </div>  
           </div>
           <br />
           <?php // include('script.php') ?>
      </body>  
 </html>