<?php

//a copier en cas de probleme : <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FightersTable
 *
 * @author leslie
 */

namespace App\Model\Table;

use Cake\ORM\Table/* Registry */;
use Cake\ORM\TableRegistry;

class FightersTable extends Table {

    function test() {
        return 'ok';
    }

    public function getBestFighter() {
        $max = $this->find()->max('level')->toArray();
        $figterlist = $this->find('all')->where(['level =' => ($max['level'])]);
        return $figterlist;
    }

    public function createFighter($nom, $joueur) {


        //initialisation des coordonnées de départ (susceptibles d'etre modifiées)
        $x = 0;
        $y = 0;

        //création d'un nouveau tuple
        $table = TableRegistry::get('Fighters'/* ,['className' => 'FightersTable'] */);
        $combattant = $table->newEntity();

        //remplissage des attributs de ce nouveau tuple
        $combattant->name = $nom;
        $combattant->player_id = $joueur;
        $combattant->coordinate_x = $x;
        $combattant->coordinate_y = $y;
        $combattant->level = 1;
        $combattant->xp = 0;
        $combattant->skill_sight = 0;
        $combattant->skill_strength = 1;
        $combattant->skill_health = 3;
        $combattant->current_health = 3;
        //propriétés ayant une valeur par défaut (à gérer ultérieurement)
        //$combattant->next_action_time=1; //a modifier quand on en sera à la gestion temporelle
        //$combattant->guild_id;
        //insertion du nouveau tuple
        $table->save($combattant);

        //à améliorer : tester la réussite pour informer l'utilisateur de la réussite de l'opération
    }

    public function deleteFighter($id) {
        //Comme l'id du Fighter n'est clé étrangère que pour les message et équipements non-implémentés ici,
        //la méthode de répercussion de la suppression d'un combattant (ie en cascade ou non, passage à null...) importe peu
        $table = TableRegistry::get('Fighters');
        $asuppr = $table->get($id);
        $success = $table->delete($asuppr);

        //à améliorer : utiliser $success pour informer d'utilisateur de la réussite de l'opération
    }

    public function getFightersForUser($userid) {
        //on laisse la possibilité pour plus tard de récupérer plusieurs combattants par joueurs
        $fighters = $this->find()->where(['player_id' => $userid])->toArray();
        return $fighters;
    }

    public function attack($attId, $defId) {
        //$table = TableRegistry::get('Fighters');
        $att = $this->get($attId);
        $def = $this->get($defId);
        //test pour toucher ;
        $dice = rand(20, 1);
        pr($dice);
        if (10 + $def['level'] - $att['level'] >= $dice) {
            $def['skill_health'] -= $att['skill_strength'];
            //xp pour attaque réussi
            $att['xp'] += 1;
            //appel updateFighter pour $def
            $this->updateFighter($def);
            //test si tué
            if ($def['skill_health'] <= 0) {
                //xp pour tué
                $att['xp'] += $def['level'];
                $this->deleteFighter($defId);
                //appel eventTue
            } else {
                //appel eventBlesse
            }
            //appel updateFighter pour $att
            $this->updateFighter($att);
        } else {
            //appel eventRate
        }
        pr($def['skill_health']);
    }

    public function updateFighter($fighter) {
        $table = TableRegistry::get('Fighters');
        $table->save($fighter);
    }

    public function levelUp($id, $comp) {
        //récupération du tuple
        $table = TableRegistry::get('Fighters');
        $amodif = $table->get($id);
        //augmentation de niveau
        $amodif->level += 1;
        //amélioration de la caractéristique choisie
        switch ($comp) {
            case "vue" :
                $amodif->skill_sight +=1;
                break;
            case "force" :
                $amodif->skill_strength +=1;
                break;
            case "vie" :
                $amodif->skill_health +=3;
                break;
        }
        //sauvegarde des modifications
        $table->save($amodif);
    }

    public function mayLevelUp($id) {
        $table = TableRegistry::get('Fighters');
        $combattant = $table->get($id);

        if ($combattant->xp % 4 == 0 && $combattant->xp != 0) {
            return TRUE;
        }
        return FALSE;
    }
    
    public function canSee($arena, $id){
        $mask = $arena;
        $fighter = $this->get($id);
        $x = $fighter['coordinate_x'];
        $y = $fighter['coordinate_y'];
        $sight = $fighter['skill_sight'];
        for ($row = 0; $row < 15; $row++) {
            for ($col = 0; $col < 10; $col++) {
                if(abs($row-$x) <= $sight && abs($col-$y) <= $sight){
                    $mask[$row][$col] = "#";
                }
            }
        }
        //pr($mask);
        return $mask;
    }
    
    public function validMove($x, $y, $arena, $id){
        $valid = false;
        if($x >= 0 && $y >= 0 && $x < 15 && $y < 10){
            pr("dans les bornes");
            if($arena[$x][$y] == '_'){
                pr("valid");
                $valid = true;
            }else {
                $this->attack($id ,$arena[$x][$y]);
            }
        }
        return $valid;
    }
    public function move($direction, $id, $arena){
        $fighter = $this->get($id);
        $x = $fighter['coordinate_x'];
        $y = $fighter['coordinate_y'];
        switch ($direction) {
            case 'N' :
                $x -= 1;
                break;
            case 'S' :
                $x += 1;
                break;
            case 'W' :
                $y -= 1;
                break;
            case 'E' :
                $y += 1;
                break;
        }
        pr("move");
        if($this->validMove($x, $y, $arena, $id)){
            pr("validmove");
            $fighter['coordinate_x'] = $x;
            $fighter['coordinate_y'] = $y;
            $this->updateFighter($fighter);
        }
        /*if($arena[$fighter['coordinate_x']][$fighter['coordinate_y']] == "_"){
            $this->updateFighter($fighter);
        }else {
            $def = $this->get($arena[$fighter['coordinate_x']][$fighter['coordinate_y']])['id'];
            $this->attack(fighter['id'], $def);
        }*/
    }
}
