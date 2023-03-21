<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("crm");
use Bitrix\Main\Loader;

require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/events.php");


/*
file_get_contents($_SERVER['DOCUMENT_ROOT']."/local/php_interface/classes/interface/test.txt");
*/


\Bitrix\Main\Loader::registerAutoLoadClasses(null,
    [
        "\CRM24\Personal" => "/local/php_interface/classes/interface/personal_summ.php", // Проверка имени 
        "\CRM24\Personal_interface" => "/local/php_interface/classes/interface/personal_interface.php", // Подключение интерфейса 
    ]
);
