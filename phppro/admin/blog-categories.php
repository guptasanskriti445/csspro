<?php
$active_tab = "blogs";
$active_sub_tab = 'blog category';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'add':
        $slug = to_prety_url($_POST['name']);
        $data = $QueryFire->getAllData('blog_categories',' name="'.trim(strip_tags($_POST['name'])).'"');
        if(!empty($data) && $data[0]['level']!=1) {
          $slug = $slug.rand(10,999);
          $data = array();
        }
        if(empty($data)) {
          $QueryFire->insertData("blog_categories",array('slug'=>$slug,'level'=>1,'is_show'=>1,'parent_id'=>0,'name'=>trim(strip_tags($_POST['name']))));
          $msg = 'Category added successfully.';
        } else {
          $msg = 'Category already exists.';
        }
        unset($data);
        break;
    case 'update':
        $slug = to_prety_url($_POST['name']);
        $data = $QueryFire->getAllData('blog_categories',' name="'.trim(strip_tags($_POST['name'])).'" and id !='.$_POST['id']);
        if(!empty($data) && $data[0]['level']!=1) {
          $slug = $slug.rand(10,999);
          $data = array();
        }
        if(empty($data)) {
          $QueryFire->upDateTable("blog_categories",' id='.$_POST['id'],array('slug'=>$slug,'name'=>trim(strip_tags($_POST['name']))));
          $msg = 'Category updated successfully.';
        } else {
          $msg = 'Category already exists.';
        }
        unset($data);
        break;
    case 'delete':
        $QueryFire->upDateTable("blog_categories",' id='.$_POST['id'],array('is_deleted'=>1));
        //$QueryFire->deleteDataFromTable("categories",' id='.$_POST['id']);
        $msg = 'Category deleted successfully.';
        break;
  }
}
$categories = $QueryFire->getAllData('blog_categories',' level=1 and is_deleted=0 order by id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Manage Categories <button class="btn btn-primary float-right dev-add">Add Category</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Blogs</a></li>
            <li class="breadcrumb-item active">Categories</li>
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
            <table class="data-table table table-bordered table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($categories)) { $cnt=1;
                  foreach($categories as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td class="cat"><?php echo $row['name'];?></td>
                    <td>
                      <button class="btn btn-success btn-xs dev-edit mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>"> Delete</a> 
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
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Category</h5>
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
  <div id="add-edit-modal" class="modal fade" role="dialog"  data-backdrop="static">
    <div class="modal-dialog">
      <form method="post" action="" class="add-edit-form" enctype="multipart/form-data">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Category:</label>
              <input class="form-control category" name="name" required placeholder="Enter Category" type="text">
            </div>     
            <input type="hidden" name="user_action" class="user_action">
            <input type="hidden" name="id" class="user_id">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="add" >Submit</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      var validator = jQuery(".add-edit-form").validate({
        rules: {
          name: "required",
        },
        messages: {
          name: "Enter Category",
        }
      });
      jQuery(document).on("click",".dev-add",function(e){
        validator.resetForm();
        jQuery("#add-edit-modal .user_action").val("add");
        jQuery("#add-edit-modal .modal-title").html("Add New Category");
        jQuery("#add-edit-modal").modal("show");
      });
      jQuery(document).on("click",".dev-edit",function(e){ 
        validator.resetForm();
        jQuery("#add-edit-modal .modal-title").html("Update Category");
        jQuery("#add-edit-modal .user_action").val("update");
        jQuery("#add-edit-modal .user_id").val(jQuery(this).data("id"));
        jQuery("#add-edit-modal .category").val(jQuery(this).parents("tr").find(".cat").text());
        jQuery("#add-edit-modal").modal("show");
      });
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
    });
  </script>';
require_once('templates/footer.php');?>