<?= $this->assign('title', 'Journal des évènement');?>

<h1>Evènements à portée de vue de moins de 24h.</h1>

<div id="diarycss">
<?php

foreach ($event as $row){
    echo $row;
    echo "<br>";
}

?> 
</div>
