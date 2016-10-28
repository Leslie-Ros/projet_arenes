<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <h1>Combattant</h1>

    <?php
    if ($hasFighter) {
        ?>
    <h2>Votre combattant</h2>
        
    <table class='fighterPrint'>
        <?php echo $this->Html->tableHeaders(['Nom', 'Niveau', 'xp', 'Vue', 'Force', 'Vie max', 'PV']);
        echo $this->Html->tableCells([$combattant->name, $combattant->level, $combattant->xp, $combattant->skill_sight, $combattant->skill_strength, $combattant->skill_health, $combattant->current_health]);
        ?>
    </table>
        
        
        <?php
        if ($mayLevelUp == TRUE) { ?>
            <section>Vous pouvez passer au niveau suivant. Quelle caractéristique souhaitez-vous améliorer ?
                 <?php echo $this->Form->create();
                 $options = ['vue' => 'Vue', 'force' => 'Force', 'vie'=> 'Vie max'];
                 echo $this->Form->select('competence', $options);
                 echo $this->Form->hidden('idform', ['value' => 'levelup']);
                 echo $this->Form->button('Passer au niveau supérieur !');
                 echo $this->Form->end();
                 ?>
            </section>
    
        <?php } else {
            echo "Encore quelques points à gagner !";
        }
        $parametres = array("combattant" => $combattant, "mayLevelUp" => $mayLevelUp);
        //echo $this->element('selection', $parametres);
    }
    
    
    else {//s'il n'y a pas de combattant associé à ce joueur
        ?>
    <h2>Créez votre combattant</h2>
        <?php
        echo $this->Form->create('Fighters');
        echo $this->Form->input('name');
        echo $this->Form->hidden('idform', ['value' => 'creation']);
        echo $this->Form->button('Valider');
        echo $this->Form->end();
        //echo $this->element('creation');
    }
    ?>
</html>