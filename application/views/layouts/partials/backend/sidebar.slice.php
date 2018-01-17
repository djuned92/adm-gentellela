<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="index.html" class="site_title"><i class="fa fa-paw"></i> <span>Gentelella Alela!</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?=base_url('assets/images/isyana.jpg')?>" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>Isyana Sarasvati</h2>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- /menu profile quick info -->
        <br />
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="<?=base_url('home')?>"><i class="fa fa-dashboard"></i> Dashboard </a></li>
                    <?=$menus?>

                    <!--  <li><a href="<?=base_url('users')?>"><i class="fa fa-users"></i> Manage Users </a></li>
                    <li>
                        <a><i class="fa fa-gear"></i> Settings <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#level1_1">Level One</a>
                            <li>
                                <a>Menus<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu"><a href="<?=base_url('menus')?>">List Menus</a>
                                    </li>
                                    <li><a href="#level2_1">User Privileges</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->
    </div>
</div>