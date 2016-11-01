<!-- src/Template/Users/login.ctp -->
<?php $this->assign('title', 'Connexion');?>

<div class="users form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __("Merci de rentrer vos nom d'utilisateur et mot de passe") ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
<?= $this->Form->button(__('Se Connecter')); ?>
<?= $this->Form->end() ?></div>
<div id="cogoogle">
 <a href="<?php echo $this->Url->build([
                'controller' => 'Players',
                'action' => 'googleLogin'
            ]); ?>" class="btn btn-lg btn-primary">Se connecter avec Google+</a>

</div>
