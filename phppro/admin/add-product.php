<?php
$active_tab = 'products';
$active_sub_tab = 'products';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['submit'])) {
  $where = 'name ="'.trim(strip_tags($_REQUEST['name'])).'"';
  $data = $QueryFire->getAllData('products',$where);
  if(!empty($data)) {
    $msg = 'Product already exist !';
  } else {
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/products/');
      if($ret['status'] && isset($ret['image_name'])) {
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
        $_REQUEST['sub_category'] = trim(strip_tags($_REQUEST['sub_category']));
        if(!empty($_REQUEST['sub_category'])) {
          $arr['cat_id'] = $_REQUEST['sub_category'];
        }
        $arr['image_name'] = $ret['image_name'];
        $arr['details'] = htmlentities(addslashes($_POST['details']));
        //pr($arr);die;
        if($QueryFire->insertData('products',$arr)) {
          //get last id
          $last_id = $QueryFire->getLastInsertId();
          //now insert images into db
          if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
            $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/products/');
            if($ret1['status'] && isset($ret1['image_name'][0])) {
              foreach($ret1['image_name'] as $img) {
                $QueryFire->insertData('products_has_images',array('image_name'=>$img,'product_id'=>$last_id));
              }
            }
          }
          $msg = 'Product added successfully.';
        } else {
          $msg = 'Unable to add product.';
        }
      } else {
        $msg = "Unable to upload product image";
      }
    }
  }
}
$brands = $QueryFire->getAllData('brands',' is_show=1 order by name');
$categories = $QueryFire->getAllData('categories',' is_show=1 and level=1 and is_deleted=0 order by name');
$params = $QueryFire->getAllData('product_has_params','is_deleted=0 order by name');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New Product</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="products">Product Management</a></li>
            <li class="breadcrumb-item active">Add Product</li>
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
                    <input type="text" name="name" class="form-control" placeholder="Enter Product Name">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="price"> Price</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-rupee-sign"></i></span>
                      </div>
                      <input type="text" name="price" class="form-control" placeholder="Enter Product Price">
                    </div>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="qty">Quantity</label>
                    <input type="text" name="qty" class="form-control" placeholder="Enter Product Quantity">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="discount"> Discount</label>
                    <div class="input-group">
                      <input type="text" name="discount" class="form-control" placeholder="Enter Discount" value="0">
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
                      <option value="1">Yes</option>
                      <option value="0">No</option>
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
                          echo '<option value="'.$cat['id'].'">'.$cat['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12 sub_category hide">
                  <div class="form-group">
                    <label for="sub_category">Sub Category</label>
                    <select name="sub_category" class="form-control ">
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
                          echo '<option value="'.$param['id'].'">'.$param['name'].'</option>';
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
                    <input type="text" name="param_value" placeholder="Enter param value" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="is_show">Is Show</label>
                    <select class="form-control" name="is_show">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="name">SEO - Meta Title:</label>
                    <input class="form-control" name="meta_title" placeholder="Enter Meta Title" >
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="name">SEO - Meta Description:</label>
                  <input class="form-control" name="meta_description" placeholder="Enter Meta Description" >
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="file_upload">Featured Image</label>
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
                    <textarea name="details"  placeholder="Enter Product Description" rows="6" class="form-control summernote"></textarea>
                  </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      $(".select2bs4").select2({
        theme: "bootstrap4"
      });
      $(".param").on("change",function(){
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getparamvalues",id:$(this).val(),selected:$(".param_value_id").val().join()},
          success:function(response){
            response = $.parseJSON(response);
            response = $.makeArray( response );
            $(".param_value_id").empty();
            if(response !="") {
              //$(".param_value_id").val(null).trigger("change");
              $(".param_value_id").select2({
                theme: "bootstrap4",
                placeholder: "Select Parameter Unit",
                data: response
              });
            }
          }
        });
      });
      $(".category").on("change",function(){
        $.ajax({
          url:"query",
          method:"post",
          data:{action:"getsubcat",id:$(this).val()},
          success:function(response){
            if(response !="") {
              $(".sub_category").removeClass("hide");
              $(".sub_category select").html(response);
            } else {
              $(".sub_category").addClass("hide");
            }
          }
        });
      });
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
          weight: {
            required: true,
            min: 5,
            number:true
          },
          price: {
            required: true,
            min: 1,
            number:true
          },
          file_upload: {
            required: true
          }
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
          file_upload: {
            required: "Upload product image"
          }
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
