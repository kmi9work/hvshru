<?php //функции

function show($obj){
return "
      <div class=\"contentLayout\">
        <div class=\"sidebar1\">
          <div class=\"Block\">
            <div class=\"Block-tl\"></div>
            <div class=\"Block-tr\"><div></div></div>
            <div class=\"Block-bl\"><div></div></div>
            <div class=\"Block-br\"><div></div></div>
            <div class=\"Block-tc\"><div></div></div>
            <div class=\"Block-bc\"><div></div></div>
            <div class=\"Block-cl\"><div></div></div>
            <div class=\"Block-cr\"><div></div></div>
            <div class=\"Block-cc\"></div>
            <div class=\"Block-body\">
              <div class=\"BlockHeader\">
                <div class=\"header-tag-icon\">
                  <div class=\"BlockHeader-text\">Рубрики сайта</div>
                </div>
                <div class=\"l\"></div>
                <div class=\"r\"><div></div></div>
              </div>
              <div class=\"BlockContent\">
              	<div class=\"BlockContent-body\">
                  <div>
                    <ul><li><b><a href=\"index.php\">Главная страница</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=redaction\">Редакционная коллегия</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=history\">Страницы истории журнала</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=headlines\">Содержание</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=subscribe\">Подписка</a></b></li></ul> 
                    <ul><li><b><a href=\"index.php?p=authors\">Авторам</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=advertiser\">Рекламодателям</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=contact\">Контакты</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=summary\">Аннотации статей</a></b></li></ul>
                    <ul><li><b><a href=\"index.php?p=links\">Полезные ссылки</a></b></li></ul>
                  </div>
              	</div>
              </div>
            </div>
          </div>
        </div>
";
break;	
};

?>
