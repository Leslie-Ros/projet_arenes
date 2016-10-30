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
class ArenasController extends AppController {

    public function index() {
        
    }

    public function login() {
        
    }

    public function fighter() {
        $this->loadModel('Fighters');
        $userid = 'fb14a4c2-9aea-11e6-988d-ac220b153e06'; //à changer : récupérer l'iduser lors de la connexion
        $persos = $this->Fighters->getFightersForUser($userid);
        
        //Exemple d'utilisation de la fonction createFighter
        //$this->Fighters->createFighter('Mononoke', '545f827c-576c-4dc5-ab6d-27c33186dc3e');
        //Exemple d'utilisation de la fonction deleteFighter
        //$this->Fighters->deleteFighter(3);
        //Exemple d'utilisation de la fonction createFighter
        //$this->Fighters->createFighter('Sheeta', 'fb14a4c2-9aea-11e6-988d-ac220b153e06');
        //Exemple d'utilisation de la fonction deleteFighter
        //$this->Fighters->deleteFighter(3);
        //Exemple d'utilisation de la fonction levelUp
        //$this->Fighters->levelUp(4, "vie");
        
        
        //traitement des formulaires
        if($this->request->is('post'))
        {
            //pr($this->request->data);
            switch ($this->request->data['idform']){
                case 'creation' :
                    if (!empty($this->request->data['name'])){
                        $this->Fighters->createFighter($this->request->data['name'], $userid);
                    }
                    break;
                case 'levelup':
                    $this->Fighters->levelUp($persos[0]['id'],$this->request->data['competence']);
                    break;
            }
        }

        //AFFICHAGE DE LA PAGE
        //Soit le joueur a un personnage et on lui propose toutes les actions associées,
        //soit il n'en a pas et on lui propose d'en créer un
        $persos = $this->Fighters->getFightersForUser($userid);
        if (empty($persos)) {
            $this->set('hasFighter', FALSE);
        } else {
            $this->set('hasFighter', TRUE);
            $this->set('combattant', $persos[0]);
            $this->set('mayLevelUp', $this->Fighters->mayLevelUp($persos[0]->id));
        }
        
    }
    
    public function sight() {
        //initialiser arena
        $this->loadModel('Fighters');
        $arena = $this->Fighters->createArena();
        
        //post traitemnt
        if ($this->request->is("post")) {
            //pr($this->request->data);
            $this->Fighters->move($this->request->data['direction'], 1, $arena);
            //1 id du fighter, à changer par $this->request->session->read($fighterId)
            $arena = $this->Fighters->createArena();
        }
        $mask = $this->Fighters->canSee($arena, 1);
        //$this->Fighters->attack(1,1); a force de tester j'ai tué aragorn
        //1 id du fighter, à changer par $this->request->session->read($fighterId)
        //pr($arena);
        $this->set('mask', $mask);
        $this->set('arena', $arena);
    }

    //Exemple d'utilisation de la fonction createFighter
    //$this->Fighters->createFighter('Mononoke', '545f827c-576c-4dc5-ab6d-27c33186dc3e');
    //Exemple d'utilisation de la fonction deleteFighter
    //$this->Fighters->deleteFighter(3);

    public function diary() {
        $this->loadModel('Fighters');
        $f= $this->Fighters->getBestFighter()->toArray();
        pr($f);
        $this->loadModel('Events');
        $this->Events->createEventDeath($f[0],$f[0]);
        $this->Events->displayEvents($f[0]['id']);
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