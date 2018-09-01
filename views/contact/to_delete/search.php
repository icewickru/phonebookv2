<?php
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Contact;
use app\models\Phone;
use yii\helpers\Html;

$this->title = 'Phonebook';
?>
<div>
<?php echo 'Поиск по наименованию: '.Html::input('text', 'name', '', ['class' => 'name']) ?><br/>
<?php echo 'Поиск по телефону: '.Html::input('text', 'phone', '', ['class' => 'phone']) ?><br/>
<?php echo Html::button('Искать', ['class' => 'do_search']); ?>	

</div>


<div class="search_results">

</div>
