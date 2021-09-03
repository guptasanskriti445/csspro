<?php
$active_tab = 'products';
$active_sub_tab = 'products';
$jscss='both';
$prependScript="<style>
  .img-thumbnail {
    max-height:100px;
  }
  .bg-warn{
    background:#e9c7d0;
  }
</style>";
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        $where = 'id ='.$_REQUEST['id'];
        $QueryFire->deleteDataFromTable("products",$where,array('is_deleted'=>1));
        echo "success";
        $msg = 'Product deleted successfully.';
        break;
  }
}
$products = $QueryFire->getAllData('products',' is_deleted=0 ','SELECT p.*,c.name as category,b.name as brand FROM products as p JOIN categories as c ON c.id=p.cat_id JOIN brands as b ON b.id=p.brand_id WHERE p.is_deleted=0 Order By p.id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Products <a href="add-product" class="btn btn-primary btn-sm float-right">Add Product</a> <a href="export-data?allProducts=1" class="btn btn-secondary pull-right btn-sm float-right">Export Products</a></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Product Management</a></li>
            <li class="breadcrumb-item active">Products</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <?php echo !empty($msg)?'<h5 class="text-center text-success">'.$msg.'</h5>':''?>
            <table class="data-table table table-bordered table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Category</th>
                  <th>Brand</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($products)) { $cnt=1;
                  foreach($products as $product) { ?>
                  <tr <?= $product['qty']<3?'class="bg-warn"':''?> >
                    <td><?php echo $cnt++;?></td>
                    <td><?php echo ucfirst($product['name']);?></td>
                    <td><?php echo $product['qty'];?></td>
                    <td><?php echo $product['price'];?></td>
                    <td><?= makeShortString(strip_tags(html_entity_decode($product['details'])),200)?></td>
                    <td><?php echo ucfirst($product['category']);?></td>
                    <td><?php echo ucfirst($product['brand']);?></td>
                    <td><img src="../images/products/<?= $product['image_name']?>" class="img-thumbnail img-responsive" /></td>
                    <td>
                      <a href="edit-product?product_id=<?php echo $product['id'];?>" class="btn btn-info btn-xs"> Edit</a> 
                      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $product['id'];?>"> Delete</a>
                    </td>
                  </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="modal fade" data-backdrop="static"  id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <form method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" name="id" />
          <div class="modal-footer">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal">Close</button>
            <button type="submit" name="user_action" value="delete" class="btn btn-outline-danger rounded-0">Yes, Delete</button>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
    });
  </script>';
require_once('templates/footer.php');?>