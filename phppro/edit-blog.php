<?php
$active_tab = $active_sub_tab = 'blogs';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['act']))
{
  if($_POST['act']=='remove') {
    if($QueryFire->deleteDataFromTable('blog_has_images','image_name="'.$_POST['image_name'].'"'))
    {
      unlinkImage('../images/blogs/'.$_POST['image_name']);
      $msg = "Image deleted";
    }
    else
      $msg = 'Sorry! unable to delete image';
  }
}
if(isset($_POST['submit'])) {
  $_REQUEST['slug'] = to_prety_url($_REQUEST['slug']);
  $where = 'slug ="'.$_REQUEST['slug'].'" and id !='.$_REQUEST['blog_id'];
  $data = $QueryFire->getAllData('blogs',$where);
  if(!empty($data)) {
    $msg = 'Link already exists';
  } else {
    $arr = array();
    $arr['slug'] = $_REQUEST['slug'];
    $arr['title'] = trim(strip_tags($_REQUEST['name']));
    $arr['trendings'] = trim(strip_tags($_REQUEST['trendings']));
    $arr['meta_title'] = trim(strip_tags($_REQUEST['meta_title']));
    $arr['meta_description'] = trim(strip_tags($_REQUEST['meta_description']));
    $arr['cat_id'] = trim(strip_tags($_REQUEST['cat_id']));
    $arr['is_show'] = trim(strip_tags($_REQUEST['is_show']));
    $arr['details'] = htmlentities(addslashes($_POST['details']));
    if(isset($_FILES) && !empty($_FILES['file_upload']['tmp_name'])) {
      $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/blogs/');
      if($ret['status'] && isset($ret['image_name'])) {
        $arr['image_name'] = $ret['image_name'];
        $data = $QueryFire->getAllData('blogs','id ='.$_REQUEST['blog_id']);
        unlinkImage('../images/blogs/'.$data[0]['image_name']);
        unset($data);
      } else {
        $msg = "Unable to upload blog image";
      }
    }
    if($QueryFire->upDateTable('blogs',' id='.$_REQUEST['blog_id'],$arr)) {
      if(isset($_FILES) && !empty($_FILES['images']['tmp_name'][0])) {
        $ret1 = $QueryFire->multipleFileUpload($_FILES['images'],'../images/blogs/');
        if($ret1['status'] && isset($ret1['image_name'][0])) {
          foreach($ret1['image_name'] as $img) {
            $QueryFire->insertData('blog_has_images',array('image_name'=>$img,'blog_id'=>$_REQUEST['blog_id']));
          }
        }
      }
      $msg = 'Blog updated successfully.';
    } else {
      $msg = 'Unable to update blog.';
    }
  }
}
$categories = $QueryFire->getAllData('blog_categories',' is_show=1 and level=1 and is_deleted=0 order by name');
$images = $QueryFire->getAllData('blog_has_images',' blog_id='.$_REQUEST['blog_id']);
$blog = $QueryFire->getAllData('blogs','id='.$_REQUEST['blog_id'])[0];
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Edit Blog</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="blogs">Blogs</a></li>
            <li class="breadcrumb-item active">Edit Blog</li>
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
                    <input type="text" name="name" value="<?= $blog['title']?>" class="form-control" placeholder="Enter blog title">
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="trendings">Show on Home</label>
                    <select class="form-control" name="trendings">
                      <option value="1" <?= $blog['trendings']==1?'selected':''?>>Yes</option>
                      <option value="0" <?= $blog['trendings']==0?'selected':''?>>No</option>
                    </select>
                  </div>
                </div>
                <div class="col-sm-2 col-md-2 col-xs-6">
                  <div class="form-group">
                    <label for="is_show">Is Show</label>
                    <select class="form-control" name="is_show">
                      <option value="1" <?= $blog['is_show']==1?'selected':''?>>Yes</option>
                      <option value="0" <?= $blog['is_show']==0?'selected':''?>>No</option>
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
                      <input type="text" name="slug" value="<?= $blog['slug']?>" class="form-control" placeholder="Enter url">
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
                          echo '<option value="'.$cat['id'].'" '. ($cat['id']==$blog['cat_id']?'selected':'') .'>'.$cat['name'].'</option>';
                        }
                      } ?>
                    </select>
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <div class="form-group">
                    <label for="name">SEO - Meta Title:</label>
                    <input class="form-control" value="<?= $blog['meta_title']?>" name="meta_title" placeholder="Enter Meta Title" >
                  </div>
                </div>
                <div class="col-sm-4 col-md-4 col-xs-12">
                  <label for="name">SEO - Meta Description:</label>
                  <input class="form-control" name="meta_description"  value="<?= $blog['meta_description']?>" placeholder="Enter Meta Description" >
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                  <div class="row">
                    <div class="col-md-12 col-xs-12 col-xs-12">
                      <div class="row">
                        <div class="col-sm-6 col-md-6 col-xs-12">
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
                      </div>
                    </div>
                    <!-- <div class="col-md-2 col-xs-2 col-xs-12">
                      <img src="../images/blogs/<?= $blog['image_name']?>" class="img-responsive img-thumbnail" alt="Featured image" />
                    </div> -->
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <div class="form-group">
                    <label for="">Description</label>
                    <textarea name="details"  placeholder="Enter Description" rows="6" class="form-control summernote"><?= html_entity_decode($blog['details'])?></textarea>
                  </div>
                </div>
                <div class="col-sm-12 col-md-12 col-xs-12">
                  <?php  if(!empty($images)){?>
                  <label>Blog Images:</label><br>
                  <div class="row">
                    <?php
                    foreach($images as $img){?>
                      <div class="col-md-2 col-xs-3">
                        <img src="../images/blogs/<?= $img['image_name']?>" class="img-responsive img-thumbnail" style="margin-bottom: 10px;">
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
          <h4 class="modal-title m_name">Delete Image</h4>
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
      $(".remove").on("click",function(){
        $(".img_nm").val($(this).data("id"));
        $(".act").val("remove");
        $("#editHomeSlider").modal("show");
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
          slug: {
            required: true,
            minlength: 3
          },
          cat_id: {
            required: true,
          },
        },
        messages: {
          name: {
            required: "Enter blog title",
            minlength: "Enter blog title more than 3 characters",
          },
          slug: {
            required: "Enter url without spaces and special characters",
            minlength: "Enter url more than 3 characters",
          },
          cat_id: {
            required: "Select Category",
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