<?php
    $img_dir = "uploads/images/";
    $array = ' <ul class = "list-picture">';
    $images = scandir($img_dir);
    //  $images = preg_grep('~^'.$_SESSION['user_name'].'.*\.png$~', $images);
    foreach($images as $img) 	
    { 
        if($img === '.' || $img === '..') 
        {
            continue;
        } 		   
        if (preg_match('/.png/',$img))
        {				
            $array .= '<li class = "pic-items"><img src = "'.$img_dir.$img.'"><br/><button id = "remove-photo" type = "button">Remove</button></li>';
        } 
        else 
        { 
            continue; 
        }	
    }
    $array.= '</ul>';
    echo $array;
?>