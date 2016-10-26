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
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;

class EventsTable extends Table {

    public function createEventDeath($fighter, $enemy) {
 
        $tableEvents = TableRegistry::get('Events');
        $event = $tableEvents->newEntity();
$time = Time::now();
$time->setTimezone(new \DateTimeZone('Europe/Paris'));


        //remplissage des attributs de ce nouveau tuple
        $event->name = $fighter['name'].' attaque '.$enemy['name'].' et le tue.';
        $event->date =$time;
        $event->coordinate_x =$fighter['coordinate_x'];
        $event->coordinate_y =$fighter['coordinate_y'];

        //insertion du nouveau tuple
        $tableEvents->save($event);
    }
    
    public function createEventMiss($fighter, $enemy) {

        
        $tableEvents = TableRegistry::get('Events');
        $event = $tableEvents->newEntity();
$time = Time::now();
$time->setTimezone(new \DateTimeZone('Europe/Paris'));


        //remplissage des attributs de ce nouveau tuple
        $event->name = $fighter['name'].' attaque '.$enemy['name'].' et le rate.';
        $event->date= $time;
        $event->coordinate_x =$fighter['coordinate_x'];
        $event->coordinate_y =$fighter['coordinate_y'];

        //insertion du nouveau tuple
        $tableEvents->save($event);
    }
    
    public function createEventHurt($fighter, $enemy) {

        
        $tableEvents = TableRegistry::get('Events');
        $event = $tableEvents->newEntity();
$time = Time::now();
$time->setTimezone(new \DateTimeZone('Europe/Paris'));


        //remplissage des attributs de ce nouveau tuple
        $event->name = $fighter['name'].' attaque '.$enemy['name'].' et le blesse.';
        $event->date =$time;
        $event->coordinate_x =$fighter['coordinate_x'];
        $event->coordinate_y =$fighter['coordinate_y'];

        //insertion du nouveau tuple
        $tableEvents->save($event);
    }
    
    public function createEventAdd($fighter) {

        
        $tableEvents = TableRegistry::get('Events');
        $event = $tableEvents->newEntity();
$time = Time::now();
$time->setTimezone(new \DateTimeZone('Europe/Paris'));


        //remplissage des attributs de ce nouveau tuple
        $event->name = $fighter['name'].' intègre l arène';
        $event->date =$time;
        $event->coordinate_x =$fighter['coordinate_x'];
        $event->coordinate_y =$fighter['coordinate_y'];

        //insertion du nouveau tuple
        $tableEvents->save($event);
    }
    
    public function createEventQuit($fighter) {

        
        $tableEvents = TableRegistry::get('Events');
        $event = $tableEvents->newEntity();
$time = Time::now();
$time->setTimezone(new \DateTimeZone('Europe/Paris'));


        //remplissage des attributs de ce nouveau tuple
        $event->name = $fighter['name'].' quitte l arène';
        $event->date =$time;
        $event->coordinate_x =$fighter['coordinate_x'];
        $event->coordinate_y =$fighter['coordinate_y'];

        //insertion du nouveau tuple
        $tableEvents->save($event);
    }

    public function displayEvents($fighterId) {

        $tableFighters = TableRegistry::get('Fighters');
        $tableEvents = TableRegistry::get('Events');
                $fighter=$tableFighters->get($fighterId);
        $sight=$fighter['skill_sight'];
        $x=$fighter['coordinate_x'];
        $y=$fighter['coordinate_y'];
//        $time = Time::now();
//$time->setTimezone(new \DateTimeZone('Europe/Paris'));
//$time->modify('-24 hours');
        $datelist=$this->find('all');
        foreach($datelist as $value){
//            $event=$tableEvents->get($date);
            $xe=$value['coordinate_x'];
            $ye=$value['coordinate_y'];
            if($value['date']->wasWithinLast(1) and ($xe <= ($x+$sight)) and ($xe >= ($x-$sight)) and ($ye <= ($y+$sight)) and ($ye >= ($y-$sight))){
                echo $value; 
        }}

//        foreach ($datelist as $date){
//            $event=$tableEvents->get($date);
//            $xe=$event['coordinate_x'];
//            $ye=$event['coordinate_y'];
//            if (($xe <= ($x+$sight)) and ($xe <= ($x-$sight)) and ($ye <= ($y+$sight)) and ($ye <= ($y-$sight))) 
//            echo $event;
//        }
        
        
        
 
    }
    

}
