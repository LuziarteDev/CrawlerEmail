<?php 

class Crawler
{
    static public $iteration = 0;

    function __construct( $url, $con )
    {
        $this::$iteration++;
        $html = file_get_contents($url);
        $c = preg_match_all('/href="\/url\?q=(.*?)"\>/', $html, $out);

        foreach ($out[1] as $key => $value) {
            $html_interno = $value;
            $ch = curl_init($value);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $html_interno = curl_exec($ch);
            curl_close($ch); 
            preg_match_all('/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/', $html_interno, $out_interno);

            if( !empty( $out_interno[0] ) ){
                $out_interno['url'] = $value;
                $out_interno['url_id'] = md5(rand(0, 9999));

                try {
                    
                    $UrlID = $out_interno['url_id'];
                    $UrlData = $out_interno['url'];
                    $stmt = $con->prepare("INSERT INTO urls(UrlID, UrlData) VALUES (?, ?);");
                    $stmt->bindParam(1, $UrlID);
                    $stmt->bindParam(2, $UrlData);
                    $stmt->execute();

                } catch (Exception $e) {
                    print $e->getMessage() . "\n";
                }


                $stmt = $con->prepare("INSERT INTO emails(EmailID, UrlID, EmailData) VALUES (:EmailID, :UrlID, :EmailData);");
                $stmt->bindParam(':EmailID', $EmailID);
                $stmt->bindParam(':UrlID', $UrlID_email);
                $stmt->bindParam(':EmailData', $EmailData);

                foreach( $out_interno[0] as $key_o => $value_o ){
                    $EmailID = '';
                    $UrlID_email = $out_interno['url_id'];
                    $EmailData = $value_o;
                    $stmt->execute();

                }

            }
        }
    }
}