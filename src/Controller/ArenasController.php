<?php

//à inserer : <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

namespace App\Controller;

use App\Controller\AppController;

/**
 * Personal Controller
 * User personal interface
 *
 */
class ArenasController extends AppController {

    public function index() {
        $this->loadModel('Fighters');
        $figterlist = $this->Fighters->find('all');
        pr($figterlist->toArray());
    }

    public function login() {
        
    }

    public function fighter() {
        $this->loadModel('Fighters');

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

        $userid = 'fb14a4c2-9aea-11e6-988d-ac220b153e06'; //à changer : récupérer l'iduser lors de la connexion
        $persos = $this->Fighters->getFightersForUser($userid);
        //Soit le joueur a un personnage et on lui propose toutes les actions associées,
        //soit il n'en a pas et on lui propose d'en créer un
        if (empty($persos)) {
            $this->set('hasFighter', FALSE);
        } else {
            $this->set('hasFighter', TRUE);
            $this->set('combattant', $persos[0]);
            $this->set('mayLevelUp', $this->Fighters->mayLevelUp($persos[0]->id));
        }
    }

    //creer l'arène
    public function creerArena(){
        $arena = array();
        for ($row = 0; $row < 15; $row++) {
            for ($col = 0; $col < 10; $col++) {
                $arena[$row][$col] = '_';
            }
        }
        $this->loadModel('Fighters');
        $fightersList = $this->Fighters->getFightersForUser('545f827c-576c-4dc5-ab6d-27c33186dc3e');
        //peupler $arena avec les personnages
        foreach ($fightersList as $value) {
            $arena[$value['coordinate_x']][$value['coordinate_y']] = $value['id'];
        }
        return $arena;
    }
    
    public function sight() {
        //initialiser arena
        $arena = $this->creerArena();
        
        if ($this->request->is("post")) {
            //pr($this->request->data);
            $this->Fighters->move($this->request->data['direction'], 1, $arena);
            //1 id du fighter, à changer par $this->request->session->read($fighterId)
            $arena = $this->creerArena();
        }

        $mask = $this->Fighters->canSee($arena, 1);
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