<?php
$active_tab = 'products';
$active_sub_tab = 'products';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['act']))
{
  if($_POST['act']=='remove') {
    if($QueryFire->deleteDataFromTable('products_has_images','image_name="'.$_POST['image_name'].'"'))
    {
      unlinkImage('../images/products/'.$_POST['image_name']);
      $msg = "Image deleted";
    }
    else
      $msg = 'Sorry! unable to delete image';
  }
}
if(isset($_POST['submit'])) {
  $where = 'name ="'.trim(strip_tags($_REQUEST['name'])).'" and id !='.$_REQUEST['product_id'];
  $data = $QueryFire->getAllData('products',$where);
  if(!empty($data)) {
    $msg = 'Product already exist !';
  } else {
    $arr = array();
    $arr['slug'] = to_prety_url($_REQUEST['name']);
    $arr['name'] = trim(strip_tags($_REQUEST['name']));
    $arr['trendings'] = trim(strip_tags($_REQUEST['trendings']));
    $arr['price'] = trim(strip_tags($_REQUEST['price']));
    $arr['qty'] = trim(strip_tags($_REQUEST['qty']));
    $arr['meta_title'] = trim(strip_tags($_REQUEST['meta_title']));
    $arr['meta_description'] = trim(strip_tags($_REQUEST['meta_description']));
    $arr['param_value'] = trim(strip_tags($_REQUEST['param_value']));
    $arr['param_value_id'] = implode(',',$_REQUEST['param_value_id']);
    $arr['discount'] = trim(strip_tags($_REQUEST['discount']));
    $arr['cat_id'] = trim(strip_tags($_REQUEST['cat_id']));
    $arr['brand_id'] = trim(strip_tags($_REQUEST['brand_id']));
    $arr['is_show'] = trim(strip_tags($_REQUEST['is_show']));
    if(!empty($_REQUEST['sub_category'])) {
      $_REQUEST['sub_category'] = trim(strip_tags($_REQUEST['sub_category']));
      $arr['cat_id'] = $_REQUEST['sub_category'];
    }
    $arr['details'] = htmlentities(addslashes($_POST['details']));
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/products/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr['image_name'] = $ret['image_name'];
        $data = $QueryFire->getAllData('products','id ='.$_REQUEST['product_id']);
        unlinkImage('../images/products/'.$data[0]['image_name']);
        unset($data);
      } else {
        $msg = "Unable to upload product image";
      }
    }
    if($QueryFire->upDateTable('products',' id='.$_REQUEST['product_id'],$arr)) {
      if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
        $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/products/');
        if($ret1['status'] && isset($ret1['image_name'][0])) {
          foreach($ret1['image_name'] as $img) {
            $QueryFire->insertData('products_has_images',array('image_name'=>$img,'product_id'=>$_REQUEST['product_id']));
          }
        }
      }
      $msg = 'Product updated successfully.';
    } else {
      $msg = 'Unable to update product.';
    }
  }
}
$brands = $QueryFire->getAllData('brands',' is_show=1 order by name');
$categories = $QueryFire->getAllData('categories',' is_show=1 and level=1 and is_deleted=0 order by name');
$images = $QueryFire->getAllData('products_has_images',' product_id='.$_REQUEST['product_id']);
$params = $QueryFire->getAllData('product_has_params','is_deleted=0 order by name');
$product = $QueryFire->getAllData('products','id='.$_REQUEST['product_id'])[0];
//pr($product);die;
$product_cat = $categories[array_search($product['cat_id'], array_column($categories, 'id'))];
$main_cat = $product_cat['parent_id']==0?$product['cat_id']:$product_cat['parent_id'];
$sub_cat = $product_cat['parent_id']==0?'':$product_cat['id'];
unset($product_cat);
$param_values = $QueryFire->getAllData('product_params_values',' id in('.$product['param_value_id'].')');
$param_values = array_values(array_unique(array_column($param_values, 'param_id')));
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="products">Product Management</a></li>
            <li class="breadcrumb-item active">Edit Product</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <section class="content">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <?php echo !empty($msg)?'<h5 class="text-center text-success mt-3">'.$msg.'</h5>':''?>
          <form role="form" method="post" class="user-form" enctype="multipart/form-data">
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" value="<?= $product['name']?>" class="form-control" placeholder="Enter Product Name">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="price"> Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                      </div>
                      <input type="text" name="price" value="<?= $product['price']?>" class="form-control" placeholder="Enter Product Price">
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="text" name="qty" value="<?= $product['qty']?>" class="form-control" placeholder="Enter Product Quantity">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="discount"> Discount</label>
                    <div class="input-group">
                      <input type="text" name="discount" value="<?= $product['discount']?>" class="form-control" placeholder="Enter Discount" value="0">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="trendings">Show on Home</label>
                    <select class="form-control" name="trendings">
                      <option value="1" <?= $product['trendings']==1?'selected':''?>>Yes</option>
                      <option value="0" <?= $product['trendings']==0?'selected':''?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="brand_id"> Brand</label>
                    <select class="form-control brand" name="brand_id">
                      <option value=""> -- Select Brand -- </option>
                      <?php if(!empty($brands)) {
                        foreach($brands as $brand) {
                          echo '<option value="'.$brand['id'].'">'.$brand['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="cat_id"> Category</label>
                    <select class="form-control category" name="cat_id">
                      <option value=""> -- Select Category -- </option>
                      <?php if(!empty($categories)) {
                        foreach($categories as $cat) {
                          echo '<option value="'.$cat['id'].'" >'.$cat['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 sub_category hide">
                  <div class="form-group">
                    <label for="sub_category">Sub Category</label>
                    <select name="sub_category" class="form-control">
                      <option value=""> -- Select Sub Category -- </option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-12">
                  <div class="form-group">
                    <label for="param_id"> Parameter</label>
                    <select class="form-control select2bs4 param" data-placeholder="Select Parameter" multiple name="param_id[]">
                      <?php if(!empty($params)) {
                        foreach($params as $param) {
                          echo '<option value="'.$param['id'].'" '. (in_array($param['id'], $param_values)?'selected':'') .'>'.$param['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="param_id"> Select Parameter Unit</label>
                    <select class="form-control select2bs4 param_value_id" data-placeholder="Select Parameter Unit" style="width: 100%;" multiple name="param_value_id[]">
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-12">
                  <div class="form-group">
                    <label for="param_value"> Parameter Value</label>
                    <input type="text" name="param_value"  value="<?= $product['param_value']?>" placeholder="Enter param value" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="is_show">Is Show</label>
                    <select class="form-control" name="is_show">
                      <option value="1" <?= $product['is_show']==1?'selected':''?>>Yes</option>
                      <option value="0" <?= $product['is_show']==0?'selected':''?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="name">SEO - Meta Title:</label>
                    <input class="form-control" value="<?= $product['meta_title']?>" name="meta_title" placeholder="Enter Meta Title" >
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="name">SEO - Meta Description:</label>
                  <input class="form-control" name="meta_description"  value="<?= $product['meta_description']?>" placeholder="Enter Meta Description" >
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="file_upload">Change Featured Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="images">Product Images:</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" accept="image/*" name="images[]" class="custom-file-input" multiple id="exampleInputFile1">
                        <label class="custom-file-label" for="exampleInputFile1">Choose files</label>
                      </div>
                    </div>
                    <small class="text-danger">You can upload multiple Images by pressing 'CTRL' button & selecting the desired images</small>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="details"  placeholder="Enter Product Description" rows="6" class="form-control summernote"><?= html_entity_decode($product['details'])?></textarea>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <?php  if(!empty($images)){?>
                  <label>Product Images:</label><br>
                  <div class="row">
                    <?php
                    foreach($images as $img){?>
                      <div class="col-md-2 col-xs-3">
                        <img src="../images/products/<?= $img['image_name']?>" class="img-responsive img-thumbnail" style="margin-bottom: 10px;">
                        <button class="btn btn-danger btn-xs  remove" type="button" data-id="<?= $img['image_name']?>">Delete </button>
                      </div>
                    <?php } ?>
                  </div>
                  <br>
                  <?php } ?>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!-- Change/Remove Image Modal -->
  <div id="editHomeSlider" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title m_name">Delete Product Image</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to delete this image?</p>
      <form method="post" action="" class="imgs" enctype="multipart/form-data">
        <input type="hidden" name="image_name" class="img_nm">
        <input type="hidden" name="act" class="act">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" name="updateHomeSlider" >Yes</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".select2bs4").select2({
        theme: "bootstrap4"
      });
      $(".remove").on("click",function(){
        $(".img_nm").val($(this).data("id"));
        $(".act").val("remove");
        $("#editHomeSlider").modal("show");
      });
      //$(".select2bs4").val(null).trigger("change");
      var v1 = "1";
      $(".param").on("change",function(){
        //$(".select2bs4").empty();
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getparamvalues",id:$(this).val(),selected:"'.$product['param_value_id'].'"},
          success:function(response){
            $(".param_value_id").empty();
            response = $.parseJSON(response);
            response = $.makeArray( response );
            if(response !="") {
              $(".param_value_id").select2({
                theme: "bootstrap4",
                placeholder: "Select Parameter Unit",
                data: response
              });
              if(v1=="")
                $(".param_value_id").val(null).trigger("change");
            }
          }
        });
      });
      $(".param").trigger("change");
      var sub_category="'.$sub_cat.'";
      $(".category").on("change",function(){
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getsubcat",id:$(this).val()},
          success:function(response){
            if(response !="") {
              $(".sub_category").removeClass("hide");
              $(".sub_category select").html(response);
              if(sub_category!="") {
                $(".sub_category select").val('.$sub_cat.');
                sub_category="";
              }
            } else {
              $(".sub_category").addClass("hide");
            }
          }
        });
      });
      $(".category").val('.$main_cat.').trigger("change");
      $(".summernote").summernote({
        height: 250,
        fontNames: ["Arial", "Arial Black", "Comic Sans MS", "Courier New","Times New Roman","Century","Verdana","Vrinda","Candara","Tahoma","Georgia","Impact","Helvetica","Neutra Text TF","Lucida Console"],
        fontSizes: ["8","9","10","11","12","14","16","18", "20", "24", "36","60","72"],
        toolbar:[
           ["style", ["bold", "italic", "underline", "clear"]],
           ["font", ["strikethrough","superscript", "subscript"]],
           ["fontsize", ["fontsize"]],
           ["fontname", ["fontname"]],
           ["color", ["color"]],
           ["para", ["ul", "ol", "paragraph"]],
           ["height", ["height"]],
           ["table", ["table"]],
           ["insert", ["link", "picture", "hr","video"]],
           ["view", ["fullscreen", "codeview"]],
           ["help", ["help"]],
        ],
      });
      $(".user-form").validate({
        rules: {
          name: {
            required: true,
            minlength: 3
          },
          qty: {
            required: true,
            min: 1,
            number:true
          },
          cat_id: {
            required: true,
          },
          brand_id: {
            required: true,
          },
          "param_id[]": {
            required: true,
          },
          param_value_id: {
            required: true,
          },
          sub_category: {
            required: true,
          },
          price: {
            required: true,
            min: 1,
            number:true
          },
        },
        messages: {
          name: {
            required: "Enter product name",
            minlength: "Enter product name more than 3 characters",
          },
          qty: {
            required: "Enter product quantity",
            min: "Enter valid product quantity",
            number:"Enter valid product quantity"
          },
          "param_id[]": {
            required: "Select Parameter",
          },
          param_value_id: {
            required: "Select Parameter Value",
          },
          cat_id: {
            required: "Select Category",
          },
          brand_id: {
            required: "Select Brand",
          },
          sub_category: {
            required: "Select Sub Category",
          },
          price: {
            required: "Enter product price",
            min: "Enter valid product price",
            number:"Enter valid product price"
          },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
          error.addClass("invalid-feedback");
          element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass("is-invalid");
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass("is-invalid");
        }
      });
    });
  </script>';
require_once('templates/footer.php');?>