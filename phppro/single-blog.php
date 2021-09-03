<?php
$active_tab="blogs";
require_once("header.php");
require_once("menu.php");
$recentposts = $QueryFire->getAllData('blogs',' 1 order by id desc limit 10');
if(isset($_POST['comment'])) {
    $arr = array();
    $arr['comment'] = strip_tags($_POST['comment']);
    $arr['blog_id'] = $blog['id'];
    $arr['user_id'] = $_SESSION['user']['id'];
    if($QueryFire->insertData('blog_comments',$arr)) {
      $msg = '<h5 class="text-info text-center">Your comment is under review. Once checked will be published soon.<h5>';
    } else {
      $msg = '<h5 class="text-danger text-center">Unable to comment on this blog.</h5>';
    }
}
$comments = $QueryFire->getAllData('','','SELECT c.*,u.name as user FROM blog_comments as c LEFT JOIN blogs as b ON b.id=c.blog_id LEFT JOIN users as u ON u.id=c.user_id WHERE c.is_approved=1 and c.blog_id='.$blog['id'] .' ORDER BY c.id desc');
?>
  <!-- Begin Hiraola's Breadcrumb Area -->
  <div class="breadcrumb-area">
            <div class="container">
                <div class="breadcrumb-content">
                    <h2>Blog Details</h2>
                    <ul>
                        <li><a href="<?= base_url?>">Home</a></li>
                        <li class="active"><?= $blog['title']?> </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Hiraola's Breadcrumb Area End Here -->

        <!-- Begin Hiraola's Blog Details Left Sidebar Area -->
        <div class="hiraola-blog_area hiraola-blog_area-2 hiraola-blog-details hiraola-banner_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 order-lg-1 order-2">
                        <div class="hiraola-blog-sidebar-wrapper widget-search">
                            <div class="hiraola-blog-sidebar">
                                <div class="hiraola-sidebar-search-form widget--content">
                                    <form class="form-search" method="post" action="<?= base_url?>blogs">
                                        <input type="text"  name="search_blog"  class="hiraola-search-field" placeholder="search here">
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
                        <div class="blog-item">
                            
                            <div class="blog-img img-hover_effect">
                                <?= isset($msg)?$msg:''?>
                                <a href="single-blog.php">
                                    <img src="<?= base_url.'images/blogs/'.$blog['image_name']?>" alt="Hiraola's Blog Image">
                                </a>
                                <div class="blog-meta-2">
                                    <div class="blog-time_schedule">
                                        <span class="day"><?= date('d-m-Y',strtotime($blog['date'])) ?></span>
                                        <!-- <span class="month">April</span> -->
                                    </div>
                                </div>
                            </div>
                            <div class="blog-content">
                                <div class="blog-heading">
                                    <h5>
                                        <a href="javascrip:void(0)">Blog Image Post</a>
                                    </h5>
                                </div>
                                <div class="blog-short_desc">
                                    <p>The most popular color is yellow which is made by adding silver and some copper. The metals are melted together to form an alloy of the desired color and karat. It is very important that all the ingredients are pure and that the amounts of each are weighed very accurately to prevent porosity, which weakens the alloy.
                                    </p>
                                </div>
                            </div>
                            <div class="hiraola-blog-blockquote">
                                <blockquote>
                                    <p>The weight of evidence strongly supports a theme of healthful eating while allowing for
                                        variations on that theme. A
                                        diet of minimally processed foods close to nature, predominantly plants, is decisively
                                        associated with health
                                        promotion and disease prevention and is consistent with the salient components of
                                        seemingly distinct dietary
                                        approaches. Efforts to improve public health through diet are forestalled not for want
                                        of knowledge about the
                                        optimal feeding of Homo sapiens but for distractions associated with exaggerated claims,
                                        and our failure to convert
                                        what we reliably know into what we routinely do.
                                    </p>
                                </blockquote>
                            </div>
                            <div class="blog-additional_information">
                                <p>D colored diamonds are the rarest and most expensive of diamonds within the D-Z scale. Certain fancy colored diamonds will command the highest prices overall, and these will be discussed in separate tutorial. Many people enjoy diamonds in the near colorless range G-J, as they find a balance of size, clarity, and price to meet their needs.
                                </p>
                            </div>
                            <div class="hiraola-tag-line">
                                <h4>Tag:</h4>
                                <a href="javascript:void(0)">Vegetables</a>,
                                <a href="javascript:void(0)">Milk Fresh</a>,
                                <a href="javascript:void(0)">Edible Oils</a>
                            </div>
                            <div class="hiraola-social_link">
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
                                    <li class="google-plus">
                                        <a href="https://www.plus.google.com/discover" data-toggle="tooltip" target="_blank" title="Google Plus">
                                            <i class="fab fa-google-plus"></i>
                                        </a>
                                    </li>
                                    <li class="instagram">
                                        <a href="https://rss.com/" data-toggle="tooltip" target="_blank" title="Instagram">
                                            <i class="fab fa-instagram"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="hiraola-comment-section">
                                <?php if(!empty($comments)) { ?>
                                <h3><?= count($comments)>0?'comment <span>( '.count($comments).' )</span>':' No Comments'?></h3>
                                <ul>
                                    <?php foreach($comments as $comment) { ?>
                                        <li>
                                            <!-- <div class="author-avatar">
                                                <img src="assets/images/blog/user.png" alt="User">
                                            </div> -->
                                            <div class="comment-body">
                                                <!-- <span class="reply-btn"><a href="javascript:void(0)">reply</a></span> -->
                                                <h5 class="comment-author"><?= $comment['user']?></h5>
                                                <div class="comment-post-date">
                                                    <!-- 25 April, 2019 at 10:30amx` -->
                                                    <?= date('d-m-Y',strtotime($comment['date']))?>
                                                </div>
                                                <p><?= $comment['comment']?></p>
                                            </div>
                                        </li>
                                    <?php  } ?>    
                                    <!-- <li class="comment-children">
                                        <div class="author-avatar">
                                            <img src="assets/images/blog/admin.png" alt="Admin">
                                        </div>
                                        <div class="comment-body">
                                            <span class="reply-btn"><a href="javascript:void(0)">reply</a></span>
                                            <h5 class="comment-author">Anny Adams</h5>
                                            <div class="comment-post-date">
                                                25 April, 2019 at 11:00am
                                            </div>
                                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Enim maiores adipisci
                                                optio ex,
                                                laboriosam
                                                facilis non pariatur itaque illo sunt?</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="author-avatar">
                                            <img src="assets/images/blog/user.png" alt="User">
                                        </div>
                                        <div class="comment-body">
                                            <span class="reply-btn"><a href="javascript:void(0)">reply</a></span>
                                            <h5 class="comment-author">Edwin Adams</h5>
                                            <div class="comment-post-date">
                                                25 April, 2019 at 06:50pm
                                            </div>
                                            <p>Thank You :)</p>
                                        </div>
                                    </li> -->
                                </ul>
                                <?php } ?>
                            </div>
                            <div class="hiraola-blog-comment-wrapper">
                                <h3>leave a reply</h3>
                                <!-- <p>Your email address will not be published. Required fields are marked *</p> -->
                                <?php if(isset($_SESSION['user'])) { ?>
                                    <form id="post-comment" method="post">
                                        <div class="comment-post-box">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <label>comment</label>
                                                    <textarea name="comment" required id="comment" rows="2" placeholder="Write a comment"></textarea>
                                                </div>
                                                <!-- <div class="col-lg-4 col-md-4">
                                                    <label>Name</label>
                                                    <input type="text" class="coment-field" placeholder="Name">
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <label>Email</label>
                                                    <input type="text" class="coment-field" placeholder="Email">
                                                </div>
                                                <div class="col-lg-4 col-md-4">
                                                    <label>Website</label>
                                                    <input type="text" class="coment-field" placeholder="Website">
                                                </div> -->
                                                <div class="col-lg-12">
                                                    <div class="comment-btn_wrap f-left">
                                                        <div class="hiraola-post-btn_area">
                                                            <!-- <a class="hiraola-post_btn" href="javascript:void(0)">Post comment</a> -->
                                                            <button type="submit" class="hiraola-post_btn">Post comment</button>
                                                        </div>
                                                        <!-- <input class="hiraola-post_btn" type="submit" name="submit" value="post comment"> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <h6 class="text-info ">You must login to comment on this. <a href="<?= base_url.'login?url='.urlencode(base_url.'blog/'.$blog['slug'])?>">Click here</a> to login.</h6>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Blog Details Left Sidebar Area End Here -->
<?php require_once('footer.php');?>