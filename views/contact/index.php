<?php
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Contact;
use app\models\Phone;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Phonebook - List';
?>
<div class="site-index">
	<h1>Контакты</h1>
	<input type="button" value="Добавить контакт" id="add_contact" class="btn btn-primary"/><br/><br/>
	<input type="text" placeholder="Наименование или телефон" id="search_contact" class="form-control" style="width: 200px; display: inline-block;"/>
	<input type="button" value="Сброс" id="reset_search" class="btn btn-default	"/><br/><br/>
	
	<div id="contacts_container">
		<table id="contacts_table">
			<tr>
				<th>Наименование</th>
				<th>Телефоны</th>
				<th>Действия</th>
			</tr>			
		</table>
	</div>
	
	<!-- Modal "AddPhone" START -->
	<div class="modal fade" id="modalAddPhone" tabindex="-1" role="dialog" aria-labelledby="modalAddPhoneLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalAddPhoneLabel">Добавить телефон</h4>
				</div>
				<div class="modal-body" id="modalAddPhoneBody">

					<?php
					$phone = new Phone();
					$form = ActiveForm::begin([
						'id' => 'addphone',
						'method' => 'post',
						'action' => ['contact/addphone'],
					]); ?>

					<?php 
						echo $form->field($phone, 'contact_id')->hiddenInput(['id' => 'addphone_contact_id'])->label(''); // hiddenInput
						echo $form->field($phone, 'phone')->textInput(['id' => 'addphone_phone'])->hint('Номер телефона (только цифры)')->label('Телефон');
					?>
					 
					<?php echo Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>

					<?php ActiveForm::end() ?>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Modal "AddPhone" Errors END -->
	
	<!-- Modal "EditContact" START -->
	<div class="modal fade" id="modalEditContact" tabindex="-1" role="dialog" aria-labelledby="modalEditContactLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalEditContactLabel">Редактировать контакт</h4>
				</div>
				<div class="modal-body" id="modalEditContactBody">

					<?php
					$contact = new Contact();
					$form = ActiveForm::begin([
						'id' => 'editcontact',
						'method' => 'post',
						'action' => ['contact/update'],
					]); ?>

					<?php 
						echo $form->field($contact, 'id')->hiddenInput(['id' => 'editcontact_id'])->label(''); // hiddenInput
						echo $form->field($contact, 'name')->textInput(['id' => 'editcontact_name'])->hint('Наименование контакта')->label('Контакт');
					?>
					 
					<?php echo Html::submitButton('Редактировать', ['class' => 'btn btn-primary']); ?>

					<?php ActiveForm::end() ?>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Modal "EditContact" Errors END -->	
	
	<!-- Modal "AddContact" START -->
	<div class="modal fade" id="modalAddContact" tabindex="-1" role="dialog" aria-labelledby="modalAddContactLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modalAddContactLabel">Добавить контакт</h4>
				</div>
				<div class="modal-body" id="modalAddContactBody">

					<?php echo Html::beginForm(['contact/add'], 'post'); ?>

					
					<?php echo '<label class="control-label">Наименование контакта</label>'.Html::input('text', 'name', '', ['class' => 'form-control']) ?><br/>
					<?php echo '<label class="control-label">Телефон</label>'.Html::input('text', 'phone', '', ['class' => 'form-control']) ?><br/>
					
					<?php echo Html::submitButton('Добавить', ['class' => 'btn btn-primary']); ?>

					<?php echo Html::endForm() ?>
					
				</div>
			</div>
		</div>
	</div>
	<!-- Modal "EditContact" Errors END -->		
</div>
