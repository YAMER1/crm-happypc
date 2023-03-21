<?
use Bitrix\Main\EventManager;
$eventManager = EventManager::getInstance();

$eventManager->addEventHandlerCompatible("crm", "OnAfterCrmDealUpdate", ["\CRM24\Personal", "Profit"]); // Добавление суммы по заработку в поле 
$eventManager->addEventHandlerCompatible("main", "OnPageStart", ["\CRM24\Personal_interface", "Show_profit"]);