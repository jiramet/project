  <?php   
 // session_start();
 include 'connect_db.php';

 if(isset($_POST["add_to_cart"]))  
 {  
      if(isset($_SESSION["shopping_cart"]))  
      {  
           $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");  
           if(!in_array($_GET["id"], $item_array_id))  
           {  
                $count = count($_SESSION["shopping_cart"]);  
                $item_array = array(  
                     'item_id'               =>     $_GET["id"],  
                     'item_name'               =>     $_POST["hidden_name"],  
                     'item_price'          =>     $_POST["hidden_price"],  
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
                'item_id'               =>     $_GET["id"],  
                'item_name'               =>     $_POST["hidden_name"],  
                'item_price'          =>     $_POST["hidden_price"],  
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
                if($values["item_id"] == $_GET["id"])  
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

           <?php include('css.php');?>
           <?php include('datable.php');?>
    
    <style type="text/css">
   #dataTables-example_filter {
    display: none;
   }
   #dataTables-example_length{
    display: none;
   }
    </style>

      </head>  
      <body>
           <?php include('menu.php');?>  
           <br />  
           <div class="container"">
                <h3 align="center">รายการเล่มโครงงานทั้งหมด</h3><br/>  
                <?php  

                // $query = "SELECT * FROM `bookborrow`";  
                // $result = mysqli_query($connect, $query);  
                // if(mysqli_num_rows($result) > 0)  
                // {  
                //      while($row = mysqli_fetch_array($result))  
                //      {  
                ?>  
                <!-- <div class="col-md-4"> -->
                     
                          <!-- <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">   -->
                               <!-- <img src="<?php echo $row["image"]; ?>" class="img-responsive" /><br />   -->
                               <!-- <h4 class="text-info"><?php echo $row["name"]; ?></h4> -->
                               <!-- <h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>   -->
                               <!-- <input type="text" name="quantity" class="form-control" value="1" />   -->
                               <!-- <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />   -->
                               <!-- <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />   -->
                               <!-- <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />   -->
                          <!-- </div> -->
                          <table width="100%" class="table table-striped table-bordered table-hover display" id="dataTables-example" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th style="width: 55px;padding-right: 1px;padding-left: 10px;">ลำดับที่</th>
                                        <th ><center>ชื่อเรื่อง</center></th>
                                        <th style="width: 15%"><center>ผู้จัดทำ</center></th>
                                        <th style="width: 15%"><center>อาจารย์ที่ปรึกษา</center></th>
                                        <th style="width: 10%"><center>ปีพ.ศ.</center></th>
                                        <th style="width: 10%"><center>เลือกยืม</center></th>
                                    </tr>
                                </thead>

                        <tbody>

                          <?php
                          include 'connect_db.php';

                          $sql_mem = "SELECT * FROM `book`
                          LEFT JOIN advisor ON book.advisorid = advisor.advisorid";
                          $resultq_mem = mysqli_query($conn, $sql_mem);

                          $i = 1;
                          while($row_mem = mysqli_fetch_array($resultq_mem)) { 

                          ?>

        <form method="post" action="index.php?action=add&id=<?php echo $row_mem["bookid"]; ?>"> 
        <tr>
            <label hidden=""><?php  echo $row_mem['bookid']; ?></label>
            <td><div align="center"><?=$i;?></div></td>
            <td><a href="detail_book_member.php?bookid=<?php  echo $row_mem["bookid"] ?>"><?php echo $row_mem['booknamethai']; ?></a></td>
            <td><?php echo $row_mem['student']; ?><input type="hidden" name="studentid"></td>
            <td><?php echo $row_mem['fname']; ?> <?php echo $row_mem['lname']; ?><input type="hidden" name="advisorid"></td>
            <td><?php echo $row_mem['year']+543; ?><input type="hidden" name="year"></td>
            <td><center><input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success btn-xs" value="เลือกยืม" /></center></td>

        </tr>

        <?php  
       $i++; } //} ?>
            
                        </tbody>
                            </table>

                     </form>  
                
                <?php  
                    // }  
                // }  
                ?>  
                <div style="clear:both"></div>  
                <br />  
                <h3>รายการเล่มโครงงาน</h3>  
                <div class="table-responsive">  
                     <table class="table table-bordered" id="dataTables-example">  
                          <tr>  
                               <th width="40%">Item Name</th>  
                               <th width="10%">Quantity</th>  
                               <th width="20%">Price</th>  
                               <th width="15%">Total</th>  
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
                               <td>$ <?php echo $values["item_price"]; ?></td>  
                               <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>  
                               <td><a href="index.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>  
                          </tr>  
                          <?php  
                                    $total = $total + ($values["item_quantity"] * $values["item_price"]);  
                               }  
                          ?>  
                          <tr>  
                               <td colspan="3" align="right">Total</td>  
                               <td align="right">$ <?php echo number_format($total, 2); ?></td>  
                               <td></td>  
                          </tr>  
                          <?php  
                          }  
                          ?>  
                     </table> 

                </div>  
           </div>  
           <br /> 

           <?php include('script.php'); ?>
      </body>  
 </html>