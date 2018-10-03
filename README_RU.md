# Denwer 5 (со вкусом Docker)
Лет десять назад Дмитрий Котеров создал отличный проект под названием [Denwer](http://denwer.ru).  

Денвер содержал все необходимое для локальной разработки на PHP (Apache, PHP + mods, Mysql, sendmail, etc) 
и в свое время был очень популярн и востребован.
Со временем он, как и большинство проектов, был заброшен (последняя актуальная версия на сайте - PHP 5.3.13), 
а предлагаемые им подходы в организации разработки на PHP с тех пор сильно устарели.  

Данный проект - попытка воссоздать комплекс, содержащий все необходимое для разработки на PHP, но используя современные инструменты, 
сохранив при этом удобство использования и простоту установки (хм..).

Denwer 5 содержит в себе готовые для работы компоненты:
- nginx (к черту Apache)
- php-fpm 7.2 (apcu, curl, mbstring, mysqli, opcache, pdo_mysql, memcached, redis)
- composer
- MySQL 5.6
- adminer (PhpMyAdmin слишком жирный и неповоротливый)
- redis 4.0
- memcache 4.6.3
- чего то не хватает? pull-request в помощь



## Быстрая навигация
[Как использовать?](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Как-использовать) 

[Описание внутренней структуры](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Описание-внутренней-структуры-denwer-5)

[Где положить PHP код?](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Где-положить-php-код) 

[Перенос Denwer на диск D](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Перенос-denwer-на-диск-d)

[F.A.Q](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#faq)

[Проблемы и их решения](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Проблемы-и-их-решения)



## Как использовать?

### 1. Установите Docker

[Docker Toolbox for Windows](https://docs.docker.com/toolbox/toolbox_install_windows/) - для Windows 7, 8, 10 Home  
```text
В процессе установки выберите все опциональные компоненты (Full Installation):
+ Docker Compose
+ VirtualBox
+ Kitematic
+ Git for Windows

> Создайте ярлыки на рабочем столе!
```

[Docker for Windows](https://docs.docker.com/docker-for-windows/install/#start-docker-for-windows) - для Windows 10 Professional, Enterprise  
```text
Внимательно прочитайте инструкцию!
Вам будет необходимо включить поддержку Hyper-V, после чего запуск виртуалок в VirtualBox станет невозможен 
до отключения Hyper-V.
Если не уверены или используете VirtualBox - ставьте Docker Toolbox for Windows выше. 
```

[Docker Toolbox for macOS](https://docs.docker.com/toolbox/toolbox_install_mac/) - для macOS
  



### 2. Клонируйте этот репозиторий

Для упрощения дальнейших объяснений мы будем устанавливать Denwer в папку `Denwer`, 
а имя нашего пользователя  в Windows будет `User`.  
Полный путь инсталяции: `C:/Users/User/Denwer`

**Важная информация для пользователей WINDOWS**  
```text
Из-за ограничений доступа Docker Toolbox for Windows к файловой системе хост-машины, 
работа возможна только из домашней директории текущего пользователя!
Например, можно склонировать репозиторий в [C:/Users/$USER/Denwer], 
где $USER - имя вашего пользователя в Windows.
```

P.S. Существует способ обойти данное ограничение и установить Denwer в произвольную директорию, этим мы займемся немного 
позже (см. [Перенос Denwer на диск D](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Перенос-denwer-на-диск-d)).


### 3. Запуск Denwer
- Запустите "Docker Quickstart Terminal" с рабочего стола.  
**Первый запуск может быть долгим, т.к. создается виртуалка в VirtualBox**

- Перейдите в папку со склонированным репозиторием 
```bash
# абсолютный путь имеет схожий с *nix формат /drive/dir1/dir2/....
cd /c/Users/User/Denwer
# или
cd ~/Denwer
```

- Запустим Denwer
```bash
# запустим Denwer (первый запуск будет долгим, т.к. собирается кастомный образ PHP)
docker-compose up -d
```

### 4. Проверка состояния Denwer
- Запустите "Docker Quickstart Terminal" с рабочего стола. 
- Перейдите в папку со склонированным репозиторием
```bash
cd /c/Users/User/Denwer
```
- Проверим состояние контейнеров
```bash
docker-compose ps
```

- Видим что все контейнеры находятся в рабочем состоянии (State = Up).
```text
      Name                    Command               State           Ports
----------------------------------------------------------------------------------
denwer_adminer     entrypoint.sh docker-php-e ...   Up      0.0.0.0:8080->8080/tcp
denwer_memcached   docker-entrypoint.sh memcached   Up      11211/tcp
denwer_mysql       docker-entrypoint.sh --inn ...   Up      3306/tcp, 33060/tcp
denwer_nginx       nginx -g daemon off;             Up      0.0.0.0:80->80/tcp
denwer_php         docker-php-entrypoint php-fpm    Up      9000/tcp
denwer_redis       docker-entrypoint.sh redis ...   Up      6379/tcp
```
Если что-то не работает - смотрим [Проблемы и их решения](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Проблемы-и-их-решения)



### 5. Открываем в браузере и видим что все работает 
- Открываем в браузере `http://192.168.99.100`
- Видим вывод тестового скрипта, который пытаеся связаться с MySQL, Redis и Memcache
```text
/var/www/projects/default/public/index.php:8:string '2018-10-03 12:42:33' (length=19)
/var/www/projects/default/public/index.php:14:int 1538570553
/var/www/projects/default/public/index.php:20:string '1538570553' (length=10)
```
- Если ничего не открылось - [какой IP получил Denwer](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Как-узнать-какой-ip-у-denwer) 

**Denwer 5 поддерживает мультипроектность!**  
Подробнее об этом читайте в [где положить PHP код?](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Где-положить-PHP-код)



### 6. Остановка Denwer

- Запустите "Docker Quickstart Terminal" с рабочего стола. 
- Перейдите в папку со склонированным репозиторием
```bash
cd /c/Users/User/Denwer
```

- Остановим Denwer
```bash
docker-compose down
```

- Проверим состояние контейнеров
```bash
docker-compose ps
```

- Ни одного запущеного контейнера =)
```text
Name   Command   State   Ports
------------------------------
```


## Описание внутренней структуры Denwer 5
- `./build`  
Здесь находятся Dockerfile кастомных контейнеров, которые собираются "под себя".

- `./config`  
Здесь лежат конфиги компонентов, которые пробрасываются внутрь контейнра (например nginx.conf, php.ini).   
После изменений в конфигах нужно перезапустить Denwer и он подтянет все изменения!

- `./data`  
Постоянное хранилище для stateful-контейнеров (БД).
Можно смело удалять все файлы (кроме файла .gitkeep) внутри папок `mysql` или `redis`, это обнулит БД и заставит
Denwer инициализировать ее пустой заново (сначала выключаем Denwer, потом чистим, потом включаем).

- `./env`  
Файлы окружениия, которые пробрасываются внутрь контейнеров.

- `./projects`  
Здесь лежат ваши проекты на PHP. (см. [Где положить PHP код](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Где-положить-PHP-код))

- `./docker-compose.yml`  
Описание всех контейнеров комплекса для Docker Compose.


## Где положить PHP код
@todo


## Перенос Denwer на диск D
@todo


## F.A.Q

### Как узнать какой IP у Denwer?
- Запустите "Docker Quickstart Terminal" с рабочего стола.
- Выведите список докер-машин командой
```bash
docker-machine ls
```
- Смотрим IP в выводе в колонке URL (в моем случае IP = 192.168.99.100):
```text
NAME      ACTIVE   DRIVER       STATE     URL                         SWARM   DOCKER        ERRORS
default   *        virtualbox   Running   tcp://192.168.99.100:2376           v18.06.1-ce
```
- Открываем в браузере `http://192.168.99.100`

### Как запустить composer?
@todo


### Где найти Adminer?
- Открываем в браузере `http://192.168.99.100:8080`, пользуемся (см. [логин и пароль к MySQL](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Как-с-php-подключиться-к-mysql-redis-memcache)).
- Если не открывается, значит Denwer получил другой IP (см. [какой IP получил Denwer](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Как-узнать-какой-ip-у-denwer))


### Как с PHP подключиться к MySQL, Redis, Memcache?
- Смотрите файл `./projects/default/index.php`, там есть примеры подключения ко всем БД.
- Если файл потерялся, то вот креды:
```text
Mysql:
    host=mysql
    port=3306
    user=root
    pass=root
    
Redis:
    host=redis
    port=6379
    
Memcached:
    host=memcached
    port=11211        
```


### Как с компа подключиться к MySQL, Redis, Memcache?
Для этого нужно пробросить порты из виртуальных машин на хост систему.
- [Остановите Denwer](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#6-Остановка-denwer)
- Откройте файл `./docker-compose.yml`
- Найдите секцию `ports` для сервисов `mysql`, `redis` и `memcached`
- Откомментируйте их (убрать решекти с двух строк для каждого сервиса)
- Должно получиться так
```yml
ports:
  - "6379:6379"
```
- Запустите Denwer
- Подключайтесь к внешнему IP Denwer [какой IP получил Denwer](https://github.com/Shcneider/denwer5/blob/master/README_RU.md#Как-узнать-какой-ip-у-denwer)

## Проблемы и их решения
@todo






