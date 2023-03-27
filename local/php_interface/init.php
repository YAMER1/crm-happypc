<?
CModule::IncludeModule("iblock");
CModule::IncludeModule("crm");
use Bitrix\Main\Loader;


/*
file_get_contents($_SERVER['DOCUMENT_ROOT']."/local/php_interface/classes/interface/test.txt");
*/
$events = [];
$filter_count = ((($_REQUEST["ACTION"] == "SAVE_PROGRESS") && str_contains($_REQUEST["VALUE"], "C1:")) || ($_REQUEST["action"] == "status" && str_contains($_REQUEST["status"], "C1:")));
if ($filter_count) { // Скрипт загружается повторно при открытии окон, но с пустыми запросами 1 раз
    $personal_count[] = [
        "\CRM24\Personal" => "/local/php_interface/classes/interface/personal_summ.php", // Проверка имени
    ];
    $events = array_merge($events, $personal_count[0]);
}
$filter_interface = (empty($_REQUEST));
if ($filter_interface){ // Запускать только при открытии страницы
    $personal_interface[] = [
        "\CRM24\Personal_interface" => "/local/php_interface/classes/interface/personal_interface.php", // Подключение интерфейса
    ];
    $events = array_merge($events, $personal_interface[0]);
}

if (!empty($events)){    
    \Bitrix\Main\Loader::registerAutoLoadClasses(null, $events); // Чтобы в будушем к интерфейсу добавить другие события и не запускать событие интерфейса когда не надо
}
require_once($_SERVER['DOCUMENT_ROOT']."/local/php_interface/events.php"); // Подключение событий


