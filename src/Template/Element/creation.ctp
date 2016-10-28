<html>
    <h2>Création d'un combattant</h2>
    
<?php 
echo $this->Form->create('Fighters');
echo $this->Form->input('name');
echo $this->Form->button('Valider');
echo $this->Form->end();

 ?>

</html>