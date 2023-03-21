<?
namespace CRM24;
use Bitrix\Main\Page\Asset;

class Personal_interface {
	function Show_profit()
	{
    global $USER;
        $USER = new \CUser;
        $dbUser = \Bitrix\Main\UserTable::getList([
            'select' => ['UF_DEALS_CURRENT_COUNTS', 'UF_DEALS_CURRENT_BUDGET_SUMM', 'UF_DEALS_CURRENT_PAY', 'UF_DEALS_REWARD_PERCENT'],
            'filter' => ['ID' => $USER->GetID()]
        ])->fetch();


    define("UF_DEALS_REWARD_PERCENT", $dbUser["UF_DEALS_REWARD_PERCENT"]); // Процент вознаграждения
    if (!empty(UF_DEALS_REWARD_PERCENT)){ // Если задан процент вознаграждения, выводим меню
        define("UF_DEALS_CURRENT_COUNTS", $dbUser["UF_DEALS_CURRENT_COUNTS"]); // Общее число сделок за месяц
        define("UF_DEALS_CURRENT_PAY", $dbUser["UF_DEALS_CURRENT_PAY"]); // Зарплата за месяц
        $months = array(
        "1"=>"январь","2"=>"февраль","3"=>"март",
        "4"=>"апрель","5"=>"май", "6"=>"июнь",
        "7"=>"июль","8"=>"август","9"=>"сентябрь",
        "10"=>"октябрь","11"=>"ноябрь","12"=>"декабрь");
        define("UF_CURRENT_MONTH", $months[date("n")]);
        
        $budget_summ = number_format($dbUser["UF_DEALS_CURRENT_BUDGET_SUMM"], 0, ',', ' ');
        define("UF_DEALS_CURRENT_BUDGET_SUMM", $budget_summ); // Общий бюджет всех сборок

        /* #personal-profit на всякий случай, чтобы не заменить другие стили */

        Asset::getInstance()->addCss("/local/php_interface/classes/interface/personal.css"); // Подклчюение css
        ?>
    <? if ((empty($_REQUEST["action"])) && (empty($_REQUEST["ACTION"]))){ // Скрипт начинает загружаться вместе с планированием задач на день на ajax, это исправляет ?>
        <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('timeman-container').insertAdjacentHTML("afterbegin", "<div id='personal-profit' class='d-flex flex-column align-items-center justify-content-center'><span class='text-white fw-bold font-adaptive' style='line-height:1.2rem'>За <?=UF_CURRENT_MONTH?> закрыто <?=UF_DEALS_CURRENT_COUNTS?> сделок на <?=UF_DEALS_CURRENT_BUDGET_SUMM?> руб<br> Зарплата <?=UF_DEALS_CURRENT_PAY?> ₽ за <?=UF_DEALS_REWARD_PERCENT?>% от суммы бюджета</span></div>");
        });
        </script>
<?
    } 
    } 
    }
} ?>