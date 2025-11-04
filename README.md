# ArshinParcer
Стек: Linux, Nginx, Python, Selenium, Chrome for developers
Проект предназначен для работы с порталом fgis.gost.ru . Последний не позволяет фильтровать СИ (средство измерения) по периодичности поверки. Единственный выход - перебирать карточки СИ и считывать оттуда информацию о поверке. Для автоматизации этой работы создан этот программный продукт. Он позволяет заполнить параметры поисковой формы, в автоматическом режиме перебрать все выданные карточки и сформировать Excel файл с данными всех карточек. 
Общая схема взаимодействия:
![Image](https://github.com/Pavelzu/ArshinParcer/blob/main/img/schema.png)
Пример выходного Excel-файла
![Image](https://github.com/Pavelzu/ArshinParcer/blob/main/img/excel.png)
Во время выполнения скрипта выводятся логи последней зкпущенной задачи 
![Image](https://github.com/Pavelzu/ArshinParcer/blob/main/img/main2.png)
А также, по отдельному адресу можно посмотреть историю логов всех запросов 
![Image](https://github.com/Pavelzu/ArshinParcer/blob/main/img/logs.png)
Результаты поисковых запросов выведены на отдельную страницу. Доступен функционал сортировки списка результатов
![Image](https://github.com/Pavelzu/ArshinParcer/blob/main/img/results1.png)
