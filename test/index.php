<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");


use Bitrix\Crm\DealTable;
$arDeals=DealTable::getList([ // Выводим все сделки с d7
    'order'=>['ID' => 'DESC'],
    'filter'=>['ASSIGNED_BY_ID' => '14', 'STAGE_ID' => 'C2:WON'], // Фильтр по Ответственный, стадия Успех
    'select'=>['CLOSEDATE', 'UF_CRM_1667140609527'], // Дата закрытия сделки и бюджет
    // 'cache' => ['ttl' => 3600] // Время кеша не нужно
])->fetchAll();
$deals=[];

$date_today = strtotime(date("Y-m")); // Текущая дата преобразованная для сравнения

$deals_count = 0; // Число сделок
foreach($arDeals as $deal){ // Выводим информацию по сделкам
    $old_date = strtotime($deal['CLOSEDATE']);
    $new_date = strtotime(date('Y-m', $old_date));
    if ($date_today == $new_date){ // Текущий месяц
        $deals_count += 1; // Подсчёт количества сделок
        $budget += $deal['UF_CRM_1667140609527'];
    }
}

            // Получим данные об ответственном, его процент вознаграждения
            
            $dbUser = \Bitrix\Main\UserTable::getList([
                'select' => ['UF_DEALS_REWARD_PERCENT'],
                'filter' => ['ID' => '14']
            ])->fetch();

            var_dump($dbUser);
            die();

            $deals_pay += $deals_budget * ($dbUser['UF_DEALS_REWARD_PERCENT']/100); // Рассчёт по сумме бюджета
            // Получили вознаграждение сборщика

echo $deals_count;
echo $budget;