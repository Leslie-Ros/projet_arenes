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

use Cake\ORM\Table/*Registry*/;
use Cake\ORM\TableRegistry;

class FightersTable extends Table
{
    function test(){
        return 'ok';
    }
    
    public function getBestFighter()
    {
        $max=$this->find()->max('level')->toArray();
        $figterlist=$this->find('all')->where(['level =' => ($max['level'])]);
        return $figterlist;
    }

    public function createFighter($nom, $joueur){
        
        
        //initialisation des coordonnées de départ (susceptibles d'etre modifiées)
        $x=0; $y=0;
        
        //création d'un nouveau tuple
        $table = TableRegistry::get('Fighters'/*,['className' => 'FightersTable']*/);
        $combattant = $table->newEntity();
        
        //remplissage des attributs de ce nouveau tuple
        $combattant->name = $nom;
        $combattant->player_id = $joueur;
        $combattant->coordinate_x = $x;
        $combattant->coordinate_y = $y;
        $combattant->level = 1;
        $combattant->xp=0;
        $combattant->skill_sight=0;
        $combattant->skill_strength=1;
        $combattant->skill_health=3;
        $combattant->current_health=3;
        //propriétés ayant une valeur par défaut (à gérer ultérieurement)
        //$combattant->next_action_time=1; //a modifier quand on en sera à la gestion temporelle
        //$combattant->guild_id;
        
        //insertion du nouveau tuple
        $table->save($combattant);
        
        //à améliorer : tester la réussite pour informer l'utilisateur de la réussite de l'opération
    }
    
    public function deleteFighter($id){
        //Comme l'id du Fighter n'est clé étrangère que pour les message et équipements non-implémentés ici,
        //la méthode de répercussion de la suppression d'un combattant (ie en cascade ou non, passage à null...) importe peu
        $table = TableRegistry::get('Fighters');
        $asuppr=$table->get($id);
        $success=$table->delete($asuppr);
    
        //à améliorer : utiliser $success pour informer d'utilisateur de la réussite de l'opération
    }
    
    public function getFightersForUser($userid){
        //on laisse la possibilité pour plus tard de récupérer plusieurs combattants par joueurs
        $fighters=$this->find()->where(['player_id' => $userid])->toArray();
        
        return $fighters;
    }
}