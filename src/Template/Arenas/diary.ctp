<?=

$this->assign('title', 'Journal des évènement');?>

<h1>Evènements à portée de vue de moins de 24h.</h1>

<div class="cadrecss">
<?php
if($this->request->session()->read('User.fighter_id')){
    foreach ($event as $row){
        echo $row;
        echo "<br>";
    }
}else echo "BOULET ! Tu n'as pas de fighter";

?> 
</div>