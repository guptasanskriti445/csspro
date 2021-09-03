<?php
session_start();
if(isset($_POST['type'])) {
	require_once('admin/query.php');
	$output = '';
	switch (strtolower($_POST['type'])) {
		case 'blogs':
			$where = ' 1 ';
			if(!empty($_POST['param'])) {
			    $where .= $_POST;
			}
			$page = $_POST['page']-1;
			$page = $page*10;
			$where .= ' ORDER BY id LIMIT '.$page.',10';
			$blogs = $QueryFire->getAllData('blogs',$where);
			if(!empty($blogs)) {
				foreach($blogs as $blog) {
				    $output .='<div class="col-sm-6 col-md-6 col-lg-4 blog-entry">
				        <div class="entry--img">
				            <a href="'.base_url.'blog/'.$blog['slug'].'">
				                <img src="'.base_url.'images/blogs/'.$blog['image_name'].'" alt="'.$blog['title'].'"  />
				            </a>
				        </div>
				        <div class="entry--content">
				            <div class="entry--meta">
				                <span class="meta--time"> <i class="fa fa-calendar"></i> '.date('d-m-Y',strtotime($blog['date'])).'</span>
				            </div>
				            <div class="entry--title">
				                <h4><a href="'.base_url.'blog/'.$blog['slug'].'">'.$blog['title'].'</a></h4>
				            </div>
				            <div class="entry--footer">
				                <div class="entry--more">
				                    <a href="'.base_url.'blog/'.$blog['slug'].'">read more</a>
				                </div>
				            </div>
				        </div>
				    </div>';
				}
			}
			break;		
		default:
			$output ="Invalid entry.";
			break;
	}
	echo $output;
} else {
	echo "Unauthorize entry. Access denied.";
}