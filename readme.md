search
---------------------
### Страница для поиска репозиториев на GitHub: можно задать одно или несколько правил и получить список репозиториев, удовлетворяющих этим правилам.  

Поля: 
Field - выпадающий список (size, forks, stars, followers)
Operator - выпадающий список - операторы больше, меньше, равно. 
Value - значение, целое число

При нажатии delete правило удаляется 
При нажатии Clear все правила удаляются, и добавляется одно пустое правило.
При нажатии Add Rule добавляется пустое правило в конец.
При нажатии Apply правила в JSON отправляются на сервер.

2.PHP
На сервере PHP скрипт формирует запрос к GitHub Search API  
https://developer.github.com/v3/search/#search-repositories
и выдает страницу с списком репозиториев, удовлетворяющих условиям.  
Для каждого репозитория должно выводиться его название  
(со ссылкой на репозиторий), размер, число форков, followers и звезд.