<?php use yii\helpers\Html; ?>

<?php echo Html::beginForm(['contact/addphone'], 'post'); ?>

<?php echo Html::input('hidden', 'contact_id', Yii::$app->request->get('id')); ?><br/>
<?php echo 'Телефон: '.Html::input('text', 'phone', '') ?><br/>
<?php echo Html::submitButton('Добавить', ['class' => 'submit']); ?>

<?php echo Html::endForm() ?>
