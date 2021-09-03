
    <div class="loading">
            <div class="text-center middle">
                <div class="lds-ellipsis">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
        <header class="header-main_area header-main_area-2">
            <div class="header-bottom_area header-bottom_area-2 header-sticky stick">
                <div class="container-fliud">
                    <div class="row">
                        <div class="col-lg-2 col-md-4 col-sm-4">
                            <div class="header-logo">
                                <a  href="<?=base_url?>">
                                    <img src="<?=base_url?>assets/images/menu/logo/logo.png" alt="Sakshi's Header Logo">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-7 d-none d-lg-block position-static">
                            <div class="main-menu_area">
                                <nav>
                                    <ul>
                                        <li class="dropdown-holder" <?= (isset($active_tab) && $active_tab=='home')?'class="active"':''?>><a  href="<?=base_url?>">Home</a>
                                          
                                        </li>
                                        <li class="megamenu-holder <?= (isset($active_tab) && $active_tab=='products')?'active':''?>"><a href="<?=base_url?>products">Shop</a>
                                        <?php if(!empty($categories)) { ?>
                                            <ul class="hm-megamenu">
                                                <?php foreach($categories as $cat) { ?>
                                                    <li><span class="megamenu-title"><a  href="<?= base_url.'category/'.$cat['slug']?>"><?= $cat['name']?></a></span>
                                                    <?php if(!empty($cat['subcategory'])) { ?>
                                                        <ul>
                                                            <?php foreach($cat['subcategory'] as $subcat) { ?>
                                                                <li><a href="<?= base_url.'category/'.$cat['slug'].'/'.$subcat['slug']?>"><?= $subcat['name']?></a></li>
                                                            <?php } ?>    
                                                        </ul>
                                                    <?php } ?>    
                                                    </li>
                                                <?php } ?>    
                                            </ul>
                                        <?php } ?>    
                                        </li>
                                        <?php if(!isset($_SESSION['user'])) { ?>
                                            <li <?= (isset($active_tab) && $active_tab=='login')?'class="active"':''?>>
                                                <a  href="<?=base_url?>login" class="menu-item">Login</a>
                                            </li>
                                        <?php } else { ?>
                                            <li <?= (isset($active_tab) && $active_tab=='my account')?'class="active"':''?>>
                                                <a  href="<?=base_url?>my-account" class="menu-item">My Account</a>
                                            </li>
                                        <?php } ?>
                                        <li <?= (isset($active_tab) && $active_tab=='about us')?'class="active"':''?>><a  href="<?=base_url?>about-us">About Us</a></li>
                                        <li <?= (isset($active_tab) && $active_tab=='blogs')?'class="active"':''?>><a  href="<?=base_url?>blogs">Blog</a>
                                        </li>
                                        <li <?= (isset($active_tab) && $active_tab=='contact')?'class="active"':''?>><a  href="<?=base_url?>contact">Contact Us</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-8 col-sm-8">
                            <div class="header-right_area">
                                <ul>
                                    <li>
                                        <a  href="<?=base_url?>wishlist" class="wishlist-btn">
                                            <i class="ion-android-favorite-outline"></i>
                                            <label class="module-label counterwishlist"><?=isset($_SESSION['wishlist'])?count($_SESSION['wishlist']):'0'?></label>

                                        </a>
                                    </li>
                                    <li>
                                        <a  href="#searchBar" class="search-btn toolbar-btn">
                                            <i class="ion-ios-search-strong"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a  href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white d-lg-none d-block">
                                            <i class="ion-navicon"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a  href="<?=base_url?>cart" class="minicart-btn">
                                            <i class="ion-bag"></i>
                                            <label class="module-label bigcounter "><?=isset($_SESSION['cartitems'])?count($_SESSION['cartitems']):'0'?></label>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-search_wrapper" id="searchBar">
                <div class="offcanvas-menu-inner">
                    <div class="container">
                        <a  href="<?=base_url?>#" class="btn-close"><i class="ion-android-close"></i></a>
                        <div class="offcanvas-search module--search-box">
                            <form method="post" action="<?=base_url?>products" class="hm-searchbox form-search">
                                <input type="text" placeholder="Search for item...">
                                <button class="search_btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu_wrapper" id="mobileMenu">
                <div class="offcanvas-menu-inner">
                    <div class="container">
                        <a  href="<?=base_url?>#" class="btn-close"><i class="ion-android-close"></i></a>
                        <div class="offcanvas-inner_search module--search-box">
                            <form action="#" class="hm-searchbox form-search">
                                <input type="text" placeholder="Search for item...">
                                <button class="search_btn" type="submit"><i class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                        <nav class="offcanvas-navigation">
                            <ul class="mobile-menu">
                                <li <?= (isset($active_tab) && $active_tab=='home')?'class="active"':''?>><a  href="<?=base_url?>"><span class="mm-text">Home</span></a></li>
                                <li class="menu-item-has-children">
                                    <a  href="<?=base_url?>prdouct">
                                        <span class="mm-text">Shop</span>
                                    </a>
                                    <?php if(!empty($categories)) { ?>
                                        <ul class="sub-menu">
                                            <?php foreach($categories as $cat) { ?>
                                            <li class="menu-item-has-children">
                                                <a  href="<?= base_url.'category/'.$cat['slug']?>">
                                                    <span class="mm-text"><?= $cat['name']?></span>
                                                </a>
                                                <?php if(!empty($cat['subcategory'])) { ?>
                                                <ul class="sub-menu">
                                                    <?php foreach($cat['subcategory'] as $subcat) { ?>
                                                        <li>
                                                            <a  href="<?= base_url.'category/'.$cat['slug'].'/'.$subcat['slug']?>">
                                                                <span class="mm-text"><?= $subcat['name']?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>    
                                                </ul>
                                                <?php } ?>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                    <?php } ?>
                                </li>
                                <li <?= (isset($active_tab) && $active_tab=='blogs')?'class="active"':''?>>
                                    <a  href="<?=base_url?>blogs">
                                        <span class="mm-text">Blog</span>
                                    </a>
                                </li>
                                <?php if(!isset($_SESSION['user'])) { ?>
                                    <li <?= (isset($active_tab) && $active_tab=='login')?'class="active"':''?>>
                                        <a  href="<?=base_url?>login" class="menu-item">Login</a>
                                    </li>
                                <?php } else { ?>
                                    <li <?= (isset($active_tab) && $active_tab=='my account')?'class="active"':''?>>
                                        <a  href="<?=base_url?>my-account" class="menu-item">My Account</a>
                                    </li>
                                <?php } ?>
                                <li <?= (isset($active_tab) && $active_tab=='about us')?'class="active"':''?>><a  href="<?=base_url?>about-us"><span class="mm-text">About Us</span></a></li>
                                <li <?= (isset($active_tab) && $active_tab=='contact')?'class="active"':''?>><a  href="<?=base_url?>contact"><span class="mm-text">Contact Us</span></a></li>
                            </ul>
                        </nav>
                        <nav class="offcanvas-navigation user-setting_area">
                            <ul class="mobile-menu">
                                <!-- <li class="menu-item-has-children active">
                                    <a  href="<?=base_url?>#">
                                        <span class="mm-text">User
                                        Setting
                                    </span>
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a  href="<?=base_url?>my-account">
                                                <span class="mm-text">My Account</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="<?=base_url?>login">
                                                <span class="mm-text">Login</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li> -->
                                <!-- <li class="menu-item-has-children"><a  href="<?=base_url?>#"><span class="mm-text">Currency</span></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">EUR €</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">USD $</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item-has-children"><a  href="<?=base_url?>#"><span class="mm-text">Language</span></a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">English</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">Français</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">Romanian</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a  href="<?=base_url?>javascript:void(0)">
                                                <span class="mm-text">Japanese</span>
                                            </a>
                                        </li> -->
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </header>