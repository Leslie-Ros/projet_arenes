<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Error\Debugger;

class PlayersController extends AppController
{
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
         $this->Auth->allow(['add', 'logout']);
    }
//
//     public function index()
//     {
//        $this->set('players', $this->Players->find('all'));
//    }
//
//    public function view($id)
//    {
//        $players = $this->Players->get($id);
//        $this->set(compact('players'));
//    }

    public function add()
    {
        $player = $this->Players->newEntity();
        if ($this->request->is('post')) {
            $player = $this->Players->patchEntity($player, $this->request->data);
            if ($this->Players->save($player)) {
                $this->Flash->success(__("L'utilisateur a été sauvegardé."));
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__("Impossible d'ajouter l'utilisateur."));
        }
        $this->set('player', $player);
    }
    
     public function login()
    {
        if ($this->request->is('post')) {
            debug($this->Auth->identify());
            $player = $this->Auth->identify();
            Debugger::dump($player);
            if ($player) {
                $session = $this->request->session();
                $session->write('User.payer_id', $player['id']);
                $this->Auth->setUser($player);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        $this->Flash->success(__("Vous êtes maintenant déconnecté."));
        $this->request->session()->delete('User.payer_id');
        return $this->redirect($this->Auth->logout());
    }

}
