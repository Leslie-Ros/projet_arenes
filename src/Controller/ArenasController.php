<?php
//à inserer : <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
/**
* Personal Controller
* User personal interface
*
*/
class ArenasController  extends AppController
{
public function index()
{
$this->loadModel('Fighters');
$figterlist=$this->Fighters->find('all');
pr($figterlist->toArray());
}
public function login()
{

}
public function fighter()
{
$this->loadModel('Fighters');
//$resultat=$this->Fighters->test();
//$this->set('var',$resultat );
//$bestfighter=$this->Fighters->getBestFighter()->toArray();
//$this->set('bestfighter',$bestfighter );

    //Exemple d'utilisation de la fonction createFighter
    //$this->Fighters->createFighter('Mononoke', '545f827c-576c-4dc5-ab6d-27c33186dc3e');
    //Exemple d'utilisation de la fonction deleteFighter
    //$this->Fighters->deleteFighter(3);
}
public function sight()
{

}
public function diary()
{
    //test
//$this->loadModel('Events');
//$this->loadModel('Fighters');
//        $tableFighters = TableRegistry::get('Fighters');
//        $fighter= $tableFighters->get(1);
//        $enemy= $tableFighters->get(2);
//$this->Events->createEventDeath($fighter,$enemy);
//$this->Events->displayEvents(1);
}
}
?>