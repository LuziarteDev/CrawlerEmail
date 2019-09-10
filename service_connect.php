<?php 
    require_once 'autoload.php';

    $t = explode( ',', filter_input( INPUT_POST, 'terms', FILTER_SANITIZE_SPECIAL_CHARS ) );
    $end = filter_input( INPUT_POST, 'start', FILTER_SANITIZE_SPECIAL_CHARS );

    ini_set('max_execution_time', 0);
    $con = new PDO('mysql:host=localhost;dbname=crawler;', 'root', '');

    foreach ($t as $key => $value) {

        $start = 0;

        $s_url = $value;
        for( $start = 0; $start < $end ; $start += 10 ){
            $c = new Crawler('https://www.google.com/search?q=' . $s_url . '&start=' . $start . '&oq=' . $s_url . '&aqs=chrome..69i57j0j69i60j69i61j69i60l2.444j0j4&sourceid=chrome&ie=UTF-8', $con);
        }

        $stmt = $con->prepare("INSERT INTO historical(id, terms, max_page) VALUES (:id, :terms ,:max_page);");
        $id = '';
        $terms = $s_url;
        $max_page = $start;
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':terms', $terms);
        $stmt->bindParam(':max_page', $max_page);
        $stmt->execute();
}
