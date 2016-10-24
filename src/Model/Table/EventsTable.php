<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\Table;

/**
 * Description of EventsTable
 *
 * @author leslie
 */
namespace App\Model\Table;

use Cake\ORM\Table;

class EventsTable extends Table{
   public function createEvent(){
       
 +        $tableFighters= TableRegistry::get('Fighters');
          $tableEvents= TableRegistry::get('Events');
          $event = $tableEvents->newEntity();
          
          //remplissage des attributs de ce nouveau tuple
 +        $event->name = ;
 +        $event->date = now();
 +        $event->coordinate_x = $tableFighters->coordinate_x ;
 +        $event->coordinate_y =$tableFighters->coordinate_y ;
          
          //insertion du nouveau tuple
 -        //$table->save($combattant);
 +        $tableEvents->save($event);
      }
}
