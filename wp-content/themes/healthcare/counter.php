<?php
    $handle = fopen("counter.txt", "r");
    if(!$handle)
    {
        echo "could not open the file";
    }
    else
    {
        $counter=(int )fread($handle,20);fclose($handle);
        if(!isset($_SESSION['hasVisited'])){
            $_SESSION['hasVisited']="yes";
            $counter++;
        }
        echo"Lượt xem: ". $counter . "" ;
        $handle= fopen("counter.txt", "w" ) ;
        fwrite($handle,$counter) ;fclose ($handle) ;
    }
