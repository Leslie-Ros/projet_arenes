<?= $this->assign('title', 'Flêche dans le genou');?>
<div class="cadrecss">
<?php
if($hasFighter){
echo $log;
echo "<br>";
echo "Il vous reste ".$ap." points d'actions";
} else {
    echo "Pour jouer, crée-toi un combattant !";
 }
echo "<br>";
?>
</div>
<?php if($hasFighter){ ?><div id = "jeu"><?php
    for ($row = 0; $row < $largeur; $row++) {
        for ($col = 0; $col < $longueur; $col++) {
                echo "<section id=\"arene\"";
            if($mask[$row][$col] == "#"){
                echo "class=\"backgroundSight";
                if($arena[$row][$col] == "_")
                    echo "\"> ";
                else if ($arena[$row][$col] == $this->request->session()->read('User.fighter_id')){
                    echo "  monPerso\">O";
                }
                else
                    echo "\">X"/*.$arena[$row][$col]*/;
            }else {
                echo "class=\"backgroundFog\">";
            }
                echo "</section>";
        }
    echo "<div style=\"clear: both\"></div>";
    }
    ?></div>
<?php } ?>

<?php if ($hasFighter){ ?>
    <div id = "bselection" ><?php
    echo $this->Form->create();
    $options = ['N' => 'North', 'W' => 'West', 'S' => 'South', 'E' => 'East'];
    echo $this->Form->select('direction', $options);
    echo $this->Form->button('GO!');
    echo $this->Form->end();
    ?></div>
        <div id="evensight">
     <a href="<?php if($hasFighter){
     echo $this->Url->build([
                    'controller' => 'Arenas',
                    'action' => 'diary'
     ]); }?>" class="btn btn-lg btn-primary">JOURNAL DES EVENEMENTS</a>

    </div>
<?php }?>