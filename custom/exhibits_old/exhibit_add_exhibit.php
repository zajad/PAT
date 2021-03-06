<?php
session_start();
require_once("../include/conf.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Natural Europe - Add Supporting Materials</title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- Stylesheets -->
<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>admin/themes/default/css/screen.css" />
<link rel="stylesheet" media="print" href="<?php echo $urllinkbase; ?>admin/themes/default/css/print.css" />
<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>admin/themes/default/css/niftyCorners.css" />

<link rel="stylesheet" media="screen" href="<?php echo $urllinkbase; ?>shared/exhibit_layouts/text-image-right/layout.css" />

<?php
		$autocomplete_scripts="<script type='text/javascript' src='".$AUTO_BASE."lib/jquery.bgiframe.min.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."lib/jquery.ajaxQueue.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."lib/thickbox-compressed.js'></script> ".
					"<script type='text/javascript' src='".$AUTO_BASE."jquery.autocomplete.js'></script> ".					
					"<link rel='stylesheet' type='text/css' href='".$AUTO_BASE."jquery.autocomplete.css'> ".
					"<link rel='stylesheet' type='text/css' href='".$AUTO_BASE."lib/thickbox.css'> ".
					"<script type='text/javascript' src='".$AUTO_BASE."search_exhibit.js'></script> ";
                                        
                $jquery_script="<script type='text/javascript' src='".$JQUERY_BASE."jquery-1.3.2.js'></script> ";
                
                $select_box_script="<script type='text/javascript' src='".$SELECT_BOXES_BASE."jquery.selectboxes.pack.js'></script> ";
                
                $custom_scripts="<script type='text/javascript' src='".$CUSTOM_SCRIPTS_BASE."scripts.js'></script> ";
                
                
                $scripts="";
                $scripts.=$jquery_script.$autocomplete_scripts.$select_box_script.$custom_scripts;
                
                echo $scripts;

?>
</head>
<body class="exhibits">

echo '<form name="item-exhibit" id="page-form" method="post">';


<div id="content">

<div id="primary">



<?php
session_start();
if ( $_SESSION["admin_logged"] == true ){

    require_once("../include/db_connect.php");  
    
    $path_db="../../application/config/db.ini";
    db_connect($path_db);
    
    echo "Search Exhibits: ";
    echo '<input type="text" id="search_item" name="search_item" rows="30" cols="50" class="textinput">';
    echo "All Exhibits: ";
    echo '<select name="select_item" id="select_item">';
                
        $query_item="select id, title, slug, target_group from omeka_exhibits where public=1 order by title";
        $result_item=mysql_query($query_item);
        $numrows_item=mysql_numrows($result_item);

        if ( $numrows_item <1 ){
            echo '<option>No exhibits</option>';
        }
        else{
            echo '<option>Choose an Exhibit</option>';    
        }
        
        for ($i=0;$i<$numrows_item;$i++){
            $row_item=mysql_fetch_array($result_item);
            
            $item_id=$row_item["id"];
			$item_slug=$row_item["slug"];
            $item_title=$row_item["title"];
			$item_group=$row_item["target_group"];
            
            echo '<option value="'.$item_id.';'.$item_slug.';'.$item_group.'">'.$item_title.'</option>';    
        }
        

    echo '</select>';
    
    echo '<br><br>';
    
    echo '<p id="page-submits">';

    echo '<input type="button" onClick="return CallParent3();" name="insert" value="Insert" style="margin-right: 10px;">';
    echo '<input type="button" onClick="return Close();" name="cancel" value="Cancel">';
    
    echo "</p>";
    
    echo '<input type="hidden" name="item_title_hid" id="item_title_hid" >';
}
else{
    echo "You do not have the rights to see this page!";
}


?>
</div>

</div>
</form>

</body>
</html>