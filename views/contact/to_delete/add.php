<?php use yii\helpers\Html; ?>

<?php echo Html::beginForm(['contact/add'], 'post'); ?>

<?php echo 'Наименование контакта: '.Html::input('text', 'name', '') ?><br/>
<?php echo 'Телефон: '.Html::input('text', 'phone', '') ?><br/>
<?php echo Html::submitButton('Добавить', ['class' => 'submit']); ?>

<?php echo Html::endForm() ?>
