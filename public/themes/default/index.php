<?php 
    echo theme_view('header');
    echo Template::message();
    echo isset($content) ? $content : Template::content();
    echo theme_view('footer');
?>