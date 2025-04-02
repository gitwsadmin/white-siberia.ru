<?php

AddEventHandler('main', 'OnEpilog', array('CMainHandlers', 'OnEpilogHandler'));  
class CMainHandlers { 
   public static function OnEpilogHandler() {
      if (isset($_GET['PAGEN_1']) && intval($_GET['PAGEN_1'])>0) {
         $title = $GLOBALS['APPLICATION']->GetTitle();
         $GLOBALS['APPLICATION']->SetPageProperty('title', $title.' | Страница '.intval($_GET['PAGEN_1']));
      }
   }
}
if ($_REQUEST['PAGEN_1']) {
    global $APPLICATION;
    $APPLICATION->AddHeadString('<link href="https://'.$_SERVER['HTTP_HOST'].$APPLICATION->sDirPath.'" rel="canonical" />',true);
}
//require \Bitrix\Main\Application::getDocumentRoot().'/vendor/autoload.php';

//\Itconstruct\Application::initializeApp();

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "SortMorePhotos");
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "SortMorePhotos");

function SortMorePhotos(&$arFields){

    if(!empty($arFields['IBLOCK_ID']) && in_array($arFields['IBLOCK_ID'],[55,59])){ //инфоблок товаров и офферсов

        $photosPropId = ($arFields['IBLOCK_ID'] == 55) ? 880 : 1040; //id свойства MORE_PHOTOS в данных инфоблоках

        $arPhotos = [];

        if(isset($arFields["PROPERTY_VALUES"][$photosPropId])){             
            foreach($arFields["PROPERTY_VALUES"][$photosPropId] as $keyPhoto => $arPhoto){
                if(!empty($arPhoto)){

                    //if(1*$keyPhoto == 0){
                    //if($keyPhoto == 'n0'){
                        $arPhotos[$keyPhoto] = ($arPhoto["DESCRIPTION"]!=="") ? $arPhoto["DESCRIPTION"] : $arPhoto["VALUE"]["name"];
                    //}
                }                
            }
        }

        if(!empty($arFields["ID"])) {
            $res = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("ID" => $photosPropId));
            while ($ob = $res->GetNext()) {

                $arPhoto = CFile::GetFileArray($ob["VALUE"]);

                $arPhotos[$ob["PROPERTY_VALUE_ID"]] = ($arPhoto["DESCRIPTION"]!=="") ? $arPhoto["DESCRIPTION"] : $arPhoto["FILE_NAME"];               
                $arPhotosFull[$ob["PROPERTY_VALUE_ID"]] = $ob;
            }
        }

        if(!empty($arPhotos)){            
            asort($arPhotos);             
            $arNewPhotos = [];                
            foreach ($arPhotos as $keyPhoto => $descPhoto) { 
                if(isset($arFields["PROPERTY_VALUES"][$photosPropId][$keyPhoto])){               
                    $arNewPhotos[$keyPhoto] = $arFields["PROPERTY_VALUES"][$photosPropId][$keyPhoto];
                }
                else{
                    $arNewPhotos[$keyPhoto] = array (
                        'VALUE' => 
                        array (
                          'name' => NULL,
                          'type' => NULL,
                          'tmp_name' => NULL,
                          'error' => 4,
                          'size' => 0,
                          'description' => '',
                        ),
                        'DESCRIPTION' => '',
                      );
                }
            }

            $arFields["PROPERTY_VALUES"][$photosPropId] = $arNewPhotos;
        }        
    }
}

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler('ipol.aliexpress', 'onBeforeItemExport', function($event) {
    $parameters = $event->getParameters();
    $item = $parameters['ITEM'];

    $rs = CIBlockElement::GetList([], [
        'ID' => $item['ID'],
        'IBLOCK_ID' => $item['IBLOCK_ID'],
    ]);
    if ($ob = $rs->GetNextElement()) {
        $arProps = $ob->GetProperties();

        if ($arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE']) {

            $descrText = $arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE'];
            $descrType = 'text';

            $item['DESCRIPTION'] = yandex_text2xml(
                $descrType == 'html'
                    ? '<![CDATA['. $descrText .']]>'
                    : TruncateText(
                    preg_replace_callback("'&[^;]*;'", 'yandex_replace_special', $descrText),
                    2000
                )
                ,
                $descrType != 'html'
            );


            /*
            $arDescr = unserialize($arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE']);
            ECHO 'ok ob';
            print_r($arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE']);
            print_r($arDescr); exit;
            $descrText = $arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE']['TEXT'];
            $descrType = ($arProps['OPISANIE_DLYA_ALIEKSPRESS']['VALUE']['TYPE'] == 'HTML' ? 'html' : 'text');

            $item['DESCRIPTION'] = yandex_text2xml(
                $descrType == 'html'
                    ? '<![CDATA['. $descrText .']]>'
                    : TruncateText(
                    preg_replace_callback("'&[^;]*;'", 'yandex_replace_special', $descrText),
                    2000
                )
                ,
                $descrType != 'html'
            );
            */


            /*

            */
        }

        /*
        if ($arProps['DESCRIPTION_ALI']['VALUE']['TEXT']) {

            $descrText = $arProps['DESCRIPTION_ALI']['VALUE']['TEXT'];
            $descrType = ($arProps['DESCRIPTION_ALI']['VALUE']['TYPE'] == 'HTML' ? 'html' : 'text');

            $item['DESCRIPTION'] = yandex_text2xml(
                $descrType == 'html'
                    ? '<![CDATA['. $descrText .']]>'
                    : TruncateText(
                    preg_replace_callback("'&[^;]*;'", 'yandex_replace_special', $descrText),
                    2000
                )
                ,
                $descrType != 'html'
            );
        }
        */

        if ($arProps['PICTURE_ALI']['VALUE']) {
            $pictureFile = CFile::GetFileArray($arProps['PICTURE_ALI']['VALUE']);
            //$item['PICTURE'] = 'https://'.$_SERVER['HTTP_HOST'].CHTTP::urnEncode($pictureFile['SRC'], 'utf-8');
            $item['PICTURE'] = 'https://white-siberia.ru'.CHTTP::urnEncode($pictureFile['SRC'], 'utf-8');
            unset($arProps['PICTURE_ALI']['VALUE']);
            /*
            if (count($arProps['PICTURE_ALI']['VALUE'])) {
                $item['PROPERTIES'][880]['VALUE'] = $arProps['PICTURE_ALI']['VALUE'];
            }
            */
        }
    }

    $parameters['ITEM'] = $item;

    return new \Bitrix\Main\EventResult(\Bitrix\Main\EventResult::SUCCESS, $parameters);
});

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", function($arFields) {

    if (!$arFields['PROPERTY_VALUES'][2015]) return;

    $rs = CIBlockElement::GetList([], [
        'IBLOCK_ID' => $arFields['IBLOCK_ID'],
        'ID' => $arFields['ID']
    ], false, false, [
        'PROPERTY_KARTINKA_DLYA_ALIEKSPRESS'
    ]);
    if ($ar = $rs->Fetch()) {
        $current_filename = $ar['PROPERTY_KARTINKA_DLYA_ALIEKSPRESS_VALUE'];
        $new_filename = array_values($arFields['PROPERTY_VALUES'][2015])[0]['VALUE'];
        if ($new_filename && ($new_filename != $current_filename)) {
            addAliImageToElement($arFields['ID'], $arFields['IBLOCK_ID'], $new_filename);

        }
    }
});

