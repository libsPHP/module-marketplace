# Публикация модуля в Packagist

## Шаги для публикации

### 1. Подготовка завершена ✅
- [x] Composer.json настроен и валиден
- [x] Git тег v1.0.0 создан и загружен в GitHub
- [x] Все файлы модуля готовы

### 2. Публикация в Packagist

#### Вариант A: Автоматическая публикация (рекомендуется)

1. Перейдите на [Packagist.org](https://packagist.org)
2. Войдите в систему или зарегистрируйтесь
3. Нажмите "Submit" в верхнем меню
4. Введите URL репозитория: `https://github.com/libsPHP/module-marketplace`
5. Нажмите "Check" для проверки пакета
6. Если все в порядке, нажмите "Submit"

#### Вариант B: Ручная публикация через GitHub

1. Создайте аккаунт на [Packagist.org](https://packagist.org)
2. Подключите GitHub аккаунт
3. Выберите репозиторий `libsPHP/module-marketplace`
4. Настройте автоматическое обновление через GitHub webhook

### 3. Настройка автоматического обновления

После публикации в Packagist:

1. Перейдите в настройки пакета на Packagist
2. Добавьте GitHub webhook URL: `https://packagist.org/api/github?username=YOUR_PACKAGIST_USERNAME&apiToken=YOUR_API_TOKEN`
3. В настройках GitHub репозитория добавьте webhook с этим URL

### 4. Проверка публикации

После публикации проверьте:

```bash
# Проверка доступности пакета
composer show nativemind/module-marketplace

# Установка пакета
composer require nativemind/module-marketplace
```

### 5. Обновление версий

Для публикации новых версий:

1. Внесите изменения в код
2. Обновите версию в composer.json (если нужно)
3. Создайте новый git тег:
   ```bash
   git tag -a v1.0.1 -m "Release version 1.0.1"
   git push origin v1.0.1
   ```
4. Packagist автоматически обнаружит новую версию

## Текущий статус

- ✅ Репозиторий: https://github.com/libsPHP/module-marketplace
- ✅ Тег версии: v1.0.0
- ✅ Composer.json: валиден
- ⏳ Публикация в Packagist: ожидает выполнения

## Ссылки

- [Packagist.org](https://packagist.org)
- [Документация Packagist](https://packagist.org/about)
- [GitHub репозиторий](https://github.com/libsPHP/module-marketplace)
