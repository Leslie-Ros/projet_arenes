<?php
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
/*$this->loadModel('Fighters');
$figterlist=$this->Fighters->find('all');
pr($figterlist->toArray());*/
}
public function login()
{

}
public function fighter()
{
$this->loadModel('Fighters');
$resultat=$this->Fighters->test();
$this->set('var',$resultat );
$bestfighter=$this->Fighters->getBestFighter()->toArray();
$this->set('bestfighter',$bestfighter );

}
public function sight()
{

}
public function diary()
{

}
}
?>