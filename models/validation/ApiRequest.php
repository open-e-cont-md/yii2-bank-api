<?php

namespace openecontmd\bank_api\models\validation;

use Yii;
use yii\base\Model;

class ApiRequest extends Model
{
	public $request_id;
	public $session_id;
	public $php_session_id;
	public $client_id;
	public $user_id;

	public function rules()
	{
		return [
			[['request_id'], 'required'],
			[['request_id'], 'string', 'max' => 40],
		    [['php_session_id'], 'string', 'max' => 40],
		    [['client_id'], 'string', 'max' => 40],
		    [['user_id'], 'string', 'max' => 40],
			[['session_id'], 'required', 'except' => 'search/offer'],
			['session_id', 'validateSessionId', 'skipOnEmpty' => true, 'skipOnError' => false],
		];
	}

	public function attributeLabels()
	{
		return [
			'request_id' => Yii::t('api', 'ID запроса'),
			'session_id' => Yii::t('api', 'ID сессии'),
		    'client_id' => Yii::t('api', 'ID клиента (браузера)'),
		    'user_id' => Yii::t('api', 'ID пользователя сайта'),
		    'php_session_id' => Yii::t('api', 'PHP ID сессии'),
		];
	}

	function validateSessionId($attribute, $params)
	{
//		$session_validate = (bool) preg_match('/^[0-9a-zA-Z,-]{22,40}$/', $this->$attribute); //   было до 27.05.2021
//		$session_validate = (bool) preg_match('/^[0-9a-zA-Z,-]{8,40}$/', $this->$attribute); //  Proxymo !!! ???
		$session_validate = (bool) preg_match('/^[0-9a-zA-Z,_-]{8,50}$/', $this->$attribute); //  FlyOne !!! ???

		if ($session_validate == false) {
			$this->addError($attribute, 'Не правильный формат session_id');
		}
	}
}
