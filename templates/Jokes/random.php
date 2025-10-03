<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $joke
 * @var string|null $error
 */
?>
<div class="jokes random">
    <h2><?= __('Chuck Norris Random Joke') ?></h2>
    
    <?php if ($error): ?>
        <div class="alert alert-danger">
            <?= h($error) ?>
        </div>
    <?php elseif ($joke): ?>
        <blockquote class="blockquote">
            <p><?= h($joke) ?></p>
        </blockquote>
        
        <?= $this->Form->create(null, ['type' => 'post']) ?>
        <?= $this->Form->hidden('setup', ['value' => $joke]) ?>
        <?= $this->Form->hidden('punchline', ['value' => '']) ?>
        <div class="form-group">
            <?= $this->Form->button(__('Guardar'), ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
            <?= $this->Html->link(__('Nuevo Chiste'), ['action' => 'newJoke'], ['class' => 'btn btn-secondary']) ?>
        </div>
        <?= $this->Form->end() ?>
    <?php else: ?>
        <p><?= __('No se pudo obtener un chiste. Inténtalo de nuevo.') ?></p>
        <?= $this->Html->link(__('Intentar de nuevo'), ['action' => 'random'], ['class' => 'btn btn-primary']) ?>
    <?php endif; ?>
</div>