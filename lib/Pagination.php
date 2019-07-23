<?php

class Pagination
{


  public static function ajax_pagination($previous_next_btn  ,$first_last_btn ,$per_page,$page,$totalrecords)
  {

  	$cur_page = $page;
  	$page -= 1;
  	$start = $page * $per_page;

  	$no_of_paginations = ceil($totalrecords / $per_page);

  	/* ---------------Calculating the starting and endign values for the loop----------------------------------- */
  	if ($cur_page >= 5) {
  		$start_loop = $cur_page - 2;
  		if ($no_of_paginations > $cur_page + 2)
  			$end_loop = $cur_page + 2;
  		else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 4) {
  			$start_loop = $no_of_paginations - 4;
  			$end_loop = $no_of_paginations;
  		} else {
  			$end_loop = $no_of_paginations;
  		}
  	} else {
  		$start_loop = 1;
  		if ($no_of_paginations > 5)
  			$end_loop = 5;
  		else
  			$end_loop = $no_of_paginations;
  	}
  	/* ----------------------------------------------------------------------------------------------------------- */
  	$msg = "<div class='col-md-8 text-center'><div class='pagination'><ul>";

  	// FOR ENABLING THE FIRST BUTTON
  	if ($first_last_btn && $cur_page > 1) {
  		$msg .= "<li p='1' class='active'>First</li>";
  	} else if ($first_last_btn) {
  		$msg .= "<li p='1' class='inactive'>First</li>";
  	}

  	// FOR ENABLING THE PREVIOUS BUTTON
  	if ($previous_next_btn && $cur_page > 1) {
  		$pre = $cur_page - 1;
  		$msg .= "<li p='$pre' class='active'>Previous</li>";
  	} else if ($previous_next_btn) {
  		$msg .= "<li class='inactive'>Previous</li>";
  	}
  	for ($i = $start_loop; $i <= $end_loop; $i++) {

  		if ($cur_page == $i)
  			$msg .= "<li p='$i' style='color:#fff;background-color:#006699;' class='active'>{$i}</li>";
  		else
  			$msg .= "<li p='$i' class='active'>{$i}</li>";
  	}

  	// TO ENABLE THE NEXT BUTTON
  	if ($previous_next_btn && $cur_page < $no_of_paginations) {
  		$nex = $cur_page + 1;
  		$msg .= "<li p='$nex' class='active'>Next</li>";
  	} else if ($previous_next_btn) {
  		$msg .= "<li class='inactive'>Next</li>";
  	}

  	// TO ENABLE THE END BUTTON
  	if ($first_last_btn && $cur_page < $no_of_paginations) {
  		$msg .= "<li p='$no_of_paginations' class='active'>Last</li>";
  	} else if ($first_last_btn) {
  		$msg .= "<li p='$no_of_paginations' class='inactive'>Last</li>";
  	}
  	
  	$goto = "<div class='col-md-2'><div style='margin:20px 0px;'><input type='text' class='goto' size='1' style='margin-top:-1px;margin-left:60px;'/><input type='button' id='go_btn' class='go_button' value='Go'/> </div></div>";
  	$total_string = "<div class='col-md-2 text-center'><div style='margin:20px 0px; padding-right:10px; '><span class='total' a='$no_of_paginations'>Page <b>" . $cur_page . "</b> of <b>$no_of_paginations</b></span> </div></div>";
  	$res = $msg . "</ul></div></div>" . $goto . $total_string ;  // Content for pagination
  	return $res;
  }


  public static function php_pagination($limit, $page, $total_pages, $targetpage)
  {


    $adjacents = 3;
    $pagestr = (strpos($targetpage, '?') === FALSE) ? '?page=' : '&amp;page='; 
    $targetpage = $targetpage.$pagestr;
    $page = (int)$page;
    /* Setup page vars for display. */
    if ($page == 0) $page = 1;          //if no page var is given, default to 1.
    $prev = $page - 1;              //previous page is page - 1
    $next = $page + 1;              //next page is page + 1
    $lastpage = ceil($total_pages/$limit);    //lastpage is = total pages / items per page, rounded up.
    $lpm1 = $lastpage - 1;            //last page minus 1
    
    
    $pagination = '';
    if($lastpage > 1)
    { 
      $pagination .= '<ul class="pagination pagination-sm">';
      //previous button
      if ($page > 1) 
        $pagination.= '<li><a href="'.$targetpage.$prev.'"> << </a> </li>';
      else
        $pagination.= '<li class="disabled"><a href="javascript:void(0);"> <<  </a></li>';  
      

    

      //pages 
      if ($lastpage < 7 + ($adjacents * 2)) //not enough pages to bother breaking it up
      { 
        for ($counter = 1; $counter <= $lastpage; $counter++)
        {
          if ($counter == $page)
            $pagination.= '<li class="active"><a href="javascript:void(0);">'.$counter.'</a></li>';
          else
            $pagination.= '<li><a href="'.$targetpage.$counter.'">'.$counter.'</a></li>';          
        }


      }
      elseif($lastpage > 5 + ($adjacents * 2))  //enough pages to hide some
      {
        //close to beginning; only hide later pages
        if($page < 1 + ($adjacents * 2))    
        {
          for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
          {
            if ($counter == $page)
              $pagination.= '<li class="active"><a href="javascript:void(0);">'.$counter.'</a></li>';
            else
              $pagination.= '<li><a href="'.$targetpage.$counter.'">'.$counter.'</a></li>';          
          }
          $pagination.= '...';
          $pagination.= '<li><a href="'.$targetpage.$lpm1.'">'.$lpm1.'</a></li>';
          $pagination.= '<li><a href="'.$targetpage.$lastpage.'">'.$lastpage.'</a></li>';    
        }
        //in middle; hide some front and some back
        elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
        {
          $pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
          $pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
          $pagination.= '...';
          for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
          {
            if ($counter == $page)
              $pagination.= '<li class="active"><a href="javascript:void(0);">'.$counter.'</a></li>';
            else
              $pagination.= '<li><a href="'.$targetpage.$counter.'">'.$counter.'</a></li>';          
          }
          $pagination.= '...';
          $pagination.= '<li><a href="'.$targetpage.$lpm1.'">'.$lpm1.'</a></li>';
          $pagination.= '<li><a href="'.$targetpage.$lastpage.'">'.$lastpage.'</a></li>';    
        }
        //close to end; only hide early pages
        else
        {
          $pagination.= '<li><a href="'.$targetpage.'1">1</a></li>';
          $pagination.= '<li><a href="'.$targetpage.'2">2</a></li>';
          $pagination.= "...";
          for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
          {
            if ($counter == $page)
              $pagination.= '<li class="active"><a href="javascript:void(0);">'.$counter.'</a></li>';
            else
              $pagination.= '<li ><a href="'.$targetpage.$counter.'">'.$counter.'</a></li>';         
          }
        }
      }
      
      //next button
      if ($page < $counter - 1) 
        $pagination.= '<li><a href="'.$targetpage.$next.'">next >></a></li>';
      else
        $pagination.= '<li class="disabled"><a href="javascript:void(0);">next >> </a></li>';
      $pagination.= '</ul>';    
    }

    return $pagination;
  }


}

?>