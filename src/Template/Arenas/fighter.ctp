<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <html>
    <h1>Combattant</h1>
    
    <?php if ($hasFighter){
        /*echo "Votre combattant";
        pr($combattant);
        
        if ($mayLevelUp==TRUE){
            echo "Vous pouvez passer au niveau suivant. Quelle caractéristique souhaitez-vous améliorer ?";
        }
        else{
            echo "Encore quelques points à gagner !";
        }*/
        $parametres=array("combattant" => $combattant, "mayLevelUp" => $mayLevelUp);
        echo $this->element('selection', $parametres);
    }
    
    else {//s'il n'y a pas de combattant asocié à ce joueur
        echo $this->element('creation');
    }
    ?>
    </html>