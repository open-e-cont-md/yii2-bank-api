<?php

namespace openecontmd\bank_api\modules\bank;

use Yii;
use yii\filters\VerbFilter;
//use yii\web\BadRequestHttpException;
use openecontmd\bank_api\models\validation\ApiRequest;
use yii\web\HttpException;

class Module extends \yii\base\Module
{
	public $controllerNamespace = 'openecontmd\bank_api\modules\bank\controllers';
	public $gate = null;

	public function init()
	{
		parent::init();
//var_dump($this); exit;

//		$this->gate = Yii::$app->session->get('gate');

		//$this->_check_token();
		//		$method = str_replace('bank/v1/', '', $this->module->requestedRoute);

		// проверяем входные данные
		$model = new ApiRequest();

/*
		if (in_array($method, ['send/email', 'send/sms', 'send/push'])) {
			Yii::$app->session->destroy('session_id');
			return true;
		}
*/
		$post = Yii::$app->request->post() ? Yii::$app->request->post() : Yii::$app->request->get();
		$model->load($post, '');

//echo "<pre>"; var_dump($this->module->requestedRoute, Yii::$app->request->post(), $method, $model->request_id); exit;


		//if (!$model->validate()) {
		//	throw new BadRequestHttpException(json_encode($model->errors, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
		//}

		//echo "<pre>"; var_dump(Yii::$app->request->post(), $method, $model->request_id); exit;


/*
		$session_id = Yii::$app->request->post('session_id');
		if (isset($session_id)) {
			Yii::$app->session->set('session_id', $session_id);
		}
*/
		// Устанавливаем язык
		$lang = in_array(Yii::$app->request->post('lang'), ['ru', 'ro', 'en']) ? Yii::$app->request->post('lang') : 'ru';
		Yii::$app->language = $lang;

//echo "<pre>"; var_dump($lang, Yii::$app->request->post(), $method, $model->request_id); exit;

	}


	private function _check_token()
	{
		$token = Yii::$app->request->post('token') ? Yii::$app->request->post('token') : Yii::$app->request->get('token');

//		токен, нужно на сайте такой же сгенерить
//		$check = date('Ymyddmyd') . '145aga' . date('mddmYd');
		$check = '123123123';

		//@todo нормальный генератор токена
		if ($token != $check) {
			throw new HttpException(401, 'Неверный токен');
		}
	}


	/*
	 * Принимаем только POST запросы
	 */
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
			    'actions' => ['*'  => ['post','get']]
			]
		];
	}

}
