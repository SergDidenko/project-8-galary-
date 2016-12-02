<?php

if (isset($_COOKIE['page'])) {
	$max=$_COOKIE['page'];
}else{
	$max=5;
}

$page=1;
$link=5;

if (isset($_GET['page']) && isset($_GET['type'])) {
	$page=$_GET['page'];
	$type=$_GET['type'];
}

$start=($page-1)*$max;

require 'connection.php';
require 'field_template.php';
$data_first=$indicators[$type]['data'][0];
$files=mysqli_query($conn,"SELECT count(*) as c FROM $data_first");
foreach ($files as $file) {
	$max_page=ceil($file['c']/$max);
}
for ($i=0; $i < $max_page ; $i++) { 
	$pagesArr[$i+1]=$i*$max;
}
$allPages=array_chunk($pagesArr,$link, true);

function search_page($allPages,$start){
	foreach ($allPages as $chunk => $pages) {
		if (in_array($start,$pages)) {
			return $chunk;
		}
	}
		return 0;
}

$need_chunk=search_page($allPages,$start);
echo '<ul class="pagination">';
if ($page>1) {
	echo '<li><a href="upload.php?page='.($page-1).'&type='.$type.'">&laquo;</a></li>';
}
	if ($page>1) {
		echo '<li><a href="/upload.php?page=1&type='.$type.'">First</a></li>';
		echo '<li><a href="#">...</a></li>';
	}
	foreach ($allPages[$need_chunk] as $pageNum => $ofset) {
			echo '<li><a href="upload.php?page='.$pageNum.'&type='.$type.'">'.$pageNum.'</a></li>';
	}
	echo '<li><a href="#">...</a></li>';
	echo '<li><a href="upload.php?page='.$max_page.'&type='.$type.'">Last</a></li>';

if ($page<$max_page) {
	echo '<li><a href="upload.php?page='.($page+1).'&type='.$type.'">&raquo;</a></li>';
}
echo '</ul>';