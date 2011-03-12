<br>
<h1>Издательство &laquo;Центрхимпресс&raquo;.</h1>
<p class="first">Телефон(факс): (499) 763-30-93.</p>
<p>E-mail: info@hvsh.ru</p>
<p>Адрес редакции: 105066, Москва, ул. Ольховская, д. 45, Стр. 1, комн. 314. Домофон 116. <br>
   Внутренний телефон 261.</p>

<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту  (начало) -->
<script src="http://api-maps.yandex.ru/1.1/?key=AHBx0EwBAAAASBqxGgIAi0eX24a6CiiGvF8wcZjp_AjnZ6IAAAAAAAAAAABxbuUPqvn0m74SkQWp_IoCX-eSZA==&wizard=constructor" type="text/javascript"></script>
<script type="text/javascript">
    YMaps.jQuery(window).load(function () {
        var map = new YMaps.Map(YMaps.jQuery("#YMapsID-1544")[0]);
        map.setCenter(new YMaps.GeoPoint(37.672478,55.777606), 16, YMaps.MapType.MAP);
        map.addControl(new YMaps.Zoom());
        map.addControl(new YMaps.ToolBar());
        map.addControl(new YMaps.TypeControl());

        YMaps.Styles.add("constructor#pmrdmPlacemark", {
            iconStyle : {
                href : "http://api-maps.yandex.ru/i/0.3/placemarks/pmrdm.png",
                size : new YMaps.Point(28,29),
                offset: new YMaps.Point(-8,-27)
            }
        });

       map.addOverlay(createObject("Placemark", new YMaps.GeoPoint(37.673014,55.777715), "constructor#pmrdmPlacemark", "\"Химия в школе\""));
        
        function createObject (type, point, style, description) {
            var allowObjects = ["Placemark", "Polyline", "Polygon"],
                index = YMaps.jQuery.inArray( type, allowObjects),
                constructor = allowObjects[(index == -1) ? 0 : index];
                description = description || "";
            
            var object = new YMaps[constructor](point, {style: style, hasBalloon : !!description});
            object.description = description;
            
            return object;
        }
    });
</script>

<div id="YMapsID-1544" style="width:450px;height:350px"></div>
<div style="width:450px;text-align:right;font-family:Arial"><a href="http://api.yandex.ru/maps/tools/constructor/" style="color:#1A3DC1">Создано с помощью инструментов Яндекс.Карт</a></div>
<!-- Этот блок кода нужно вставить в ту часть страницы, где вы хотите разместить карту (конец) -->