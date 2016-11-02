<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
   

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    
    
</head>
<body>

    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><a href=""><?= $this->fetch('title') ?></a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
                <li><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></li>
            </ul>
        
        <ul class="header">  
<li><?php echo $this->Html->link('Accueil', '/'); ?></li>
<li><?php echo $this->Html->link("Jouer", array('controller' => 'Arenas', 'action' => 'sight')); ?></li>
<li><?php echo $this->Html->link("Combattant", array('controller' => 'Arenas', 'action' => 'fighter')); ?></li>
   <li>    <?php echo $this->Html->link('Se connecter', array('controller' => 'Players', 'action' => 'login')); ?></li>
<li><?php echo $this->Html->link("S'inscrire", array('controller' => 'Players', 'action' => 'add')); ?></li>
<li><?php echo $this->Html->link("Se déconnecter", array('controller' => 'Players', 'action' => 'logout')); ?></li>
<li><?php echo $this->Html->link("Journal", array('controller' => 'Arenas', 'action' => 'diary')); ?></li>


        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    
    <ul>
    <li id="gpop"><b>Groupe:</b> SI1 - <b>Options:</b> CG</li>
   <li id="auteur"> <b>Auteurs:</b> ROS, EA, MIENNE, DELONGEAS.</li>
<li><a href="<?php echo $this->Url->build([
                'controller' => 'webroot',
                'action' => 'versions.log'
            ]); ?>" class="btn btn-lg btn-primary">versions.log</a>
  </li> </ul>
   
    
    </footer>
</body>
</html>