AddEventHandler("iblock", "OnAfterIBlockElementAdd", function($arFields) {
    if (is_array($arFields['PROPERTY_VALUES'][2015]))
        $new_filename = array_values($arFields['PROPERTY_VALUES'][2015])[0]['VALUE'];
    if ($new_filename) {
        addAliImageToElement($arFields['ID'], $arFields['IBLOCK_ID'], $new_filename);
    }
});

function addAliImageToElement($el_id, $iblock_id, $filename) {
    $filepath = $_SERVER['DOCUMENT_ROOT'] . '/upload/1c_catalog/' . $filename;
    if (file_exists($filepath)) {
        CIBlockElement::SetPropertyValuesEx($el_id, $iblock_id, [
            'PICTURE_ALI' => [
                'VALUE' => CFile::MakeFileArray($filepath),
                'DESCRIPTION' => ''
            ]
        ]);
        CIBlock::clearIblockTagCache($iblock_id);
    }

}

function d() {
    foreach (func_get_args() as $var) {
        echo '<pre>', print_r($var, true), '</pre>';
    }
}

AddEventHandler("main", "OnEndBufferContent", function(&$content) {
    // noindex for avito.white-siberia.ru
    if ($_SERVER['HTTP_HOST'] == 'avito.white-siberia.ru') {
        $strNoIndexMeta = '<meta name="robots" content="noindex" />';

        $content = str_replace('</head>', $strNoIndexMeta . PHP_EOL . '</head>', $content);
    }
});

AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MorePhotoResizeClass", "OnAfterIBlockElement"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("MorePhotoResizeClass", "OnAfterIBlockElement"));

class MorePhotoResizeClass
{
 static function Clear()
 {
  $_WFILE = glob($_SERVER['DOCUMENT_ROOT']."/upload/tmp/*");
  foreach($_WFILE as $_file) unlink($_file);
  return true;
 }

