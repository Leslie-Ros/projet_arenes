<?php
//<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    echo "Combattant"; echo $hasFighter;
    
    if ($hasFighter){
        echo "Votre combattant";
        pr($combattant);
        
        if ($mayLevelUp==TRUE){
            echo "Vous pouvez passer au niveau suivant. Quelle caractéristique souhaitez-vous améliorer ?";
        }
        else{
            echo "Encore quelques points à gagner !";
        }
    }
    
    else {//s'il n'y a pas de combattant asocié à ce joueur
        echo "Créer un combattant";
    }
;?>