<?php
/*
 * Вспомогательный справочник для общих функций
 */

namespace openecontmd\bank_api\models;

class Helper
{
    /***********************************************************************
     Функция вернет GUID.
     ***********************************************************************/
    public static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /***********************************************************************
     Функция вернет GUID. Аналог SQL функции newid().
     ***********************************************************************/
    public static function newid()
    {
        $ComputerName = getenv('COMPUTERNAME').""=="" ? "localhost" : getenv('COMPUTERNAME');
        $ComputerIP = $_SERVER["SERVER_ADDR"].""=="" ? "127.0.0.1" : $_SERVER["SERVER_ADDR"];
        $ComputerAddress = strtolower($ComputerName.'/'.$ComputerIP);

        list($usec, $sec) = explode(" ",microtime());
        $currentTimeMillis = $sec.substr($usec, 2, 3);

        $tmp = rand(0,1)?'-':'';
        $nextLong = $tmp.rand(1000, 9999).rand(1000, 9999).rand(1000, 9999).rand(100, 999).rand(100, 999);

        $valueBeforeMD5 = $ComputerAddress.':'.$currentTimeMillis.':'.$nextLong;
        $valueAfterMD5 = md5($valueBeforeMD5);

        $raw = strtoupper($valueAfterMD5);
        return  substr($raw,0,8).'-'.substr($raw,8,4).'-'.substr($raw,12,4).'-'.substr($raw,16,4).'-'.substr($raw,20);
    }
}
