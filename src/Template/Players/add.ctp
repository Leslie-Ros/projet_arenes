<!-- src/Template/Users/add.ctp -->
<?php $this->assign('title', 'Inscription');?>

<div class="users form">
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Ajouter un utilisateur') ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
<?= $this->Form->button(__('Ajouter')); ?>
<?= $this->Form->end() ?>
</div>
