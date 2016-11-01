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
use Cake\I18n\Time;

class FightersTable extends Table {

    function test() {
        return 'ok';
    }
    
    var $largeur=15;
    var $longueur=10;
    var $maxAp = 3;
    var $delay = 10;

    public function getBestFighter() {
        $max = $this->find()->max('level')->toArray();
        $figterlist = $this->find('all')->where(['level =' => ($max['level'])]);
        return $figterlist;
    }

    public function createFighter($nom, $joueur, $arena) {

        //création d'un nouveau tuple
        $table = TableRegistry::get('Fighters'/* ,['className' => 'FightersTable'] */);
        $combattant = $table->newEntity();
        
        $x=0; $y=0;

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
        
        //initialisation des vraies coordonnées de départ
        $cpt = 500; //on évite la boucle infinie dans le cas où tout serait plein
        do {
            $combattant->coordinate_x = rand(0, $this->longueur-1);
            $combattant->coordinate_y = rand(0, $this->largeur-1);
            $cpt--;
        }while ($this->validMove($combattant->coordinate_x, $combattant->coordinate_y, $arena, $combattant->id) == FALSE && $cpt >1);
        
        //sauvegarde des modifications
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
    
    public function getAllFighters() {
        $fighters = $this->find('all')->toArray();
        return $fighters;
    }

    /**
     * Un fighter attaque un autre fighter
     * @param type $attId
     * @param type $defId
     */
    public function attack($attId, $defId) {
        //$table = TableRegistry::get('Fighters');
        $att = $this->get($attId);
        $def = $this->get($defId);
        $this->Events = TableRegistry::get('Events');
        //test pour toucher ;
        $dice = rand(20, 1);
        pr($dice);
        if (10 + $def['level'] - $att['level'] >= $dice) {
            $def['skill_health'] -= $att['skill_strength'];

            //xp pour attaque réussie
            $att['xp'] += 1;
            //appel updateFighter pour $def
            $this->updateFighter($def);
            //test si tué
            if ($def['skill_health'] <= 0) {
                //xp pour tué
                $att['xp'] += $def['level'];
                $this->deleteFighter($defId);
                $this->Events->createEventDeath($att, $def);
            } else {
                $this->Events->createEventHurt($att, $def);
            }
            //appel updateFighter pour $att
            $this->updateFighter($att);
        } else {
            $this->Events->createEventMiss($att, $def);
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
        //régénération des PV
        $amodif->current_health = $amodif->skill_health;
        //sauvegarde des modifications
        $table->save($amodif);
    }

    public function mayLevelUp($id) {
        $table = TableRegistry::get('Fighters');
        $combattant = $table->get($id);


        if ($combattant->xp >= 4 * $combattant->level) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * détermine le chant de vision d'un fighter
     * @param type $arena
     * @param type $id
     * @return string
     */
    public function canSee($arena, $id) {
        $mask = $arena;
        $fighter = $this->get($id);
        $x = $fighter['coordinate_x'];
        $y = $fighter['coordinate_y'];
        $sight = $fighter['skill_sight'];
        for ($row = 0; $row < $this->largeur; $row++) {
            for ($col = 0; $col < $this->longueur; $col++) {
                if (abs($row - $x) <= $sight && abs($col - $y) <= $sight) {
                    $mask[$row][$col] = "#";
                }
            }
        }
        //pr($mask);
        return $mask;
    }

    /**
     * vérifie si le mouvement est valid, tape l'ennemi le cas échéant
     * @param type $x
     * @param type $y
     * @param type $arena
     * @param type $id
     * @return boolean
     */
    public function validMove($x, $y, $arena, $id) {
        $valid = false;
        if ($x >= 0 && $y >= 0 && $x < $this->largeur && $y < $this->longueur) {
            pr("dans les bornes");
            if ($arena[$x][$y] == '_') {
                pr("valid");
                $valid = true;
            } else {
                $this->attack($id, $arena[$x][$y]);
            }
        }
        return $valid;
    }

    /**
     * déplacer un fighter 
     * @param type $direction
     * @param type $id
     * @param type $arena
     */
    public function move($direction, $id, $arena) {
        $fighter = $this->get($id);
        switch ($direction) {
            case 'N' :
                $fighter['coordinate_x'] -= 1;
                break;
            case 'S' :
                $fighter['coordinate_x'] += 1;
                break;
            case 'W' :
                $fighter['coordinate_y'] -= 1;
                break;
            case 'E' :
                $fighter['coordinate_y'] += 1;
                break;
        }
        pr("move");
        if ($this->validMove($fighter['coordinate_x'], $fighter['coordinate_y'], $arena, $id)) {
            pr("validmove");
            $this->updateFighter($fighter);
            $this->removeActionPoint($fighter['id']);
        }
    }

    //creer l'arène
    public function createArena() {
        $arena = array();
        for ($row = 0; $row < $this->largeur; $row++) {
            for ($col = 0; $col < $this->longueur; $col++) {
                $arena[$row][$col] = '_';
            }
        }
        $fightersList = $this->getAllFighters();
        //peupler $arena avec les personnages
        foreach ($fightersList as $value) {
            $arena[$value['coordinate_x']][$value['coordinate_y']] = $value['id'];
        }
        return $arena;
    }
    
    //vérifie si l'on a des points d'actions
    public function hasActionPoints($id) {
        $fighter = $this->get($id);
        $time = $fighter['next_action_time'];
        $ap = intval($time->diffInSeconds() / $this->delay);
        if ($ap > $this->maxAp) {
            $ap = $this->maxAp;
        }
        pr("has ".$ap);
        return $ap;
    }

    //enlève un point d'action et réajuste la date de référence (now - paRestants*delai secondes)
    public function removeActionPoint($id) {
        $fighter = $this->get($id);
        $ap = $this->hasActionPoints($fighter['id']);
        $ap -= 1;
        $time = Time::now();
        for ($i = 0; $i < $ap; $i++) {
            $time->subSeconds($this->delay);
        }
        $fighter['next_action_time'] = $time;
        $this->updateFighter($fighter);
        pr($ap);
    }
}
