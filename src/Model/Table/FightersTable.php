<?php

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

use Cake\ORM\Table;

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
}