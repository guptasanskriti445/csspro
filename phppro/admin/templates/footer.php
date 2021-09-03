		</div>
		<footer class="main-footer">
		    <div class="float-right d-none d-sm-block">
		      <b>Version</b> 1
		    </div>
		    <strong>Copyright &copy; <?= date('Y')?> <a href="#">Sakshi</a>.</strong> All rights reserved.
		</footer>
	</div>
	<script src="<?= base_url?>plugins/jquery/jquery.min.js"></script>
	<script src="<?= base_url?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?= base_url?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<?php if(isset($jscss) && in_array($jscss, $loadJSCSS)) { if($jscss=='both' || $jscss=='form') { ?>
	<!-- Select2 -->
	<script src="<?= base_url?>plugins/select2/js/select2.full.min.js"></script>
	<!-- Bootstrap4 Duallistbox -->
	<script src="<?= base_url?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
	<!-- InputMask -->
	<script src="<?= base_url?>plugins/moment/moment.min.js"></script>
	<script src="<?= base_url?>plugins/inputmask/jquery.inputmask.min.js"></script>
	<!-- date-range-picker -->
	<script src="<?= base_url?>plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?= base_url?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Bootstrap Switch -->
	<script src="<?= base_url?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
	<!-- BS-Stepper -->
	<script src="<?= base_url?>plugins/bs-stepper/js/bs-stepper.min.js"></script>
	<!-- dropzonejs -->
	<script src="<?= base_url?>plugins/dropzone/min/dropzone.min.js"></script>
	<script src="<?= base_url?>plugins/summernote/summernote-bs4.min.js"></script>
	<script src="<?= base_url?>plugins/jquery-validation/jquery.validate.min.js"></script>
	<script src="<?= base_url?>plugins/jquery-validation/additional-methods.min.js"></script>
	<script type="text/javascript">
		$(function(){
			if($('.summernote').length) {
				$(".summernote").summernote({
				  height:"250",
				  fontNames: ["Arial", "Arial Black", "Comic Sans MS", "Courier New","Times New Roman","Century","Verdana","Vrinda","Candara","Tahoma","Georgia","Impact","Helvetica","Neutra Text TF","Lucida Console"],
				  fontNamesIgnoreCheck: ['Segoe UI'],
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
				     ["view", ["fullscreen"]],
				     /*["help", ["help"]],*/
				  ],
				});
				if($(".note-editable").html() == "<p><br></p>") {
					$(".note-editable").html($(".note-editable").html().replace("<p><br></p>",""));
				}
			}
		})
	</script>
<?php } if ($jscss=='datatable' || $jscss=='both' ) { ?>
	<!-- DataTables  & Plugins -->
	<script src="<?= base_url?>plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
	<script src="<?= base_url?>plugins/jszip/jszip.min.js"></script>
	<script src="<?= base_url?>plugins/pdfmake/pdfmake.min.js"></script>
	<script src="<?= base_url?>plugins/pdfmake/vfs_fonts.js"></script>
	<script src="<?= base_url?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
	<script src="<?= base_url?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<?php } } ?>
	<script src="<?= base_url?>dist/js/adminlte.min.js"></script>
	<script src="<?= base_url?>dist/js/demo.js"></script>
	<?= isset($appendScript)?$appendScript:""?>
</body>
</html>