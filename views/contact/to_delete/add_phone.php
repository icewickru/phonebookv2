<?php 
	use yii\helpers\Html; 
	use yii\widgets\ActiveForm;
?>

<?php
$form = ActiveForm::begin([
    'id' => 'addphone',
	'method' => 'post',
	'action' => ['contact/addphone'],
]); ?>

<?php 
	echo $form->field($phone, 'contact_id')->hiddenInput()->label('');
	echo $form->field($phone, 'phone')->textInput()->hint('Номер телефона (только цифры)')->label('Телефон');
?>
 
<?php echo Html::submitButton('Добавить', ['class' => 'submit']); ?>

<?php ActiveForm::end() ?>
