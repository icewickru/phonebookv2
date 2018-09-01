<?php
//namespace common\models;
namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\Contact;

class Phone extends ActiveRecord {
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%phone}}';
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
			[['phone', 'contact_id'], 'required'],
			[['phone', 'contact_id'], 'number'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }
	
	
	public function getContact() {
		return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
	}
}
