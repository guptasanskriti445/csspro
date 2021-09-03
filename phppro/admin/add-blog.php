<?php
$active_tab = 'blogs';
$active_sub_tab = 'blogs';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['submit'])) {
  $_REQUEST['slug'] = to_prety_url($_REQUEST['slug']);
  $where = 'slug ="'.$_REQUEST['slug'].'"';
  $data = $QueryFire->getAllData('blogs',$where);
  if(!empty($data)) {
    $msg = 'URL already exist !';
  } else {
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/blogs/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr = array();
        $arr['slug'] = $_REQUEST['slug'];
        $arr['title'] = trim(strip_tags($_REQUEST['name']));
        $arr['trendings'] = trim(strip_tags($_REQUEST['trendings']));
        $arr['meta_title'] = trim(strip_tags($_REQUEST['meta_title']));
        $arr['meta_description'] = trim(strip_tags($_REQUEST['meta_description']));
        $arr['cat_id'] = trim(strip_tags($_REQUEST['cat_id']));
        $arr['is_show'] = trim(strip_tags($_REQUEST['is_show']));
        $arr['image_name'] = $ret['image_name'];
        $arr['details'] = htmlentities(addslashes($_POST['details']));
        if($QueryFire->insertData('blogs',$arr)) {
          $last_id = $QueryFire->getLastInsertId();
          if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
            $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/blogs/');
            if($ret1['status'] && isset($ret1['image_name'][0])) {
              foreach($ret1['image_name'] as $img) {
                $QueryFire->insertData('blog_has_images',array('image_name'=>$img,'blog_id'=>$last_id));
              }
            }
          }
          $msg = 'Blog added successfully.';
        } else {
          $msg = 'Unable to add blog.';
        }
      } else {
        $msg = "Unable to upload blog image";
      }
    }
  }
}
$categories = $QueryFire->getAllData('blog_categories',' is_show=1 and level=1 and is_deleted=0 order by name');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add New Blog</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="blogs">Blogs</a></li>
            <li class="breadcrumb-item active">Add Blog</li>
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
                <div class="col-sm-8 col-md-8 col-xs-12">
                  <div class="form-group">
                    <label for="name">Title</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Title">
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
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="is_show">Is Show</label>
                    <select class="form-control" name="is_show">
                      <option value="1">Yes</option>
                      <option value="0">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-6">
                  <div class="form-group">
                    <label for="price"> URL</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><?= base_url?>blog/</span>
                      </div>
                      <input type="text" name="slug" class="form-control" placeholder="Enter url">
                    </div>
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
                <div class="col-sm-6 col-md-6 col-xs-12">
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
                <div class="col-sm-6 col-md-6 col-xs-12">
                  <div class="form-group">
                    <label for="images">Blog Images:</label>
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
                    <textarea name="details"  placeholder="Enter Description" rows="6" class="form-control summernote"></textarea>
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
          cat_id: {
            required: true,
          },
          slug: {
            required: true,
            minlength: 3
          },
          file_upload: {
            required: true
          }
        },
        messages: {
          name: {
            required: "Enter title",
            minlength: "Enter title more than 3 characters",
          },
          cat_id: {
            required: "Select Category",
          },
          slug: {
            required: "Enter url without spaces and special characters",
            minlength: "Enter url more than 3 characters",
          },
          file_upload: {
            required: "Upload fetaured image"
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
