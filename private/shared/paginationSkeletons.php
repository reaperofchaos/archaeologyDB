<?php
require_once(dirname(__FILE__)."/../../private/initialize.php");

$total = Site::countSites();
	
$adjacents = 3;
$targetpage = $_SERVER['PHP_SELF']; //your file name
$limit = 50; //how many items to show per page
if(isset($_GET['skeletonPage']))
{
    $page = $_GET['skeletonPage'];
}else{
    $page = 0;
}
if($page){ 
    $start = ($page - 1) * $limit; //first item to display on this page
}else{
    $start = 0;
}
/* Setup page vars for display. */
    if ($page == 0) {
        $page = 1;
    } //if no page var is given, default to 1.
    $prev = $page - 1; //previous page is current page - 1
    $next = $page + 1; //next page is current page + 1
    $lastpage = ceil($total/$limit); //lastpage.
    $lpm1 = $lastpage - 1; //last page minus 1
/* CREATE THE PAGINATION */
$pagination = "";
$counter = 0;

if($lastpage > 1)
{ 
    $pagination .= "<ul class='pagination'>";
    if ($page > $counter+1) {
        $pagination.= "<li><a href=\"$targetpage?sitePage=$prev\"><</a></li>"; 
    }

    if ($lastpage < 7 + ($adjacents * 2)) 
    { 
        for ($counter = 1; $counter <= $lastpage; $counter++)
        {
            if ($counter == $page)
                $pagination.= "<li class='active'><a href='#' >$counter</a></li>";
            else
                $pagination.= "<li><a href=\"$targetpage?sitePage=$counter\">$counter</a></li>"; 
        }
    }
    elseif($lastpage > 5 + ($adjacents * 2)) //enough pages to hide some
    {
        //close to beginning; only hide later pages
        if($page < 1 + ($adjacents * 2)) 
        {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
                if ($counter == $page)
                    $pagination.= "<li class='pagination active' value='$counter'><a href='#' >$counter</a></li>";
                else
                    $pagination.= "<li class='pagination' value='$counter'><a href=\"$targetpage?sitePage=$counter\">$counter</a></li>"; 
            }
            $pagination.= "<li>...</li>";
            $pagination.= "<li class='pagination' value='$lpm1'><a href=\"$targetpage?sitePage=$lpm1\">$lpm1</a></li>";
            $pagination.= "<li class='pagination' value='$lastpage'><a href=\"$targetpage?sitePage=$lastpage\">$lastpage</a></li>"; 
        }
        //in middle; hide some front and some back
        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        {
            $pagination.= "<li class='pagination' value='1'><a href=\"$targetpage?sitePage=1\">1</a></li>";
            $pagination.= "<li class='pagination' value='2'><a href=\"$targetpage?sitePage=2\">2</a></li>";
            $pagination.= "<li>...</li>";
            for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<li class='pagination active'><a href='#' >$counter</a></li>";
                else
                    $pagination.= "<li class='pagination' value='$counter'><a href=\"$targetpage?sitePage=$counter\">$counter</a></li>"; 
            }
            $pagination.= "<li>...</li>";
            $pagination.= "<li class='pagination' value='$lpm1'><a href=\"$targetpage?sitePage=$lpm1\">$lpm1</a></li>";
            $pagination.= "<li class='pagination' value='$lastpage'><a href=\"$targetpage?sitePage=$lastpage\">$lastpage</a></li>"; 
        }
        //close to end; only hide early pages
        else
        {
            $pagination.= "<li class='pagination' value='1'><a href=\"$targetpage?sitePage=1#author\">1</a></li>";
            $pagination.= "<li class='pagination' value='2'><a href=\"$targetpage?sitePage=2#author\">2</a></li>";
            $pagination.= "<li >...</li>";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; 
            $counter++)
            {
                if ($counter == $page)
                    $pagination.= "<li class='pagination active' value='$counter'><a href='#'>$counter</a></li>";
                else
                    $pagination.= "<li class='pagination' value='$counter'><a href=\"$targetpage?sitePage=$counter#author\">$counter</a></li>"; 
            }
        }
    }

    //next button
    if ($page < $counter - 1) 
        $pagination.= "<li class='pagination' id='$next'><a href=\"$targetpage?sitePage=$next#author\">></a></li>";
    else
        $pagination.= "";
    $pagination.= "</ul>\n"; 
}
echo $pagination;
?>