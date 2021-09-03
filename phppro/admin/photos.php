<?php
$active_tab = 'photos';
$prependScript ='<style>
  .img-thumbnail {
    max-height:150px;
    max-width:180px;
  }
</style>';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(isset($_POST['addHomeSlider'])) {
  if(isset($_FILES) && !empty($_FILES)) {
    $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/photos/');
    if($ret['status'] && isset($ret['image_name'])) {
      $arr = array();
      $arr['description'] = strip_tags(trim($_REQUEST['description']));
      $arr['type'] = strip_tags(trim($_REQUEST['type']));
      $arr['alt'] = strip_tags(trim($_REQUEST['heading']));
      $arr['image_name'] = $ret['image_name'];
      if($QueryFire->insertData('images',$arr)) {
        $msg = 'Photo added successfully';
      } else {
        $msg = "Unable to add photo";
      }
    } else {
      $msg = 'Unable to upload file. Please try later.';
    }
  }
}

if(isset($_POST['updateHomeSlider'])) {
  $arr = array();
  $arr['description'] = strip_tags(trim($_REQUEST['description']));
  $arr['alt'] = strip_tags(trim($_REQUEST['heading']));
  $arr['type'] = strip_tags(trim($_REQUEST['type']));
  $ret = $QueryFire->fileUpload($_FILES['file_upload'],'../images/photos/');
  if($ret['status'] && isset($ret['image_name'])) {
    $arr['image_name'] = $ret['image_name'];
    $duplicate = $QueryFire->getAllData('images',' id ='.$_REQUEST['id']);
    unlinkImage('../images/photos/'.$duplicate[0]['image_name']);
  } else {
    $msg = 'Unable to upload file. Please try later.';
  }
  if($QueryFire->upDateTable("images",'id ='.$_REQUEST['id'],$arr)) {
    $msg = 'Photo successfully updated.';
  } else {
    $msg = 'Can not update photo.';
  }
}

if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'delete':
        $duplicate = $QueryFire->getAllData('images',' id ='.$_REQUEST['id']);
        unlinkImage('../images/photos/'.$duplicate[0]['image_name']);
        $QueryFire->deleteDataFromTable("images",' id='.$_POST['id']);
        $msg = 'Photo deleted successfully.';
        break;
  }
}
$sliders = $QueryFire->getAllData('images',' 1 order by id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Photos <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Photo</button></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item active">Photos</li>
          </ol>
        </div>
      </div>
    </div>
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
                  <th>Image</th>
                  <th>ALT</th>
                  <th>Description</th>
                  <th>Page</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($sliders)) {
                  foreach($sliders as $row) { ?>
                  <tr>
                    <td class="cat">
                      <img src="../images/photos/<?php echo $row['image_name'];?>" class="img-responsive img-thumbnail">
                    </td>
                    <td class="heading"><?php echo $row['alt'];?></td>
                    <td class="description"><?php echo $row['description'];?></td>
                    <td class="type"><?php echo ucfirst($row['type']);?></td>
                    <td>
                      <button class="btn btn-success btn-xs edit_slider mt-1" data-id="<?php echo $row['id'];?>">Edit</button>
                      <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteModal" data-id="<?php echo $row['id'];?>"> Delete</a>  </td>
                  </tr>
                <?php } } else {
                  echo '<td colspan="5" class="text-center">You have not added any photo</td>';
                } ?>
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
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Photo</h5>
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
  <!-- Add Modal -->
  <div id="myModal" class="modal fade in" role="dialog">
    <form id="addGal" method="post" action="" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Add New Photo</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="heading">ALT:</label>
              <input type="text" name="heading" class="form-control" />
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" name="description" class="form-control" />
            </div>
            <div class="form-group">
              <label for="type">Select Page:</label>
              <select class="form-control" name="type">
                <option value="about us">About Us</option>
                <option value="instagram">Instagram</option>
              </select>
            </div>
            <div class="form-group">
              <label for="file_upload">Images:</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
              </div>
            </div>
            <div id="clear"></div>
            <div id="preview">
              <span class="pre">IMAGE PREVIEW</span><br>
              <img id="previewimg" src="" style="max-width:200px;height: 100px">      
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="addHomeSlider" >Add</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- Edit Modal -->
  <div id="editHomeSlider" class="modal fade" role="dialog">
    <form method="post" action="" id="editGalImg" enctype="multipart/form-data">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Edit Photo</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="heading">ALT:</label>
              <input type="text" name="heading" class="form-control headingT" />
            </div>
            <div class="form-group">
              <label for="description">Description:</label>
              <input type="text" name="description" class="form-control descriptionT" />
            </div>
            <div class="form-group">
              <label for="type">Select Page:</label>
              <select class="form-control typeT" name="type">
                <option value="about us">About Us</option>
                <option value="instagram">Instagram</option>
              </select>
            </div>
            <div class="form-group" id="formdiv">
              <div class="row">
                <div class="col-xs-12 col-lg-5 col-md-5 col-sm-5">
                  <label>Current Picture</label>
                  <img src="" class="img_show img-thumbnail img-responsive" />
                </div>
                <div class="col-xs-12 col-md-7 col-lg-7 col-sm-7">
                  <div class="form-group">
                    <label>Change Picture:</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" id="file" name="file_upload" accept="image/*" class="custom-file-input" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>   
            <input type="hidden" name="id" class="idCls">
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="updateHomeSlider" >Update</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
<?php 
$appendScript = '
  <script>
    $(document).ready(function() {
      jQuery("#addGal").validate({
        rules: {
          file_upload: "required",
        },
        messages: {
          file_upload: "Upload an image ",
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
      $(document).on("click",".edit_slider",function(){
        $(".img_show").attr("src",$(this).parents("tr").find(".img-thumbnail").attr("src"));
        $(".descriptionT").val($(this).parents("tr").find(".description").html().trim());
        $(".headingT").val($(this).parents("tr").find(".heading").html().trim());
        $(".typeT").val($(this).parents("tr").find(".type").html().trim().toLowerCase());
        $(".idCls").val($(this).data("id"));
        $("#editHomeSlider").modal("show");
      });
      $("#deleteModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
      $(":file").change(function() {
        if (this.files && this.files[0]) {
          var reader = new FileReader();
          reader.onload = imageIsLoaded;
          reader.readAsDataURL(this.files[0]);
        }
      });
      $("#preview").css("display", "none");
      function imageIsLoaded(e) {
        $("#message").css("display", "none");
        $("#preview").css("display", "block");
        $("#previewimg").attr("src", e.target.result);
        $(".img_show").attr("src", e.target.result);
      }
    });
  </script>';
require_once('templates/footer.php');?>