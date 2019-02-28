<?php
    class Utilities{
        public function getPaging($page, $total_rows, $records_per_page, $page_url){
            $pagging_arr=[];
            $pagging_arr["first"]=($page>1)?"{$page_url}page=1":"";
            $total_pages = ceil($total_rows/$records_per_page);
            $range = 2;
            $initial_num = $page-$range;
            $condition_limit_num = ($page + $range)+1;
            $paging_arr["pages"]=[];
            $page_count=0;
            for($x=$initial_num; $x<$condition_limit_num; $x++){
                // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
                if(($x > 0) && ($x <= $total_pages)){
                    $paging_arr['pages'][$page_count]["page"]=$x;
                    $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}";
                    $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
     
                    $page_count++;
                }
            }
            // button for last page
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}" : "";
 
        // json format
        return $paging_arr;
        }

    }




?>