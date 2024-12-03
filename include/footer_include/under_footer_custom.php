<?php if ($APPLICATION->GetCurDir() == '/'): ?>
 <?$APPLICATION->IncludeComponent(
    "siberia:youtube",
    "main",
    Array(
     //"API_TOKEN_YOUTUBE" => 'AIzaSyBPCg15EoNVyOTIqiTwNla5jZpKO07O-xo',
       "API_TOKEN_YOUTUBE" => 'AIzaSyDfwy_NPF-LDlIc2t7JKGXzt386-WLK90w',
       "CHANNEL_ID_YOUTUBE" => "UCLMxls9urKSgQdE7setOt9w",
       "SORT_YOUTUBE" => 'rating',
       "PLAYLIST_ID_YOUTUBE" => '',
       "COUNT_VIDEO_YOUTUBE" => 5,
       "COUNT_VIDEO_ON_LINE_YOUTUBE" => 4,
       "TITLE" => 'Наши видео',
       "SHOW_TITLE" => "Y",
       "ITEMS_OFFSET" => "Y",
       "TITLE_POSITION" => "NORMAL",
       "SUBTITLE" => "",
       "RIGHT_TITLE" => "Все видео",
       "WIDE" => "N",
       "COMPOSITE_FRAME_MODE" => "A",
       "COMPOSITE_FRAME_TYPE" => "AUTO",
       "CACHE_TYPE" => "A",
       "CACHE_TIME" => "86400",
       "CACHE_GROUPS" => "N",
       "RIGHT_LINK_EXTERNAL" => 1,
    )
 );?>
<?php endif; ?>
