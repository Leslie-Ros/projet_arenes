<html>
    <h2>Création d'un combattant</h2>
    
<?php 
use Cake\ORM\TableRegistry;
$table = TableRegistry::get('Fighters');
$nouv = $table->newEntity();
echo $this->Form->create($nouv);
echo $this->Form->input('name');
echo $this->Form->button('Valider');
echo $this->Form->end();

 ?>

</html>