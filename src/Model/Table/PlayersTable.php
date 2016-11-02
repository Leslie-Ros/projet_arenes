<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

/**
 * Description of PlayersTable
 *
 * @author leslie
 */
use Cake\ORM\Table;
use Cake\Validation\Validator;

class PlayersTable extends Table {

    public function validationDefault(Validator $validator) {
        return $validator
                        ->notEmpty('username', "Un nom d'utilisateur est nécessaire")
                        ->notEmpty('password', 'Un mot de passe est nécessaire');
    }

    public function chaine_aleatoire($nb_car, $chaine ) {
        $nb_lettres = strlen($chaine) - 1;
        $generation = '';
        for ($i = 0; $i < $nb_car; $i++) {
            $pos = mt_rand(0, $nb_lettres);
            $car = $chaine[$pos];
            $generation .= $car;
        }
        return $generation;
    }

    
    public function findByEmail($email){
       $player= $this->find('all')
                ->where(['email ='=>$email])
                ->first();
       return $player;
       
    }
}
