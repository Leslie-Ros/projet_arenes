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
    //Exemple d'utilisation de la fonction levelUp
    //$this->Fighters->levelUp(2);

    
    $userid='545f827c-576c-4dc5-ab6d-27c33186dc3e'; //à changer : récupérer l'iduser lors de la connexion
    $persos=$this->Fighters->getFightersForUser($userid);
    //Soit le joueur a un personnage et on lui propose toutes les actions associées,
    //soit il n'en a pas et on lui propose d'en créer un
    if (empty($persos)){
        $this->set('hasFighter',FALSE);
    }
    else{
        $this->set('hasFighter',TRUE);
        $this->set('combattant', $persos[0]);
    }

}
public function sight()
{

}
public function diary()
{

}
}
?>