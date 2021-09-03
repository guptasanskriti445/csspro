<?php
$active_tab = "blogs";
$active_sub_tab = 'comments';
$jscss='both';
require_once('templates/header.php');
require_once('templates/sidebar.php');
if(!empty($_POST['user_action'])) {
  switch($_POST['user_action']) {
    case 'approve':
        $QueryFire->upDateTable("blog_comments",' id='.$_POST['id'],array('is_approved'=>1));
          $msg = 'Comment is approved successfully.';
        break;
    case 'delete':
        $QueryFire->deleteDataFromTable("blog_comments",' id='.$_POST['id']);
        $msg = 'Comment deleted successfully.';
        break;
  }
}
$data = $QueryFire->getAllData('','','SELECT b.title as blog, c.*,u.name as user FROM blog_comments as c LEFT JOIN blogs as b ON b.id=c.blog_id LEFT JOIN users as u ON u.id=c.user_id ORDER BY c.id desc');
?>
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blog Commments</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
            <li class="breadcrumb-item"><a href="blogs">Blogs</a></li>
            <li class="breadcrumb-item active">Comments</li>
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
            <table class="data-table table table-bordered table-striped table-bordered table-hover dt-responsive nowrap">
              <thead>
                <tr>
                  <th>Sr No</th>
                  <th>Blog</th>
                  <th>User</th>
                  <th>Review</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php if(!empty($data)) { $cnt=1;
                  foreach($data as $row) { ?>
                  <tr>
                    <td><?php echo $cnt++;?></td>
                    <td><?php echo $row['blog'];?></td>
                    <td><?php echo $row['user'];?></td>
                    <td><?php echo $row['comment'];?></td>
                    <td>
                      <?php if($row['is_approved']){?>
                        <button class="btn btn-success disabled btn-xs mt-1">Approved</button>
                      <?php } else { ?>
                        <a class="btn btn-success btn-xs" data-toggle="modal" data-target="#approveModal" data-id="<?php echo $row['id'];?>"> Approve?</a> 
                      <?php } ?>
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
            <h5 class="modal-title" id="deleteModalLabel">Are you sure you want to delete this Comment</h5>
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
  <div class="modal fade" data-backdrop="static"  id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <form method="post">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="approveModalLabel">Are you sure you want to approve this Comment</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <input type="hidden" name="id" />
          <div class="modal-footer">
            <button type="button" class="btn btn-default rounded-0" data-dismiss="modal">Close</button>
            <button type="submit" name="user_action" value="approve" class="btn btn-outline-danger rounded-0">Yes, Approve</button>
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
      $("#approveModal").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data("id");
        var modal = $(this);
        modal.find(".modal-content input").val(recipient);
      });
    });
  </script>';
require_once('templates/footer.php');?>