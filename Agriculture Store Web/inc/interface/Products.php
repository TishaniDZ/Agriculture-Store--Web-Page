<div class="row clearfix">

<?php 

if ($PN=="Items") {

    if ($_GET['category']=="all" OR $_GET['category']=="other") {//$_GET['category']=="all" OR $_GET['category']=="other"

        if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {

        $query = "SELECT favorite.*,products.* FROM favorite INNER JOIN products ON favorite.ProductID = products.product_id WHERE favorite.fav_by ='{$_SESSION['user_id']}' ORDER BY favorite.time DESC";

        } }  else {

            if (isset($_GET['search'])) { //WHERE  (title LIKE '%{$_GET['search']}%' OR type LIKE '%{$_GET['search']}%')

            $query = "SELECT * FROM products WHERE (product_name LIKE '%{$_GET['search']}%' OR product_category LIKE '%{$_GET['search']}%') ORDER BY time DESC";

            } else {
                $query = "SELECT * FROM products ORDER BY time DESC";//$query = "SELECT * FROM products ORDER BY time DESC";
            }
            
        }

    } else {

            $query = "SELECT * FROM products WHERE product_category='{$_GET['category']}' ORDER BY time DESC";

    }
}

$Products = mysqli_query($connection, $query);
$row_results=mysqli_num_rows ($Products);
if ($Products) {
while ($Product = mysqli_fetch_assoc($Products)) {?>

<div class="col-lg-3 col-md-4 col-sm-12" style="margin-bottom:25px;">
<div class="card product_item">
<div class="body">
<a href="#!" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>" >
<div class="cp_img">
<img src="<?php echo $BaseUrl;?>images/products/<?php echo $Product['product_image'];?>" alt="Product" class="img-fluid">
<div class="hover">
                            
</div>
</div>
</a>
<div class="product_details text-center">
<h5><a href="#!" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>" ><?php echo $Product['product_name'];?></a></h5>
<ul class="product_price list-unstyled">
<li class="old_price" style="font-size:25px;">Rs.<?php echo $Product['product_price'];?></li>
<hr>

<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</button>


<?php if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {?>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></button>


<?php } } else { ?>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ViewDetails-<?php echo $Product['product_id'];?>"><i class="fa fa-heart" aria-hidden="true"></i></button>

<?php } ?>

<?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { ?>

<a href="<?php $BaseUrl;?>items.php?category=all&DeleteProduct=<?php echo $Product['product_id'];?>" onclick="return confirm('Are You Sure?');"><button type="button" class="btn btn-warning"><i class="fa fa-trash" aria-hidden="true"></i></button></a>

<?php } } ?>
</ul>

</div>
</div>
</div>
</div>

<div class="modal fade" id="ViewDetails-<?php echo $Product['product_id'];?>" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $Product['product_name'];?></h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<center>
<img src="<?php echo $BaseUrl;?>images/products/<?php echo $Product['product_image'];?>" alt="Product" class="img-fluid" width="250">
</center>
<br>
<p><?php echo(htmlentities($Product['product_disc']));?></p>
<hr>
<table>
<tr>
<td>PRODUCT NAME</td>
<td>:</td>
<td><?php echo $Product['product_name'];?></td>
</tr>
<tr>
<td>PRODUCT CATEGORY</td>
<td>:</td>
<td><a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>"><?php echo $Product['product_category'];?></a></td>
</tr>
<tr>
<td><b>PRODUCT PRICE</b></td>
<td><b>:</b></td>
<td><b>Rs.<?php echo $Product['product_price'];?></b></td>
</tr>
</table>


<?php if (isset($_SESSION['user_id'])) { if ($login_u['acountType']=="admin") { ?>

<a href="<?php $BaseUrl;?>items.php?category=all&DeleteProduct=<?php echo $Product['product_id'];?>" onclick="return confirm('Are You Sure?');"><button type="button" class="btn btn-warning"><i class="fa fa-trash" aria-hidden="true"></i> Delete Product</button></a>

<?php }} ?>

<?php if (!isset($_SESSION['user_id']) OR $login_u['acountType']=="user") { ?>

<a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>&addCart=<?php echo $Product['product_id'];?>">
<button type="button" class="btn btn-warning btn-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</button>


</a>
<br>

<?php if (isset($_GET['info'])) { if ($_GET['info']=="favorite") {?>


<a href="<?php echo $BaseUrl;?>items.php?category=all&info=favorite&favDelete=<?php echo $Product['id'];?>">
<button type="button" class="btn btn-danger btn-block"><i class="fa fa-trash" aria-hidden="true"></i> Remove From Favorite</button>
</a>


<?php } } else { ?>

<a href="<?php echo $BaseUrl;?>items.php?category=<?php echo $Product['product_category'];?>&fav=<?php echo $Product['product_id'];?>">
<button type="button" class="btn btn-primary btn-block"><i class="fa fa-heart" aria-hidden="true"></i> Add To Favorite</button>
</a>


<?php } } ?>


</div>
<div class="modal-footer">
<!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
</div>
</div>
</div>
</div>

<?php } }  if ($row_results == 0) { echo '<div class="card-body"><center><img src="images/noResult.png" width="600"></center></div>';} ?>
    </div>