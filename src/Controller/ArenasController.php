<?php

//à inserer : <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Error\Debugger;
use Cake\I18n\Time;

/**
 * Personal Controller
 * User personal interface
 *
 */
class ArenasController extends AppController {

    public function index() {
//        $this->loadModel('Fighters');
//        $figterlist = $this->Fighters->find('all');
//        pr($figterlist->toArray());
//        $this->set('players', $this->Players->find('all'));
    }

    public function fighter() {
        $this->loadModel('Fighters');
        //$userid = 'e15d495a-1bad-4f63-aaaa-52be03c8f72d'; //à changer : récupérer l'iduser lors de la connexion
        //s'il n'y a pas d'utilisateur connecté on redirige de suite vers le login
        if ($this->request->session()->check('User.player_id')) {
            $userid = $this->request->session()->read('User.player_id');
            $persos = $this->Fighters->getFightersForUser($userid);
        } else {
            //rediriger vers login (n'est pas censé se produire)
            $userid = 'e15d495a-1bad-4f63-aaaa-52be03c8f72d'; //provisoire pour ne pas crash
            pr("Nous n'etes pas co");
        }

        //traitement des formulaires
        if ($this->request->is('post')) {
            //pr($this->request->data);
            switch ($this->request->data['idform']) {
                case 'creation' :
                    if (!empty($this->request->data['name'])) {
                        $arena = $this->Fighters->createArena(); //on crée une arène virtuelle pour savoir où il est possible de placer le nouveau personnage
                        $this->Fighters->createFighter($this->request->data['name'], $userid, $arena);
                    }
                    break;
                case 'levelup':
                    $this->Fighters->levelUp($persos[0]['id'], $this->request->data['competence']);
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
            $this->request->session()->write('User.fighter_id', $persos[0]['id']); //A CHANGER SI PERSOS MULTIPLES
            $this->set('hasFighter', TRUE);
            $this->set('combattant', $persos[0]);
            $this->set('mayLevelUp', $this->Fighters->mayLevelUp($persos[0]->id));
        }
    }

    public function sight() {
        //if($this->Session->read('lastTime') <= );
        //initialiser arena
        $this->loadModel('Fighters');
        $this->loadModel('Events');
        $arena = $this->Fighters->createArena();
        $this->set('largeur', $this->Fighters->largeur);
        $this->set('longueur', $this->Fighters->longueur);
        /* $this->Fighters->hasActionPoints(1);
          $this->Fighters->removeActionPoint(1); */

        //post traitemnt
        $log = "Bienvenue !";
        $fid = $this->request->session()->read('User.fighter_id');
        if ($this->request->is("post")) {
            //pr($this->request->data);
            if ($this->Fighters->hasActionPoints($fid)) {
                //pr('form');$this->request->session()->read('User.fighter_id')
                $this->Fighters->move($this->request->data['direction'], $fid, $arena);
                //1 id du fighter, à changer par $this->request->session->read($fighterId)
                $arena = $this->Fighters->createArena();
                $log = $this->Events->getLastEvent()->toArray()['name'];
            }
        }
        $mask = $this->Fighters->canSee($arena, $fid);
        $this->set('mask', $mask);
        $this->set('arena', $arena);
        $this->set('ap', $this->Fighters->hasActionPoints($fid));
        $this->set('log', $log);
    }

    //Exemple d'utilisation de la fonction createFighter
    //$this->Fighters->createFighter('Mononoke', '545f827c-576c-4dc5-ab6d-27c33186dc3e');
    //Exemple d'utilisation de la fonction deleteFighter
    //$this->Fighters->deleteFighter(3);

    public function diary() {
        //test
        $this->loadModel('Events');
        $this->loadModel('Fighters');
        $tableFighters = TableRegistry::get('Fighters');
        //  $this->Events->createEventDeath($fighter,$enemy);
        $this->set('event', $this->Events->displayEvents($this->request->session()->read('User.fighter_id')));
    }

}

?>