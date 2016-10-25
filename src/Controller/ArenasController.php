<?php
//à inserer : <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
namespace App\Controller;
use App\Controller\AppController;
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
    
    $persos=$this->Fighters->getFightersForUser('truc');
    pr($persos);

}
public function sight()
{
	$arena = array();
        //initialiser $arena
        for ($row = 0; $row < 15; $row++) {
            for ($col = 0; $col < 10; $col++) {
                $arena[$row][$col] = '_';
            }
        }
        //récupérer les personnages
        $this->loadModel('Fighters');
        $fightersList = $this->Fighters->getFightersForUser('545f827c-576c-4dc5-ab6d-27c33186dc3e');
        //peupler $arena avec les personnages
        foreach ($fightersList as $value) {
            $arena[$value['coordinate_x']][$value['coordinate_y']] = $value['id'];
        }
        //pr($arena);
        $this->set('arena', $arena);
}
public function diary()
{

}
}
?>