 static function OnAfterIBlockElement(&$arFields)
 {
  global $APPLICATION, $USER;

  $arProp = array();

  //$PROPERTY_CODES= ["MORE_PHOTO"]; // Код свойства с которым работаем
  $PROPERTY_CODES= ["PHOTO_GALLERY"]; // Код свойства с которым работаем

  $imageMaxWidth = 1500; // Максимальная ширина уменьшенной картинки
  $imageMaxHeight = 1500; // Максимальная высота уменьшенной картинки

  foreach ($PROPERTY_CODES as $PROP_CODE)
  {
   // Находим свойство
   $dbRes = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("CODE" => $PROP_CODE));

   while ($arMorePhoto = $dbRes->GetNext(true, false))
   {
    if ($arMorePhoto["PROPERTY_TYPE"] == "F" && $arMorePhoto["MULTIPLE"] == "Y")
    {
     // Находим подробные сведения о файле
     $arFile = CFile::GetFileArray($arMorePhoto["VALUE"]);

     // Проверяем, что файл является картинкой
     if (!CFile::IsImage($arFile["FILE_NAME"])) continue;

     // Если размер больше допустимого
     if ($arFile["WIDTH"] > $imageMaxWidth || $arFile["HEIGHT"] > $imageMaxHeight)
     {

      // Временная картинка
      $tmpFilePath = $_SERVER['DOCUMENT_ROOT']."/upload/tmp/".$arFile["FILE_NAME"];

      // Уменьшаем картинку
      $resizeRez = CFile::ResizeImageFile(
         $sourceFile = $_SERVER['DOCUMENT_ROOT'].$arFile["SRC"],
         $tmpFilePath,
         $arSize = array('width' => $imageMaxWidth, 'height' => $imageMaxHeight),
         $resizeType = BX_RESIZE_IMAGE_PROPORTIONAL,
         $waterMark = array(
            "type" => "image",
            "position" => "tr",
            "size" => "real",
            "file" => $_SERVER['DOCUMENT_ROOT'].'/watermark.png',
         ),
         $jpgQuality = 95
      );

      // Записываем изменение в массив
      if ($resizeRez)
      {
       $arProp += array(
          $arMorePhoto["PROPERTY_VALUE_ID"] => array(
             "VALUE" => CFile::MakeFileArray($tmpFilePath),
             "DESCRIPTION"=> $arMorePhoto["DESCRIPTION"]
          )
       );
      }
     }
    }
   }

   if (!empty($arProp))
   {
    // Записываем изменение в свойство
    CIBlockElement::SetPropertyValueCode($arFields["ID"], $PROP_CODE, $arProp);

    // Стираем временные файлы
    MorePhotoResizeClass::Clear();
   }
  }
 }
}

function sendCurl($data, $method, $idempotenceKey, $shopId, $secretKey)
{
    $url = 'https://api.yookassa.ru/v3/payments';
    $headers = [
        'Idempotence-Key: '. $idempotenceKey,
        'Content-Type: application/json',
    ]; // создаем заголовки
    $curl = curl_init(); // создаем экземпляр curl

    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_VERBOSE, 1);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_USERPWD, $shopId . ':' . $secretKey);

    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10); // Время ожидания соединения в секундах
    curl_setopt($curl, CURLOPT_TIMEOUT, 15);
    curl_setopt($curl, CURLOPT_URL, $url);
    $result = curl_exec($curl);
    AddMessage2Log($result, 'result');
    if (curl_errno($curl)) {
        echo '<pre>';
        print_r(curl_error($curl));
        echo '</pre>';
    }
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($httpCode !== 200) {
        throw new Exception('Сервер вернул HTTP-код: ' . $httpCode);
    }
    curl_close($curl);
    return json_decode($result, true);
}

/**
 * Временный агент для активации услуг для менеджеров
 * @return string
 */
function activateSpecificProducts()
{
    if (!\CModule::IncludeModule("iblock")) {
        return "activateSpecificProducts();";
    }

    $productIds = [20225, 20226, 20227, 20224];
    $iblockId = 55;

    $arFilter = [
        "IBLOCK_ID" => $iblockId,
        "ID" => $productIds,
        "ACTIVE" => "N"
    ];

    $res = CIBlockElement::GetList([], $arFilter, false, false, ["ID"]);
    while ($element = $res->Fetch()) {
        $el = new CIBlockElement;
        $el->Update($element["ID"], ["ACTIVE" => "Y"]);
    }

    return "activateSpecificProducts();";
}

/**
 * Logs a message to Telegram.
 *
 * @param mixed $messageText The message to be logged.
 * @param string|null $groupChatId Optional group chat ID.
 * @return void
 */
function LogTG($messageText, $groupChatId = null)
{
    $botToken = "5865641167:AAF55jrqMP0zFAGrU7Bv-1KUDj_7chXsVWc";
    $defaultChatId = "141079661";
    $chatId = $groupChatId ? $groupChatId : $defaultChatId;

    $telegramUrl = "https://api.telegram.org/bot".$botToken."/sendMessage";
    $text = $_SERVER["HTTP_HOST"]. "\n";
    $text .= print_r($messageText, true);
    $telegram_params = [
        'chat_id' => $chatId,
        'text' => $text,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($telegram_params),
        ],
    ];

    $context  = stream_context_create($options);
    file_get_contents($telegramUrl, false, $context);
}

/**
 * Удобная принтилка
 * @param $ar
 * @param $dark
 * @param $die
 * @return string|void
 */
function pr($ar, $dark = false, $die = false)
{
    global $USER;
    if (!$USER->IsAdmin()) return "";

    if(!$dark)
    {
        echo "<pre style='font-size:11px;line-height:1.2; padding:5px;'>".print_r($ar, 1)."</pre>";
    }
    else
    {
        echo '<pre style="line-height:1.2; padding:2em;font-size:11px;background: #282c34; color: #61dafb">' .print_r($ar, true).'</pre>';
    }
    if($die) die();
}