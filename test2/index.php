<?
require_once($_SERVER['DOCUMENT_ROOT']."/bitrix/modules/main/include/prolog_before.php");

    global $APPLICATION;
    global $USER;

    \Bitrix\Main\Loader::includeModule('crm');

       $arFieldsContact = array(
            "NAME" => "Михаил111",
            "LAST_NAME" => "Тестеров222",
            // "SECOND_NAME" => "Отчество",
            //"HONORIFIC" => "HNR_RU_1",
            // "POST" => "Должность",
            // "ADDRESS" => "Улица, дом, корпус, строение",
            // "ADDRESS_2" => "Квартира / офис",
            "ADDRESS_CITY" => "Чита",
            // "ADDRESS_POSTAL_CODE" => "Почтовый индекс",
            // "ADDRESS_REGION" => "Район",
            // "ADDRESS_PROVINCE" => "Область",
            // "ADDRESS_COUNTRY" => "Страна",
            // "ADDRESS_COUNTRY_CODE" => "",
            // "SOURCE_DESCRIPTION" => "Описание",
            "SOURCE_ID" => "WEB",
            "TYPE_ID" => "CLIENT",  
            "OPENED" => "Y",
            // "POST" => "не указано",//должность               
            //"OPENED" => "N", //открыто для других пользователей                
            // "EXPORT" => "Y",//участвует в экспорте                
            'FM' => array(//почта, телефон
                'EMAIL' => array(
                       'n0' => array('VALUE' => "yura002353443@yandex.ru", 'VALUE_TYPE' => 'WORK')
                     ),
                     'PHONE' => array(
                        'n0' => array('VALUE' => "79871524337", 'VALUE_TYPE' => 'WORK')
                     ) 
                 ),
            // "COMPANY_ID" => $companyId, раньше только к одной можно было привязать
            // "COMPANY_IDS"=>array(1,2,3), //массив id компаний, сейчас можно так                
            "ASSIGNED_BY_ID" => "1",//id ответственного менеджера
            "UF_CRM_63A99A260CB47" => "vkontaktetest",
            "UF_CRM_63A99A26033C3" => "tip_svyazi"
        );
        
        
        //создаем контакт   
        $oContact = new CCrmContact(false);
        $Contact_id = $oContact->add($arFieldsContact);

        echo '<pre>' . var_export($Contact_id, true) . '</pre>';

        if($oContact->LAST_ERROR != ""){                           
           //не создался контакт
            $APPLICATION->ThrowException('Контакт не создан, данные'.$Name.''.$Last_Name.''.$City.''.$Email.''.$Phone.''.$Manager_id);
        }
        
?>