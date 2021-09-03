        <div class="hiraola-footer_area">
            <div class="footer-top_area">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="footer-widgets_info">
                                <div class="footer-widgets_logo">
                                    <a href="#">
                                        <img src="<?= base_url?>assets/images/footer/logo/logo.png" alt="Sakshi's Footer Logo">
                                    </a>
                                </div>
                                <div class="hiraola-social_link pt-0">
                                    <ul>
                                        <li class="facebook">
                                            <a href="https://www.facebook.com/" data-toggle="tooltip" target="_blank" title="Facebook">
                                                <i class="fab fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li class="twitter">
                                            <a href="https://twitter.com/" data-toggle="tooltip" target="_blank" title="Twitter">
                                                <i class="fab fa-twitter-square"></i>
                                            </a>
                                        </li>
                                        <li class="instagram">
                                            <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                                <i class="fab fa-instagram"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="footer-widgets_area">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="footer-widgets_title">
                                            <h6>User Links</h6>
                                        </div>
                                        <div class="footer-widgets">
                                            <ul>
                                                <li><a href="<?= base_url?>products">Products</a></li>
                                                <li><a href="<?= base_url?>wishlist">Wishlist</a></li>
                                                <li><a href="<?= base_url?>cart">Cart</a></li>
                                                <li><a href="<?= base_url?>contact">Contact us</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="footer-widgets_title">
                                        <h6>Quick Links</h6>
                                        </div>
                                        <div class="footer-widgets">
                                            <ul>
                                                <li><a href="<?= base_url?>terms-and-conditions">Terms and conditions</a></li>
                                                <li><a href="<?= base_url?>privacy-policy">Privacy Policy</a></li>
                                                <li><a href="<?= base_url?>refund-policy">Refund Policy</a></li>
                                                <li><a href="<?= base_url?>testimonials">Testimonials</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="footer-widgets_info">
                                            <div class="footer-widgets_title">
                                                <h6>Contact Us</h6>
                                            </div>
                                            <div class="widgets-essential_stuff">
                                                <ul>
                                                    <li class="hiraola-address"><i class="ion-ios-location"></i><span>Address:</span> 66/6 Soi 31 Kwang Dokmai Khet Praves Bangkok 10250</li>
                                                    <li class="hiraola-phone"><i class="ion-ios-telephone"></i><span>Call Us:</span> <a href="tel://+123123321345">+66 627526376</a>
                                                    </li>
                                                    <li class="hiraola-email"><i class="ion-android-mail"></i><span>Email:</span> <a href="mailto://tdjewelsbkk@gmail.com">tdjewelsbkk@gmail.com</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom_area">
                <div class="container">
                    <div class="footer-bottom_nav py-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="copyright pt-0">
                                    <span>Copyright &copy; <?= date("Y")?> <a href="#">Sakshi Jewellers.</a> All rights reserved.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <!-- Hiraola's Modal Area End Here -->

    </div>

    <script src="<?= base_url?>assets/js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Modernizer JS -->
    <script src="<?= base_url?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <!-- Popper JS -->
    <script src="<?= base_url?>assets/js/vendor/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="<?= base_url?>assets/js/vendor/bootstrap.min.js"></script>

    <!-- Slick Slider JS -->
    <script src="<?= base_url?>assets/js/plugins/slick.min.js"></script>
    <!-- Barrating JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery.barrating.min.js"></script>
    <!-- Counterup JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery.counterup.js"></script>
    <!-- Nice Select JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery.nice-select.js"></script>
    <!-- Sticky Sidebar JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery.sticky-sidebar.js"></script>
    <!-- Jquery-ui JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery-ui.min.js"></script>
    <script src="<?= base_url?>assets/js/plugins/jquery.ui.touch-punch.min.js"></script>
    <!-- Lightgallery JS -->
    <script src="<?= base_url?>assets/js/plugins/lightgallery.min.js"></script>
    <!-- Scroll Top JS -->
    <script src="<?= base_url?>assets/js/plugins/scroll-top.js"></script>
    <!-- Theia Sticky Sidebar JS -->
    <script src="<?= base_url?>assets/js/plugins/theia-sticky-sidebar.min.js"></script>
    <!-- Waypoints JS -->
    <script src="<?= base_url?>assets/js/plugins/waypoints.min.js"></script>
    <!-- ElevateZoom JS -->
    <script src="<?= base_url?>assets/js/plugins/jquery.elevateZoom-3.0.8.min.js"></script>
    <!-- Timecircles JS -->
    <script src="<?= base_url?>assets/js/plugins/timecircles.js"></script>
    <script src="<?= base_url?>assets/js/main.js"></script>
    <?= isset($appendScript)?$appendScript:''?>
