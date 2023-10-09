<?php
namespace openecontmd\bank_api\models;

//use common\models\Role;
//use common\models\SysActionRoles;
use Yii;
//use yii\base\NotSupportedException;
//use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
//use yii\web\IdentityInterface;

class BankInvoiceAPI extends ActiveRecord
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

    public static function checkInvoiceByUid($uid = 0)
    {
        $sql = "SELECT EXISTS( SELECT invoice_uid FROM bank_invoice_list WHERE invoice_uid = '{$uid}' )";
        return Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_CLASS);
    }
    public static function checkInvoiceByNumber($number = '')
    {
        $sql = "SELECT invoice_uid FROM bank_invoice_list WHERE (invoice_number = '{$number}')";
        return Yii::$app->db->createCommand($sql)->queryOne();
    }

    public static function getInvoiceByUid($uid)
    {
        $sql = "SELECT * FROM bank_invoice_list WHERE (invoice_uid = '$uid')";
        return Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_CLASS);
    }
    public static function getInvoiceByNumber($number)
    {
        $sql = "SELECT * FROM bank_invoice_list WHERE (invoice_number = '$number')";
        return Yii::$app->db->createCommand($sql)->queryAll(\PDO::FETCH_CLASS);
    }

    public static function createInvoice($uid, $number, $body)
    {
        $sql = "INSERT INTO bank_invoice_list (invoice_uid, invoice_number, invoice_xml, actual) VALUES ('{$uid}', '{$number}', '{$body}', 1)";
        return Yii::$app->db->createCommand($sql)->execute();
    }


}
