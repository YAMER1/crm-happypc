<?
namespace CRM24;
use Bitrix\Crm\DealTable;

class Personal {

	public static function Profit(&$arFields)
	{
        global $USER;
        
        // file_put_contents(($_SERVER['DOCUMENT_ROOT']."/local/php_interface/classes/interface/voronka.txt"), print_r($arFields, true));
        
        // Получим данные об ответственном, его процент вознаграждения
        if (!empty($arFields["ASSIGNED_BY_ID"])){
            $assigned_by_id = $arFields["ASSIGNED_BY_ID"]; // Ответственный по сделке в воронке
        }
        if (!empty($arFields["MODIFY_BY_ID"])){
            $assigned_by_id = $arFields["MODIFY_BY_ID"]; // Ответственный по сделке в списке
        }
        
        $dbUser = \Bitrix\Main\UserTable::getList([
            'select' => ['UF_DEALS_REWARD_PERCENT'],
            'filter' => ['ID' => $assigned_by_id]
        ])->fetch();
        
        if ((strpos($arFields["STAGE_ID"], "C1:")!== false) && (!empty($dbUser['UF_DEALS_REWARD_PERCENT']))){ // Если стадия воронки Продажа сборок завершена и у пользователя задан процент вознаграждения
            // Получаем информацию о сделках
            $arDeals=DealTable::getList([ // Выводим все сделки с d7
                'order'=>['ID' => 'DESC'],
                'filter'=>['ASSIGNED_BY_ID' => $assigned_by_id, 'STAGE_ID' => 'C1:WON'], // Фильтр по Ответственному сделки, стадия Успех
                'select'=>['CLOSEDATE', 'UF_CRM_1667140609527'], // Дата закрытия сделки и бюджет
                // 'cache' => ['ttl' => 3600] // Время кеша не нужно
            ])->fetchAll();
            $deals=[];

            $date_today = strtotime(date("Y-m")); // Текущая дата преобразованная для сравнения

            $deals_count = 0; // Число сделок
            foreach($arDeals as $deal){ // Выводим информацию по сделкам
                $old_date = strtotime($deal['CLOSEDATE']);
                $new_date = strtotime(date('Y-m', $old_date));
                if ($date_today == $new_date){ // Получаем число сделок за текущий месяц
                    $deals_count += 1; // Подсчёт числа сделок за текущий месяц
                    $deals_budget += $deal['UF_CRM_1667140609527']; // Подсчёт суммы бюджета 
                }
            }
            $deals_pay += $deals_budget * ($dbUser['UF_DEALS_REWARD_PERCENT']/100); // Рассчёт по сумме бюджета
            // Получили число сделок, общую сумму по бюджету и вознаграждение сборщика

            $user = new \CUser;
            $user_fields = [
                "UF_DEALS_CURRENT_COUNTS" => $deals_count, // Задаём число сделок за текущий месяц
                "UF_DEALS_CURRENT_BUDGET_SUMM" => $deals_budget, // Задаём общую сумму
                "UF_DEALS_CURRENT_PAY" => $deals_pay // Зарплата за текущий месяц
            ];
            $user->Update($assigned_by_id, $user_fields); // Записываем обновлённое значение            
        }
        
		return true; // все значения прошли валидацию, вернем true
	}
}