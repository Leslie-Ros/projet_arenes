<<<<<<< HEAD
<?php $this->assign('title', 'accueil');?>
=======
    <?= $this->Html->css('index.css',['block' => true]) ?>
>>>>>>> a8338b43e2492b7eb77860d5fcb5b48ef48dbf65

<section id="texte">
<p><h1>DÉCOUVRE LE JEU MULTIJOUEUR QUI RÉUNIT
LES PLUS GRANDS GUERRIERS SUR UNE ARENE !</h1> </p>


<div id="texte1">
<p>WebArena captive déjà des centaines de milliers de joueurs</br> qui tentent tous, sûrement comme toi, d'élaborer les meilleures</br> stratégies et d’être le meilleur combattant.</p>
<div class="texte2"><p> Ce jeu est porté sur la compétition qui mettra à l'épreuve tes talents et tes réflexion.</p></div>


<p id="police">CASSE-LEUR LA FIGURE EN LIGNE !</p>




<div class="texte2">
<p>Défie des joueurs du monde entier dans un jeu en ligne qui mêle stratégie et batailles !</br> Crée ton propre héros, prépare tes coups... et FRAPPE FORT !</p>

<p>Gagne un maximum de point d’expérience et augmente tes caractéristiques !</p>

<p>Grâce à cette arène en ligne, retrouve les sensations fortes en affrontant des joueurs du monde entier !</p>


<p> <?php echo $this->Html->link('> à toi de jouer ! <', array('controller' => 'Arenas', 'action' => 'login')); ?> </p>
</div>
</section>

