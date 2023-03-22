<?
use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

if ($filter_count){
    $eventManager->addEventHandlerCompatible("crm", "OnAfterCrmDealUpdate", ["\CRM24\Personal", "Profit"]); // Добавление суммы по заработку в поле 
}
if ($filter_interface){
    $eventManager->addEventHandlerCompatible("main", "OnPageStart", ["\CRM24\Personal_interface", "Show_profit"]);
}