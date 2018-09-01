<?php 
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use app\models\Contact;
use app\models\Phone;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;


class ContactController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'list', 'add', 'addphone', 'deletephone', 'delete', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'list', 'addphone', 'add', 'deletephone', 'delete', 'update'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }
	

    public function actionIndex() {
		$contacts = Contact::find()->all();
	
		$this->view->registerJsFile('/js/phonebook.js',  ['position' => yii\web\View::POS_END]);
        return $this->render('index', ['contacts' => $contacts]);
    }	
	
	
    public function actionAdd()
    {
		$request = Yii::$app->request;
		
		if ($request->post('name') && $request->post('phone')) {
			$contact = new Contact;
			
			$contact->name = $request->post('name');
			$contact->save();
			
			$phone = new Phone;
			$phone->phone = $request->post('phone');
			$phone->contact_id = $contact->id;
			$phone->save();
			
			return $this->redirect(['contact/index']);
		}
		
		return $this->redirect(['contact/index']);
    }
	
	
    public function actionUpdate() {
		$request = Yii::$app->request;
		
		if ($request->post('Contact') && $request->post('Contact')['id']) {
			$id = $request->post('Contact')['id'];
			
			$contact = Contact::find()->where(['id' => $id])->limit(1)->one();
			
			if ($contact) {
				if ($contact->load($request->post())) {
					$contact->save();
				}
			}
		}
		
		return $this->redirect(['contact/index']);
    }	
	
	
	public function actionAddphone() {
		$request = Yii::$app->request;
		$phone = new Phone();

		if ($phone->load($request->post())) {
			$phone->save();
		}
	
		return $this->redirect(['contact/index']);
	}
	
	
	public function actionDeletephone($id) {
		Yii::$app->response->format = Response::FORMAT_JSON;
		
		if ($id) {
			$model = Phone::find()->where(['id' => $id])->limit(1)->one();
			$result = $model->delete();
			return ['result' => $result];
		}
		
		return ['result' => 'error'];
	}
	
	
	public function actionDelete() {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$request = Yii::$app->request;
		
		if ($id = $request->post('id')) {
			
			$contact = Contact::find()->where(['id' => $id])->limit(1)->one();
			if ($contact) {
				$contact->delete();
				return ['result' => 'ok'];
			}
		}
		
		return ['result' => 'error'];
	}
	
	
	public function actionList() {
		Yii::$app->response->format = Response::FORMAT_JSON;
		$contacts = Contact::find()
			->with('phones')
			->asArray()
			->all();
		return $contacts;	
	}
}
