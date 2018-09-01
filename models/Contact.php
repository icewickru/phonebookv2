<?php
//namespace common\models;
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Phone;

class Contact extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%contact}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
		
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			['name', 'string', 'length' => [1, 1023] ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
	
	
    //функция связи модели
    public function getPhones()
    {
		return $this->hasMany(Phone::className(), ['contact_id' => 'id']);
    }	
}
