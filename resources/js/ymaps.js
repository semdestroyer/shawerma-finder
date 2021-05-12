ymaps.ready(init);
function init(){
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '/getPoints', true);

    xhr.send();

    xhr.onreadystatechange = function() {

    }

        // Создание карты.
    var myMap = new ymaps.Map("map", {
        // Координаты центра карты.
        // Порядок по умолчанию: «широта, долгота».
        // Чтобы не определять координаты центра карты вручную,
        // воспользуйтесь инструментом Определение координат.
        center: [59.57, 30.19], // это питер детка
        // Уровень масштабирования. Допустимые значения:
        // от 0 (весь мир) до 19.
        zoom: 7
    });

}
