<?php 

function __autoload( $classname ){
    require_once 'lib/simple_html_dom.php';
    if(file_exists( 'classes/' . $classname . '.php' )){
        require_once 'classes/' . $classname . '.php';
    }
}
