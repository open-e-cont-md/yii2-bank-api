<?php
namespace openecontmd\bank_api\models;

//use common\models\Role;
//use common\models\SysActionRoles;
use Yii;
//use yii\base\NotSupportedException;
//use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
//use yii\web\IdentityInterface;

class CredentialAPI extends ActiveRecord
{

    public static function tableName()
    {
        return 'bank_invoice_list';
    }

    public static function createUid()
    {
        do {
            $uid = mt_rand(1000000000, 4294967295);
            $r = self::checkInvoiceByUid($uid);
        } while (!$r);
        return $uid;
    }

    public static function createCredential($client_name, $user = '', $password = '', $acl = 'read', $state = 'suspended')
    {
        $sql = "INSERT INTO external_credential_list (client_name, user, token, acl, state)
        VALUES ('$client_name', '$user', '$password', '$acl', '$state')";
        return Yii::$app->db->createCommand($sql)->execute();
    }

    public static function getCredential($user)
    {
        $sql = "SELECT client_name, user, token, acl, state FROM external_credential_list WHERE (user = '$user')";
        return Yii::$app->db->createCommand($sql)->queryOne();
    }

}
