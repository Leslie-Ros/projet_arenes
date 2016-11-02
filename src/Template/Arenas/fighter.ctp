<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
    <h1>Combattant</h1>

    <?php 
    if ($hasFighter) { ?> <h2>Vos combattants</h2> <?php
        foreach($combattants as $key=>$combattant){?>

        <table class='fighterPrint'>
            <?php echo $this->Html->tableHeaders(['Nom', 'Niveau', 'xp', 'Vue', 'Force', 'Vie max', 'PV']);
            echo $this->Html->tableCells([$combattant->name, $combattant->level, $combattant->xp, $combattant->skill_sight, $combattant->skill_strength, $combattant->skill_health, $combattant->current_health]);
            ?>
        </table>


            <?php
            if ($mayLevelUp[$key] == TRUE) { ?>
                Vous pouvez passer au niveau suivant. Quelle caractéristique souhaitez-vous améliorer ?
                     <?php echo $this->Form->create();
                     $options = ['vue' => 'Vue', 'force' => 'Force', 'vie'=> 'Vie max'];
                     echo $this->Form->select('competence', $options);
                     echo $this->Form->hidden('idform', ['value' => 'levelup']);
                     echo $this->Form->hidden('id_f', ['value' => $combattant->id]);
                     echo $this->Form->button('Passer au niveau supérieur !');
                     echo $this->Form->end();
                     ?>

            <?php } else {
                ?> <section class='cadrecssfighter'>Encore quelques points à gagner !</section><?php
            }
            $parametres = array("combattant" => $combattant, "mayLevelUp" => $mayLevelUp);
            //echo $this->element('selection', $parametres);
        }
    }
    
    //Desormais on laisse toujours la possibilité de créer d'autres fighters
    /*else {//s'il n'y a pas de combattant associé à ce joueur*/
        ?>
    <h2>Créer un nouveau combattant</h2>
        <?php
        echo $this->Form->create('Fighters');
        echo $this->Form->input('name');
        echo $this->Form->hidden('idform', ['value' => 'creation']);
        echo $this->Form->button('Valider');
        echo $this->Form->end();
        //echo $this->element('creation');
    /*}*/
    ?>

    <div id="jouer">
 <a href="<?php echo $this->Url->build([
                'controller' => 'Arenas',
                'action' => 'sight'
            ]); ?>" class="btn btn-lg btn-primary">JOUER MAINTENANT</a>

</div>