<script type="text/javascript">
   $(function() {
      $('.btn-cart').click(function(){
          var id = $(this).data('id');
          var quantity = 1;
          var act9ve = $(this);
          var url = '<?= base_url?>addtocart';
          $.ajax({
              url:url,
              data:{action:'add',id:id,'quantity':quantity},
              type:'post',
              success:function(result){
                var s =$.parseJSON(result);
                alert(s.message);
                act9ve.attr('disabled',true);
                $('.bigcounter').html(s.count);
              },
              error:function(error){
                  console.log('Error');
              }
          });
      });
      $('.action-remove').click(function(){
          var id = $(this).data('id');
          var act9ve = $(this);
          var url = '<?= base_url?>addtocart';
          $.ajax({
              url:url,
              data:{action:'remove',id:id},
              type:'post',
              success:function(result){
                  var s =$.parseJSON(result);
                  if(s.status) {
                    alert(s.message);
                    window.location.reload();
                  }
                  $('.bigcounter').html(s.count);
              },
              error:function(error){
                  console.log('Error');
              }
          });
      });
      $('.action-remove1').click(function(){
          var id = $(this).data('id');
          var act9ve = $(this);
          var url = '<?= base_url?>addtocart';
          $.ajax({
              url:url,
              data:{action:'remove1',id:id},
              type:'post',
              success:function(result){
                  var s =$.parseJSON(result);
                  if(s.status)
                  {
                      window.location.reload();
                  }
                  $('.bigcounter').html(s.count);
              },
              error:function(error){
                  console.log('Error');
              }
          });
      });
      $('.btn-wishlist').click(function(){
          var id = $(this).data('id');
          var act9ve = $(this);
          var url = '<?= base_url?>addtocart';
          $.ajax({
              url:url,
              data:{action:'add_wish_list',id:id},
              type:'post',
              success:function(result){
                  var s =$.parseJSON(result);
                  alert(s.message);
                  act9ve.attr('disabled',true);
                  $('.counterwishlist').html(s.count);
              },
              error:function(error){
                  console.log('Error');
              }
          });
      });
      $(document).on("click",".minus,.plus",function(){
            var This = $(this).parents(".product-quantity").find(".input-qty1");
            if($(This).text()> 0 ) {
                $(This).trigger("change");
                var id = $(This).data("id");
                var quantity = $(This).text();
                if($(this).hasClass("minus")) {
                    quantity--;
                } else {
                    quantity++;
                }
                var url = "<?= base_url?>addtocart";
                $.ajax({
                    url:url,
                    data:{id:id,action:"quantity",quantity:quantity},
                    type:"post",
                    success:function(result){
                      var s =$.parseJSON(result);
                      $(".bigcounter").html(s.count);
                      $(This).text(quantity).trigger("change");
                    },
                    error:function(error){
                      console.log("Error occured");
                    }
                });
            }
        });
          $(document).on("click",".minusm,.plusm",function(){
            var This = $(this).parents(".product-quantitym").find(".input-qty1m");
            if($(This).text()> 0 ) {
                $(This).trigger("change");
                var id = $(This).data("id");
                var quantity = $(This).text();
                if($(this).hasClass("minusm")) {
                    quantity--;
                } else {
                    quantity++;
                }
                var url = "<?= base_url?>addtocart";
                $.ajax({
                    url:url,
                    data:{id:id,action:"quantity",quantity:quantity},
                    type:"post",
                    success:function(result){
                      var s =$.parseJSON(result);
                      $(".bigcounterm").html(s.count);
                      $(This).text(quantity).trigger("change");
                    },
                    error:function(error){
                      console.log("Error occured");
                    }
                });
            }
        });
   });
</script>
</body>
</html>