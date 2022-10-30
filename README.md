# Configuration

    menu:
        db_driver: orm модель данных
        factory: App\Menu\Factory\MenuFactory фабрика для создания объектов,
                 недостающие значения можно разрешить только на уровне Mediator
        entity: App\Menu\Entity\Menu сущность
        constraints: Вкл/выкл проверки полей сущности по умолчанию
        dto_class: App\Menu\Dto\MenuDto класс dto с которым работает сущность
        preserve_dto: App\Menu\Dto\Preserve\MenuDto мутабельный класс dto используется для генерации пользователя через консольную команду
        decorates:
          command - декоратор mediator команд пользователя 
          query - декоратор mediator запросов пользователя
        services:
          pre_validator - переопределение сервиса валидатора user
          create_bridge - переопределение сервиса моста между командой и логикой создания menu
          handler - переопределение сервиса обработчика сущностей
        registry:
          PredefinedMenu - выключение default menu 

# CQRS model

Actions в контроллере разбиты на две группы создание, редактирование, удаление данных

        1. putAction(PUT), postAction(POST), deleteAction(DELETE), registryAction(POST)

получение данных

        2. getAction(GET), criteriaAction(GET)

каждый метод работает со своим менеджером

        1. CommandManagerInterface
        2. QueryManagerInterface

При переопределении штатного класса сущности, дополнение данными осуществляется декорированием, с помощью MediatorInterface

группы сериализации

    1. API_GET_MENU, API_CRITERIA_MENU - получение menu
    2. API_POST_MENU - создание menu
    3. API_PUT_MENU -  редактирование menu
    4. API_POST_REGISTRY_MENU -  создание menu из registry

# Статусы:

    создание:
        меню создано HTTP_CREATED 201
    обновление:
        меню обновлено HTTP_OK 200
    удаление:
        меню удалено HTTP_ACCEPTED 202
    получение:
        меню(и) найдены HTTP_OK 200
    ошибки:
        если меню не найдено MenuNotFoundException возвращает HTTP_NOT_FOUND 404
        если меню не уникалено UniqueConstraintViolationException возвращает HTTP_CONFLICT 409
        если меню не прошело валидацию MenuInvalidException возвращает HTTP_UNPROCESSABLE_ENTITY 422
        если меню не может быть сохранено MenuCannotBeSavedException возвращает HTTP_NOT_IMPLEMENTED 501
        все остальные ошибки возвращаются как HTTP_BAD_REQUEST 400

# Constraint

## Description
Формат ответа от сервера содержит статус код и имеет следующий стандартный формат
```text
    [
        TypeModel::TYPE => string,
        PayloadModel::PAYLOAD => array,
        MessageModel::MESSAGE => string,
    ];
```
где
TYPE - типа ответа

    ERROR - ошибка
    NOTICE - уведомление
    INFO - информация
    DEBUG - отладка

MESSAGE - от кого пришло сообщение
PAYLOAD - массив данных

## Notice

показать проблемы кода

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php --verbose --diff --dry-run
```

применить исправления

```bash
vendor/bin/php-cs-fixer fix --config=.php-cs-fixer.dist.php
```

# Тесты:

    composer install --dev

### run all tests

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost

    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/ApiControllerTest.php --filter "/::testPost( .*)?$/" 

## Thanks

## Done

## License
    PROPRIETARY
