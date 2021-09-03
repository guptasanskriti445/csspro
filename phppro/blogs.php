<?php
$active_tab="blogs";
require_once("header.php");
require_once("menu.php");
$blog_categories = $QueryFire->getAllData('blog_categories',' is_show=1 and is_deleted=0 and parent_id=0');
$where = ' 1 ';
$ajaxWhere = '';
if(isset($_POST['search_blog'])) {
    $where .= ' and title like "%'.trim($_POST['search_blog']).'%" OR details like "%'.trim($_POST['search_blog']).'%"';
    $ajaxWhere .= ' and title like "%'.trim($_POST['search_blog']).'%" OR details like "%'.trim($_POST['search_blog']).'%"';
}
if(isset($_REQUEST['bcslug'])) {
    $cat_id = $blog_categories[array_search($_REQUEST['bcslug'], array_column($blog_categories, 'slug') )]['id'];
    $ajaxWhere .= ' and cat_id="'.$cat_id.'"';
    $where .= ' and cat_id="'.$cat_id.'"';
}
$where .= ' ORDER BY id LIMIT 10';
$blogs = $QueryFire->getAllData('blogs',$where);
$recentposts = $QueryFire->getAllData('blogs',' 1 order by id desc limit 10');
?>
   <!-- Begin Hiraola's Breadcrumb Area -->
   <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Blogs</h2>
                    <ul>
                        <li><a href="<?= base_url?>">Home</a></li>
                        <li class="active">Blogs</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->

        <!-- Begin Hiraola's Blog Left Sidebar Area -->
        <div  id="blog" class="hiraola-blog_area hiraola-blog_area-2 blog-grid-view_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-lg-1 order-2">
                        <div class="hiraola-blog-sidebar-wrapper">
                            <div class="hiraola-blog-sidebar widget-search">
                                <div class="hiraola-sidebar-search-form widget--content">
                                    <form  class="form-search" method="post" action="">
                                        <input type="text" name="search_blog" class="hiraola-search-field" placeholder="search here">
                                        <button type="submit" class="hiraola-search-btn"><i class="fa fa-search"></i></button>
                                    </form>
                                </div>
                            </div>
                            <?php if(!empty($blog_categories)) { ?>
                                <div class="hiraola-blog-sidebar ">
                                    <h4 class="hiraola-blog-sidebar-title">Categories</h4>
                                    <ul class="hiraola-blog-archive">
                                        <?php foreach($blog_categories as $bcat) { ?>
                                            <li><a href="<?= base_url.'blogs/category/'.$bcat['slug']?>"><?= $bcat['name']?></a></li>
                                            <!-- <li><a href="javascript:void(0)">Earrings (12)</a></li>
                                            <li><a href="javascript:void(0)">Bracelet (05)</a></li>
                                            <li><a href="javascript:void(0)">Anklet (18)</a></li>
                                            <li><a href="javascript:void(0)">Braid Jewels (13)</a></li>
                                            <li><a href="javascript:void(0)">Foot Harness (06)</a></li> -->
                                        <?php } ?>    
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="hiraola-blog-sidebar">
                                <h4 class="hiraola-blog-sidebar-title">Blog Archives</h4>
                                <ul class="hiraola-blog-archive">
                                    <li><a href="javascript:void(0)">April (05)</a></li>
                                    <li><a href="javascript:void(0)">May (10)</a></li>
                                    <li><a href="javascript:void(0)">June (15)</a></li>
                                    <li><a href="javascript:void(0)">July (20)</a></li>
                                    <li><a href="javascript:void(0)">August(25)</a></li>
                                    <li><a href="javascript:void(0)">September (30)</a></li>
                                </ul>
                            </div>
                            <?php if(!empty($recentposts)) { ?>
                                <div class="hiraola-blog-sidebar">
                                    <h4 class="hiraola-blog-sidebar-title">Recent Post</h4>
                                    <?php foreach($recentposts as $recent) { ?>
                                        <div class="hiraola-recent-post">
                                            <div class="hiraola-recent-post-thumb">
                                                <a href="<?= base_url.'blog/'.$recent['slug']?>">
                                                    <img class="img-full" src="<?= base_url.'images/blogs/'.$recent['image_name']?>" alt="<?= $blog['title']?>">
                                                </a>
                                            </div>
                                            <div class="hiraola-recent-post-des">
                                                <span><a href="<?= base_url.'blog/'.$recent['slug']?>"><?= $recent['title']?></a></span>
                                                <span class="hiraola-post-date"><?= date('d-m-Y',strtotime($recent['date']))?></span>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <!-- <div class="hiraola-recent-post">
                                        <div class="hiraola-recent-post-thumb">
                                            <a href="single-blog.php">
                                                <img class="img-full" src="assets/images/product/small-size/2-2.jpg" alt="Hiraola's Product Image">
                                            </a>
                                        </div>
                                        <div class="hiraola-recent-post-des">
                                            <span><a href="single-blog.php">Second Blog Post</a></span>
                                            <span class="hiraola-post-date">28-05-19</span>
                                        </div>
                                    </div>
                                    <div class="hiraola-recent-post">
                                        <div class="hiraola-recent-post-thumb">
                                            <a href="single-blog.php">
                                                <img class="img-full" src="assets/images/product/small-size/2-3.jpg" alt="Hiraola's Product Image">
                                            </a>
                                        </div>
                                        <div class="hiraola-recent-post-des">
                                            <span><a href="single-blog.php">Third Blog Post</a></span>
                                            <span class="hiraola-post-date">28-05-19</span>
                                        </div>
                                    </div> -->
                                </div>
                            <?php } ?>
                            <div class="hiraola-blog-sidebar">
                                <h4 class="hiraola-blog-sidebar-title">Tags</h4>
                                <ul class="hiraola-blog-tags">
                                    <li><a href="javascript:void(0)">Rings</a></li>
                                    <li><a href="javascript:void(0)">Necklaces</a></li>
                                    <li><a href="javascript:void(0)">Bracelet</a></li>
                                    <li><a href="javascript:void(0)">Earrings</a></li>
                                    <li><a href="javascript:void(0)">Necklaces</a></li>
                                    <li><a href="javascript:void(0)">Braid</a></li>
                                    <li><a href="javascript:void(0)">Harness</a></li>
                                    <li><a href="javascript:void(0)">Graceful Armlet</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 order-lg-2 order-1">
                        <?php if(!empty($blogs)) { ?>
                            <div class="row blog-item_wrap">
                                <?php foreach($blogs as $blog) { ?>
                                    <div class="col-lg-6">
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="<?= base_url.'blog/'.$blog['slug']?>">
                                                    <img src="<?= base_url.'images/blogs/'.$blog['image_name']?>" alt="<?= $blog['title']?>">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day"><?= date('d-m-Y',strtotime($blog['date']))?></span>
                                                        <!-- <span class="month">April</span> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="<?= base_url.'blog/'.$blog['slug']?>"><?= $blog['title']?></a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="<?= base_url.'blog/'.$blog['slug']?>" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!-- <div class="col-lg-6">
                                    <div class="hiraola-single-blog_slider">
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/3.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">25</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog First Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/2.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">12</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Ht wisi enim ad minim veniam..</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/1.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">12</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog Second Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/4.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">15</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog Third Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/2.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">15</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog Fourth Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/3.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">15</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog Five Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-item">
                                            <div class="blog-img img-hover_effect">
                                                <a href="single-blog.php">
                                                    <img src="assets/images/blog/medium-size/4.jpg" alt="Hiraola's Blog Image">
                                                </a>
                                                <div class="blog-meta-2">
                                                    <div class="blog-time_schedule">
                                                        <span class="day">15</span>
                                                        <span class="month">April</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="blog-content">
                                                <div class="blog-heading">
                                                    <h5>
                                                        <a href="single-blog.php">Blog Six Gallery Post</a>
                                                    </h5>
                                                </div>
                                                <div class="blog-short_desc">
                                                    <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                        lacus
                                                        eget est d...
                                                    </p>
                                                </div>
                                                <div class="hiraola-read-more_area">
                                                    <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog-item">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/342419243&amp;color=%23ff5500&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;show_teaser=true&amp;visual=true"></iframe>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-heading">
                                                <h5>
                                                    <a href="single-blog.php">Blog Audio Post</a>
                                                </h5>
                                            </div>
                                            <div class="blog-short_desc">
                                                <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                    lacus
                                                    eget est d...
                                                </p>
                                            </div>
                                            <div class="hiraola-read-more_area">
                                                <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog-item">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe src="https://www.youtube.com/embed/gvPetTPFsZM" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-heading">
                                                <h5>
                                                    <a href="single-blog.php">Blog Video Post</a>
                                                </h5>
                                            </div>
                                            <div class="blog-short_desc">
                                                <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                    lacus
                                                    eget est d...
                                                </p>
                                            </div>
                                            <div class="hiraola-read-more_area">
                                                <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog-item">
                                        <div class="blog-img img-hover_effect">
                                            <a href="single-blog.php">
                                                <img src="assets/images/blog/medium-size/1.jpg" alt="Hiraola's Blog Image">
                                            </a>
                                            <div class="blog-meta-2">
                                                <div class="blog-time_schedule">
                                                    <span class="day">25</span>
                                                    <span class="month">April</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-heading">
                                                <h5>
                                                    <a href="single-blog.php">Gt wisi enim ad minim veniam.</a>
                                                </h5>
                                            </div>
                                            <div class="blog-short_desc">
                                                <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                    lacus
                                                    eget est d...
                                                </p>
                                            </div>
                                            <div class="hiraola-read-more_area">
                                                <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="blog-item">
                                        <div class="blog-img img-hover_effect">
                                            <a href="single-blog.php">
                                                <img src="assets/images/blog/medium-size/2.jpg" alt="Hiraola's Blog Image">
                                            </a>
                                            <div class="blog-meta-2">
                                                <div class="blog-time_schedule">
                                                    <span class="day">25</span>
                                                    <span class="month">April</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="blog-content">
                                            <div class="blog-heading">
                                                <h5>
                                                    <a href="single-blog.php">Ht wisi enim ad minim veniam..</a>
                                                </h5>
                                            </div>
                                            <div class="blog-short_desc">
                                                <p>Aenean vestibulum pretium enim, non commodo urna volutpat vitae. Pellentesque vel
                                                    lacus
                                                    eget est d...
                                                </p>
                                            </div>
                                            <div class="hiraola-read-more_area">
                                                <a href="single-blog.php" class="hiraola-read_more">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            <?php if(count($blogs)> 8) {?>
                            <div class="row clearfix mb-50-xs mb-50-sm">
                                <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                                    <a href="#" class="btn--more btn--more-1">LOAD MORE</a>
                                </div>  
                            </div>
                         <?php } } else { echo "No blog found."; } ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="hiraola-paginatoin-area">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <ul class="hiraola-pagination-box">
                                                <li class="active"><a href="javascript:void(0)">1</a></li>
                                                <li><a href="javascript:void(0)">2</a></li>
                                                <li><a href="javascript:void(0)">3</a></li>
                                                <li><a class="Next" href="javascript:void(0)"><i class="ion-ios-arrow-right"></i></a></li>
                                                <li><a class="Next" href="javascript:void(0)">>|</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6">
                                            <div class="product-select-box">
                                                <div class="product-short">
                                                    <p>Show</p>
                                                    <select class="myniceselect nice-select">
                                                        <option value="5">5</option>
                                                        <option value="10">10</option>
                                                        <option value="15">15</option>
                                                        <option value="20">20</option>
                                                        <option value="25">25</option>
                                                    </select>
                                                    <span>Per Page</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Blog Left Sidebar Area End Here -->
<?php 
$appendScript = '<script type="text/javascript">
$(function(event){
    var page=1;
    $(".btn--more").on("click",function(event){
        event.preventDefault();
        $.ajax({
            url:"'.base_url.'ajaxcontent",
            method:"post",
            data:{type:"blogs",param:"'.addslashes($ajaxWhere).'",page:page},
            success:function(response) {
                if(response != "") {
                    page++;
                    $(".ajax-blog").append(response);
                }
                else
                    $(".btn--more").hide();
            }
        });
    });
});
</script>';
require_once('footer.php');?>