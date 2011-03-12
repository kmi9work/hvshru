<?php
echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" dir=\"ltr\" lang=\"en-US\" xml:lang=\"en\">
<head>
    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=EmulateIE7\" />
    <title>Журнал - \"Химия в школе\"</title>

    <script type=\"text/javascript\" src=\"theme/script.js\"></script>

    <link rel=\"stylesheet\" href=\"theme/style.css\" type=\"text/css\" media=\"screen\" />
		<link rel=\"stylesheet\" href=\"theme/style_ascii.css\" type=\"text/css\" media=\"screen\" />
    <!--[if IE 6]><link rel=\"stylesheet\" href=\"theme/style.ie6.css\" type=\"text/css\" media=\"screen\" /><![endif]-->
</head>
<body>
<div class=\"PageBackgroundSimpleGradient\">
</div>
<div class=\"Main\">
  <div class=\"Sheet\">
    <div class=\"Sheet-tl\"></div>
    <div class=\"Sheet-tr\"><div></div></div>
    <div class=\"Sheet-bl\"><div></div></div>
    <div class=\"Sheet-br\"><div></div></div>
    <div class=\"Sheet-tc\"><div></div></div>
    <div class=\"Sheet-bc\"><div></div></div>
    <div class=\"Sheet-cl\"><div></div></div>
    <div class=\"Sheet-cr\"><div></div></div>
    <div class=\"Sheet-cc\"></div>
    <div class=\"Sheet-body\">
      <div class=\"Header\">
        <div class=\"Header-png\"></div>
        <div class=\"Header-jpeg\"></div>
        <div class=\"logo\">
          <h1 id=\"name-text\" class=\"logo-name\"><a href=\"http://hvsh.ru\">Химия</a></h1>
          <div id=\"slogan-text\" class=\"logo-text\">в школе</div>
        </div>
      </div>
".show('leftmenu')."
      <div class=\"content\">
"; //уберем пока верхнее меню- show('topmenu').

echo $pageOut;

echo "
      </div>
    </div>
  </div>
</div>
                <div class=\"cleared\"></div><div class=\"Footer\">
                    <div class=\"Footer-inner\">
                        <div class=\"Footer-text\">
                            <p><a href=\"http://hvsh.ru\">Химия в школе</a> | <a href=\"index.php?p=contact\">Обратная связь</a><br />
                                Издательство &laquo;Центрхимпресс&raquo; &copy; 2009 \"Химия в школе\". Все публикации в журнале «Химия в школе» охраняются законом РФ «Об авторском праве и смежных правах» и распространение этих материалов в любом виде, в том числе и в Интернете, без согласия редакции недопустимо и будет преследоваться по закону.</p>
                        </div>
                    </div>
                    <div class=\"Footer-background\"></div>
                </div>
            </div>
        </div>
        <div class=\"cleared\"></div>
    </div>
    
</body>
</html>";
?>
