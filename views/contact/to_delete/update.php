<?php use yii\helpers\Html; ?>

<?php echo Html::beginForm(['contact/update', 'id' => $id], 'post'); ?>

<?php echo Html::input('hidden', 'id', $id) ?><br/>
<?php echo 'Наименование контакта: '.Html::input('text', 'name', $model->name) ?><br/>
<?php foreach($model->phones as $phone): ?>
	<?php echo Html::a('Удалить телефон '.$phone->phone, ['contact/deletephone', 'id' => $phone->id]); ?><br/>
<?php endforeach; ?>
<?php echo Html::submitButton('Редактировать', ['class' => 'submit']); ?>

<?php echo Html::endForm() ?>
