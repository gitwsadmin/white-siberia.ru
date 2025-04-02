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
require \Bitrix\Main\Application::getDocumentRoot().'/vendor/autoload.php';

\Itconstruct\Application::initializeApp();

AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", "SortMorePhotos");
AddEventHandler("iblock", "OnBeforeIBlockElementAdd", "SortMorePhotos");

function SortMorePhotos(&$arFields){
    if(!empty($arFields['IBLOCK_ID']) && in_array($arFields['IBLOCK_ID'],[55,59])){ //инфоблок товаров и офферсов
        $photosPropId = ($arFields['IBLOCK_ID'] == 55) ? 880 : 1040; //id свойства MORE_PHOTOS в данных инфоблоках         
        $arPhotos = [];   
        if(isset($arFields["PROPERTY_VALUES"][$photosPropId])){             
            foreach($arFields["PROPERTY_VALUES"][$photosPropId] as $keyPhoto => $arPhoto){
                if(!empty($arPhoto)){
                    if(1*$keyPhoto == 0){                
                        $arPhotos[$keyPhoto] = ($arPhoto["DESCRIPTION"]!=="") ? $arPhoto["DESCRIPTION"] : $arPhoto["VALUE"]["name"];
                    }
                }                
            }
        }       
        if(!empty($arFields["ID"])){
            $res = CIBlockElement::GetProperty($arFields["IBLOCK_ID"], $arFields["ID"], "sort", "asc", array("ID" => $photosPropId));               
            while ($ob = $res->GetNext()){                            
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
