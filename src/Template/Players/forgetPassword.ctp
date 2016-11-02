<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __("Entrez votre email") ?></legend>
        <?= $this->Form->input('email') ?>
    </fieldset>
<?= $this->Form->button(__('Envoyer')); ?>
<?= $this->Form->end() ?>