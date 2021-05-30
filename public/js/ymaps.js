ymaps.ready(init);
function init(){

        // Создание карты.
    var myMap = new ymaps.Map("map", {
        // Координаты центра карты.
        // Порядок по умолчанию: «широта, долгота».
        // Чтобы не определять координаты центра карты вручную,
        // воспользуйтесь инструментом Определение координат.
        center: [59.95, 30.30], // это питер детка
        // Уровень масштабирования. Допустимые значения:
        // от 0 (весь мир) до 19.
        zoom: 10,



    });

            MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
                '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
            ),


                $.get(
                    '/api/getPoints', // адрес отправки запроса
                    // передача с запросом каких-нибудь данных
                    function(data) {
                        var json = JSON.parse(data);
                        json.forEach(function callback(point){
                            myPlacemark = new ymaps.Placemark([point["latitude"],point["longtitude"]], {
                                hintContent: point["name"],
                                balloonContent: point["name"]
                            }, {

                                iconLayout: 'default#image',

                                iconImageHref: 'images/shawerma.png',

                                iconImageSize: [30, 42],

                                iconImageOffset: [-5, -38]
                            }),

                                myMap.geoObjects
                                    .add(myPlacemark);


                        });
                    }
                );


}
