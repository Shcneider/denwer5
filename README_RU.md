# Denwer 5 (со вкусом Docker)
Лет десять назад Дмитрий Котеров создал отличный проект под названием [Denwer](http://denwer.ru).  

Денвер содержал все необходимое для локальной разработки на PHP (Apache, PHP + mods, Mysql, sendmail, etc) 
и в свое время был очень популярен и востребован.
Со временем он, как и большинство проектов, был заброшен (последняя актуальная версия на сайте - PHP 5.3.13), 
а предлагаемые им подходы в организации разработки на PHP с тех пор сильно устарели.  

Данный проект - попытка воссоздать комплекс, содержащий все необходимое для разработки на PHP, но используя современные инструменты, 
сохранив при этом удобство использования и простоту установки (хм..).

Denwer 5 содержит в себе готовые для работы компоненты:
- nginx (к черту Apache)
- php-fpm 7.2 (apcu, curl, mbstring, mysqli, opcache, pdo_mysql, memcached, redis, zip, xdebug)
- composer
- git
- MySQL 5.6
- adminer (PhpMyAdmin слишком жирный и неповоротливый)
- redis 4.0
- memcache 4.6.3
- чего то не хватает? pull-request в помощь



## Быстрая навигация
- [Как использовать?](#Как-использовать)  
    - [Установка Docker](#1-Установите-docker)
    - [Клонируем репозиторий](#2-Клонируйте-этот-репозиторий)
    - [Запуск Denwer](#3-Запуск-denwer)
    - [Проверка состояния Denwer](#4-Проверка-состояния-denwer)
    - [Открываем в браузере](#5-Открываем-в-браузере-и-видим-что-все-работает)
    - [Остановка Denwer](#6-Остановка-denwer)
- [Описание внутренней структуры](#Описание-внутренней-структуры-denwer-5)  
- [Куда положить PHP код?](#Куда-положить-php-код)   
    - [Один проект, доступ по IP](#Один-проект-доступ-по-ip)
    - [Мультипроектность, доступ по домену](#Мультипроектность-с-поддержкой-доменов-для-каждого-проекта)
- [Перенос Denwer на диск D](#Перенос-denwer-на-диск-d)  
- [F.A.Q](#faq)  
  - [Как узнать какой IP у Denwer?](#Как-узнать-какой-ip-у-denwer)
  - [Как запустить composer?](#Как-запустить-composer)
  - [Где найти Adminer?](#Где-найти-adminer)
  - [Где найти PhpMyAdmin?](#Где-найти-phpmyadmin)
  - [Как с PHP подключиться к MySQL, Redis, Memcache?](#Как-с-php-подключиться-к-mysql-redis-memcache)
  - [Как с компа подключиться к MySQL, Redis, Memcache?](#Как-с-компа-подключиться-к-mysql-redis-memcache)
  - [Как добавить расширение к PHP](#Как-мне-включить-расширение-php-любое)
  - [Как поменять версию PHP](#Как-поменять-версию-php-на-71-70-56)
- [Проблемы и их решения](#Проблемы-и-их-решения)







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

**Важная информация для пользователей WINDOWS**  
```text
Из-за ограничений доступа Docker Toolbox for Windows к файловой системе хост-машины, 
работа возможна только из домашней директории текущего пользователя!
Например, можно склонировать репозиторий в [C:/Users/$USER/Denwer], 
где $USER - имя вашего пользователя в Windows.
```

Для упрощения дальнейших объяснений мы будем устанавливать Denwer в папку `Denwer`, 
а имя нашего пользователя  в Windows будет `User`.  
Полный путь инсталяции: `C:/Users/User/Denwer`

P.S. Существует способ обойти данное ограничение и установить Denwer в произвольную директорию, этим мы займемся немного 
позже (см. [Перенос Denwer на диск D](#Перенос-denwer-на-диск-d)).


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

- Запустим Denwer (первый запуск будет долгим, т.к. собирается кастомный образ PHP)
```bash
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
Если что-то не работает - смотрим [проблемы и их решения](#Проблемы-и-их-решения)



### 5. Открываем в браузере и видим что все работает 
- Открываем в браузере `http://192.168.99.100`
- Видим вывод тестового скрипта, который пытаеся связаться с MySQL, Redis и Memcache
```text
/var/www/projects/default/public/index.php:8:string '2018-10-03 12:42:33' (length=19)
/var/www/projects/default/public/index.php:14:int 1538570553
/var/www/projects/default/public/index.php:20:string '1538570553' (length=10)
```
- Если ничего не открылось - значит Denwer получил другой IP адрес, а не 192.168.99.100.  
Смотрим [какой IP получил Denwer](#Как-узнать-какой-ip-у-denwer) 

**Denwer 5 поддерживает мультипроектность!**  
Подробнее об этом читайте в [мультипроектность Denwer](#Куда-положить-php-код)


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

- Ни одного запущенного контейнера =)
```text
Name   Command   State   Ports
------------------------------
```


## Описание внутренней структуры Denwer 5

- `./etc`  
Здесь лежат конфиги компонентов, которые пробрасываются внутрь контейнера (например nginx.conf, php.ini).   
После изменений в конфигах нужно перезапустить Denwer и он подтянет все изменения!

- `./var`  
Постоянное хранилище для stateful-контейнеров (БД).
Можно смело удалять все файлы (кроме файла .gitkeep) внутри папок `mysql` или `redis`, это обнулит БД и заставит
Denwer инициализировать ее пустой заново (сначала выключаем Denwer, потом чистим, потом включаем).

- `./env`  
Файлы окружения, которые пробрасываются внутрь контейнеров.

- `./home`  
Здесь лежат ваши проекты на PHP. 
(см. [где положить PHP код](#Куда-положить-php-код))

- `./docker-compose.yml`  
Описание всех контейнеров комплекса для Docker Compose.




## Куда положить PHP код
Denwer предлагает два подхода по размещению кода внутри:
- Многопроектность с поддержкой доменов для каждого проекта
- Однопроектность по IP

### Один проект, доступ по IP
- Положите все ваши файлы в `./home/default`
- Ваш сайт будет доступен по IP `http://192.168.99.100` (если не работает - Denwer получил другой IP, 
  см. [какой IP получил Denwer](#Как-узнать-какой-ip-у-denwer) )
- Обратите внимание, `index.php` должен находится в подпапке `public`, а не в корне проекта! (`./home/default/public/index.php`)

### Мультипроектность с поддержкой доменов для каждого проекта
- Каждая папка внутри `./home` является самостоятельным проектом и доступна по имени вида `*.denwer`
  (например, проект по умолчанию `default`, который распологается в `./home/default` доступен по адресу `http://default.denwer/`)
- Необходимо добавить запись о домене `default.denwer` в файл `C:\Windows\System32\drivers\etc\hosts` на вашем ПК:
```text
192.168.99.100 default.denwer
192.168.99.100 project1.denwer
192.168.99.100 project2.denwer
```
- Вместо `192.168.99.100` используйте IP вашего Denwer. 
([Какой IP получил Denwer](#Как-узнать-какой-ip-у-denwer))
- По умолчанию файл `C:\Windows\System32\drivers\etc\hosts` защищен от записи. Используйте google для разблокировки :)



## Перенос Denwer на диск D
- Останаливаем Denwer
- Выключаем нашу docker machine
```bash
docker-machine stop default
```
- Копируем нашу установку Denwer на новое место.  
    - Старый путь установки: `C:\Users\User\Denwer`  
    - Новый путь установки: `D:\Denwer` (можете выбрать любой удобный для себя)  
- Открываем VirtualBox, заходим в настройки нашей виртуалки с Docker (называется default)
- Переходим в подпункт `Общие папки` и добавляем новую общую папку (плюсик справа) с такими настройками:  
    - Путь к папке: `D:\Denwer`  
    - Имя папки: `d/Denwer`  
    - Автоподключение: да  
- Обратите внимание, что `Имя папки` должно повторять `Путь к папке` с учетом особенностей маппинга пути Windows на Lunix:
    - `E:\Work\PurpleGames\Denwer` => `e/Work/PurpleGames/Denwer`
    - `D:\SomeFolder\DENWER` => `d/SomeFolder/DENWER`
- Запускаем нашу Docker Machine
```bash
docker-machine start default
```
- Запускаем Denwer  
Если что-то не работает - смотрим [проблемы и их решения](#Проблемы-и-их-решения)


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
К сожалению, запуск composer весьма геморный. Я так и не придумал, как сделать проще.
- Запустите "Docker Quickstart Terminal" с рабочего стола.
- [Запустите Denwer](#3-Запуск-denwer) если он еще не запущен.
- Выведите список докер-контейнеров командой
```bash
docker ps
```

Получим список запущенных контейнеров и их ID:
```text
$ docker ps
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                    NAMES
fb89fba895e6        nginx:alpine        "nginx -g 'daemon of…"   15 minutes ago      Up 15 minutes       0.0.0.0:80->80/tcp       denwer_nginx
0990ee151622        mysql:5.7           "docker-entrypoint.s…"   15 minutes ago      Up 15 minutes       3306/tcp, 33060/tcp      denwer_mysql
792ddf6a2d36        adminer:latest      "entrypoint.sh docke…"   15 minutes ago      Up 15 minutes       0.0.0.0:8080->8080/tcp   denwer_adminer
45429bd1a9be        redis:latest        "docker-entrypoint.s…"   15 minutes ago      Up 15 minutes       6379/tcp                 denwer_redis
9107c023ae3a        memcached:latest    "docker-entrypoint.s…"   15 minutes ago      Up 15 minutes       11211/tcp                denwer_memcached
270523e08605        denwer5_php         "docker-php-entrypoi…"   15 minutes ago      Up 15 minutes       9000/tcp                 denwer_php
```

- Нас интересует контейнер c именем (NAMES) `denwer_php`
- Смотрим `CONTAINER ID` для контейнера `denwer_php` = `270523e08605`
- Заходим в интерактивном режиме в контейнер:
```bash
# указан полный контейнер id
docker exec -it 270523e08605 bash
# можно указать первые три символа, так быстрее
docker exec -it 270 bash
```
- Мы вошли внутрь конейтера, находимся в `/var/www/html`
```bash
root@270523e08605:/var/www/html#
```

- Переходим внутрь нашего проекта (я перейду в проект по умочанию `default`)
```bash
cd /var/www/projects/default
```
- Выполняем `composer install` или `composer update`


### Где найти Adminer?
- Открываем в браузере `http://192.168.99.100:8080`, пользуемся (см. [логин и пароль к MySQL](#Как-с-php-подключиться-к-mysql-redis-memcache)).
- Если не открывается, значит Denwer получил другой IP (см. [какой IP получил Denwer](#Как-узнать-какой-ip-у-denwer))


### Где найти PhpMyAdmin?
Нигде. Используйте Adminer.


### Как с PHP подключиться к MySQL, Redis, Memcache?
- Смотрите файл `./home/default/index.php`, там есть примеры подключения ко всем БД.
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
- [Остановите Denwer](#6-Остановка-denwer)
- Откройте файл `./docker-compose.yml`
- Найдите секцию `ports` для сервисов `mysql`, `redis` и `memcached`
- Откомментируйте их (убрать решекти с двух строк для каждого сервиса)
- Должно получиться так
```yml
ports:
  - "6379:6379"
```
- [Запустите Denwer](#3-Запуск-denwer)
- Подключайтесь к внешнему IP Denwer [какой IP получил Denwer](#Как-узнать-какой-ip-у-denwer)


### Как мне включить расширение PHP (любое)?
- mkdir `./build/php`
- Clone repository `https://github.com/Shcneider/denwer5-php7.2-docker-image` into `./build/php`
- Add custom extensions in `Dockerfile`
- Edit `docker-compose.yml`: comment `image` section of service `php`, uncomment `build` of service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!

### Как поменять версию PHP на 7.1, 7.0, 5.6?
- mkdir `./build/php`
- Clone repository `https://github.com/Shcneider/denwer5-php7.2-docker-image` into `./build/php`
- Change PHP version in `Dockerfile` (first line)
- Edit `docker-compose.yml`: comment `image` section of service `php`, uncomment `build` of service `php`
- Run `docker-compose build`
- Run Denwer
- Your custom php image is ready and work!




## Проблемы и их решения
@todo






