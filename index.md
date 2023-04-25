# Сервис преобразования дат в текст

Проблема/Задача: Необходимо реализовать вывод дат в текстовом формате.
Пример:

- Если текущая дата равна входящей дате, то выводить фразу - "Сегодня";
- Если текущая дата раньше, чем входящая дата на один день, то выводить фразу - "Завтра";
- Если текущая дата позже, чем входящая дата на один день, то выводить фразу - "Вчера";

## Обязательные и необходимые вопросы для решения проблемы:

<ul>
<li> Что делать если дата не совпадает ни с одной?
    <ul>
        <li>Если текущий год, то вывести дату в формате: число с ведущим нулем и месяц текстом;</li>
        <li>Если НЕ текущий год, то вывести дату в формате: число с ведущим нулем и месяц текстом сокращенный и
            год
        </li>
    </ul>
</li>
<li> Выводим прописными или с заглавной?
    <ul>
        <li> Реализовать все варианты;</li>
    </ul>
</li>

<li>Делаем для всех такой текст или где-то иначе?
    <ul>
        <li> Нужно реализовать так, чтобы в одном месте была возможность расширять и
            только для этого модуля
        </li>
    </ul>
</li>
</ul>

## Финальный список задач

1. Реализовать класс для вывода даты в текстовом формате;
2. Реализовать варианты с прописными буквами и главными;
3. Реализовать расширенние модуля;
4. Реализовать вывод своей даты, если нет подходящей.

## Разбор

Первоначально, нам известно, что мы будем сравнить разные даты с какой-то входящей.
Как минимум, два параметра у нас уже есть, это текущая дата и входящая дата.

### Путь первый - реализация через конструктор

#### Реализовать класс для вывода даты в текстовом формате

Мы можем создать класс, реализовать в нем конструктор, который бы принимал входящую дату.
Пример:

```php
<?php

declare(strict_types=1);

namespace src;

use DateTime;

class UserFriendlyDateTimeConstructor
{
    protected readonly DateTime $today;

    /**
     * @param DateTime $userDateTime
     */
    public function __construct(protected readonly DateTime $userDateTime)
    {
        $this->today = new DateTime('today');
    }
}

```

Реализация простая, попробуем теперь перейти к проверке, для этого добавим метод:

```php
/**
 * Текущий ли день (проверяет день, месяц, год)
 * @return bool Возвращает true, если текущий день, иначе false
 */
public function isToday(): bool
{
    $userDateTime = $this->userDateTime->setTime(0, 0);

    return $this->today === $userDateTime;
}
```

Пока, все хорошо, остается реализовать вывод даты, добавим еще один метод:

```php
/**
 * @return string|null
 */
public function getDate(): ?string
{
    $value = null;

    if ($this->isToday()) {
        $value = 'сегодня';
    }

    return $value;
}
```

Класс реализован, полная реализация получается такой:
<details>
<summary>Полный класс UserFriendlyDateTimeText</summary>

```php
<?php

namespace src;

enum UserFriendlyDateTimeText: string
{
    case tomorrow = 'завтра';
    case yesterday = 'вчера';
    case today = 'сегодня';
    case dayBeforeYesterday = 'позавчера';
    case dayAfterTomorrow = 'после завтра';
}

```

</details>

<details>
<summary>Полный класс UserFriendlyDateTimeConstructor</summary>

```php
<?php

declare(strict_types=1);

namespace src;

use DateTime;use src\components\friendlyDate\UserFriendlyDateTimeText;

class UserFriendlyDateTimeConstructor
{
    protected readonly DateTime $today;
    protected readonly DateTime $dayBeforeYesterday;
    protected readonly DateTime $yesterday;
    protected readonly DateTime $tomorrow;
    protected readonly DateTime $dayAfterTomorrow;

    /**
     * @param DateTime $userDateTime
     */
    public function __construct(protected readonly DateTime $userDateTime)
    {
        $this->today = new DateTime('today');
        $this->dayBeforeYesterday = new DateTime('yesterday -1 day');
        $this->yesterday = new DateTime('yesterday');
        $this->tomorrow = new DateTime('tomorrow');
        $this->dayAfterTomorrow = new DateTime('tomorrow +1 day');
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        $value = null;

        if ($this->isToday()) {
            $value = UserFriendlyDateTimeText::today->value;
        }
        if ($this->isYesterday()) {
            $value = UserFriendlyDateTimeText::yesterday->value;
        }
        if ($this->isTomorrow()) {
            $value = UserFriendlyDateTimeText::tomorrow->value;
        }
        if ($this->isDayAfterTomorrow()) {
            $value = UserFriendlyDateTimeText::dayAfterTomorrow->value;
        }
        if ($this->isDayBeforeYesterday()) {
            $value = UserFriendlyDateTimeText::dayBeforeYesterday->value;
        }

        return $value;
    }

    public function isDayBeforeYesterday(): bool
    {
        $userDateTime = $this->resetUserDateTimeToMidnight($this->userDateTime);

        return $this->dayBeforeYesterday === $userDateTime;
    }

    public function isDayAfterTomorrow(): bool
    {
        $userDateTime = $this->resetUserDateTimeToMidnight($this->userDateTime);

        return $this->dayAfterTomorrow === $userDateTime;
    }

    public function isTomorrow(): bool
    {
        $userDateTime = $this->resetUserDateTimeToMidnight($this->userDateTime);

        return $this->tomorrow === $userDateTime;
    }

    public function isYesterday(): bool
    {
        $userDateTime = $this->resetUserDateTimeToMidnight($this->userDateTime);

        return $this->yesterday === $userDateTime;
    }

    /**
     * Текущий ли день (проверяет день, месяц, год)
     * @return bool Возвращает true, если текущий день, иначе false
     */
    public function isToday(): bool
    {
        $userDateTime = $this->resetUserDateTimeToMidnight($this->userDateTime);

        return $this->today === $userDateTime;
    }

    /**
     * @param DateTime $userDateTime
     * @return DateTime
     */
    protected function resetUserDateTimeToMidnight(DateTime $userDateTime)
    {
        return $userDateTime->setTime(0, 0);
    }
}

```

</details>

На выходе получился класс, решающий как миниму 2 задачи, а именно:

1. Реализовать класс для вывода даты в текстовом формате;
2. Реализовать варианты с прописными буквами и главными - метод ``getCapitalizedDate()``

#### Реализовать варианты с прописными буквами и главными

Рассмотрим варианты:

1. Параметр в методе;
2. Отдельный метод;
3. Декоратор;

##### Добавление параметра в метод

Добавим к методу ```getDate()``` параметр  ```bool $capitalized = false```;

```php
/**
 * @return string|null
 */
public function getDate(bool $capitalized = false): ?string
{
    $value = null;

    if ($this->isToday()) {
        $value = 'сегодня';
    }
    if ($value && $capitalized) {
        $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }

    return $value;
}
```

В данном решение есть проблемы, а именно:

1. При наследовании, нам придется повторять кусок кода с преобразованием;
2. Добавление входящего параметра, влечет за собой усложнение логики.

Для решения проблемы под номером один, мы можем использовать отдельный метод преобразования, но для решения второй
проблемы, у нас ничего нет.

##### Отдельный метод

Попробуем решить проблемы прошлого пункта текущим вариантом

```php
/**
 * @return string|null
 */
public function getCapitalizedDate(): ?string
{
    $value = $this->getDate();
    if ($value) {
        $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);
    }
    return $value;
}
```

Как видно из реализации, мы полностью решили все проблемы. Наследование и переопредление метода никак не повлияет
на логику нашего метода. Входящих параметров нет, а значит нет сложны конструкций if. Мы лишь проверяем возвращаемое
значение из основного метода и приводим к нужному формату.

##### Декоратор

Думаю, что нет смысла скрывать, что данное решение будет аналогичное как "Отдельный метод".
**Примечание:** Декоратор должен принимать на входе интерфейс!

<details>
<summary>Реализация через декоратор</summary>

```php
<?php

namespace src;

use DateTime;

class UserFriendlyDateTimeConstructorDecorator
{

    public function __construct(private readonly UserFriendlyDateTimeConstructor $userFriendlyDateTimeConstructor)
    {
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        $value = $this->userFriendlyDateTimeConstructor->getDate();

        if ($value) { 
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);;
        }
        return $value;
    }
    
    /**
     * @return string|null
     */
    public function getCapitalizedDate(): ?string
    {
        $value = $this->userFriendlyDateTimeConstructor->getDate();

        if ($value) { 
            $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);;
        }
        return $value;
    }
}
```

</details>

Как видим, данный вариант тоже рабочий, мы можем как переопределить метод, а можно сделать новый.
Удобства, что декоратор будет работать на всех классах наследниках, а значит, мы можем в любой момент взять
и подключить его, а если перестанет быть нужным, мы спокойно сможем уйти от него.

##### Вывод

Для решения задачи с прописными буквами, лучше выбирать варианты:

- Отдельный метод - уменьшает сложность методов, позволяет работать в наследниках;
- Декоратор - позволяет расширять логику не изменяею основной метод, можно расширять своими методами.

#### Реализовать расширение функционала

Расширять можно двумя способами:

- Наследованием;
- Декоратором.

###### Расширение через наследование

<details>
<summary> Расширение функционала с помощью наследования </summary>

```php
<?php

namespace src;

use DateTime;

class UserFriendlyDateTimeConstructorExtend extends UserFriendlyDateTimeConstructor
{
    protected DateTime $twoWeeksAgo;
    protected DateTime $twoWeeksLater;

    public function __construct(protected readonly DateTime $userDateTime)
    {
        parent::__construct($userDateTime);

        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        $value = parent::getDate();

        if ($this->isTwoWeeksAgo()) {
            $value = 'две недели назад';
        }
        if ($this->isTwoWeeksLater()) {
            $value = 'через две недели';
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function isTwoWeeksAgo(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);
        return $this->twoWeeksAgo === $userDateTime;
    }

    /**
     * @return bool
     */
    public function isTwoWeeksLater(): bool
    {
        $userDateTime = $this->castUserDateTimeToMidnight($this->userDateTime);
        return $this->twoWeeksLater === $userDateTime;
    }
}
```

</details>

##### Расширение через декоратор

**Примечание:** Декоратор в сигнатуре конструктора должен принимать интерфейс, а не конкретную реализацию!! Сейчас это
сделано для примера.
<details>
<summary>Расширение функционала с помощью декоратор</summary>

```php
<?php

namespace src;

use DateTime;

class UserFriendlyDateTimeConstructorDecoratorWorth
{
    protected DateTime $twoWeeksAgo;
    protected DateTime $twoWeeksLater;

    public function __construct(private readonly UserFriendlyDateTimeConstructor $userFriendlyDateTimeConstructor)
    {
        $this->twoWeeksAgo = new DateTime('-2 weeks midnight');
        $this->twoWeeksLater = new DateTime('+2 weeks midnight');
    }

    /**
     * @return string|null
     */
    public function getDate(): ?string
    {
        $value = $this->userFriendlyDateTimeConstructor->getDate();

        if (!$value) { 
            return $value;
        }
        // @todo нет доступа к данным объекта
        // $this->userFriendlyDateTimeConstructor->userDateTime
        // @todo нужно писать лишний метод для преобразования к 00:00:00 формату
        // $this->userFriendlyDateTimeConstructor->castUserDateTimeToMidnight(DateTime $userDateTime)


        return $value;
    }
}
```

</details>

Плюсы и минусы каждого решения:
<ul>
    <li>
        Наследование
        <ul style="list-style-type: '+ '">
            <li>Доступ к входящим данным;</li>
            <li>Возможность использовать базовые методы;</li>
        </ul>
        <ul style="list-style-type: '- '">
            <li>Нет возможности встроить свой класс (множественное наследование);</li>
        </ul>
    </li>
    <li>
        Декоратор
        <ul style="list-style-type: '+ '">
            <li>Изменяет логику конечного метода;</li>
        </ul>
        <ul style="list-style-type: '- '">
            <li>Нет доступа к основным данным;</li>
            <li>Нет возможности использовать закрытые методы;</li>
        </ul>
    </li>
</ul>

**Вывод:** С помощью **наследования**, мы получаем больше возможностей для управления,
**декоратор** же вредит и не позволяет решить задачу.

#### Реализовать вывод своей даты, если нет подходящей

Варианты решения:

- Добавить параметр в метод;
- Отдельный метод;
- Наследование;
- Декоратор;

##### Добавление параметра в метод

Для этого в метод ```getDate``` добавим параметр ```string $dateTimeFormat```.

```php
/**
 * @return string|null
 */
public function getDate(string $dateTimeFormat = 'd.m.Y'): string
{
    $value = null;

    if ($this->isToday()) {
        $value = UserFriendlyDateTimeText::today->value;
    }
    if ($this->isYesterday()) {
        $value = UserFriendlyDateTimeText::yesterday->value;
    }
    if ($this->isTomorrow()) {
        $value = UserFriendlyDateTimeText::tomorrow->value;
    }
    if ($this->isDayAfterTomorrow()) {
        $value = UserFriendlyDateTimeText::dayAfterTomorrow->value;
    }
    if ($this->isDayBeforeYesterday()) {
        $value = UserFriendlyDateTimeText::dayBeforeYesterday->value;
    }
    if (null === $value) {
        $value = $this->userDateTime->format($dateTimeFormat);
    }

    return $value;
}

```

Не забываем, что у нас еще есть метод ```getCapitalizedDate``` и ему тоже нужно добавить параметр ```$dateTimeFormat```.
Добавление одного параметра привело к следующим проблемам:

<ul>
<li>Формат даты и времени нужно передавать в два метода;</li>
<li>Метод ```getCapitalizedDate``` будет себя странно вести в случае, когда не нашел подходящий вариант (зависит от
   формата даты и время);</li>
<li>При наследовании, нам становится сложнее расширять, так как конечное преобразование к ```dateTimeFormat``` находится
   у родителя;</li>
<li>Если формат даты общий для всего проекта, мы получаем N кол-во вызовов с одними и тем же параметром.</li>
</ul>

##### Отдельный метод

```php
/**
 * @return string|null
 */
public function getFriendlyDateOrDateTimeByFormat(string $dateTimeFormat = 'd.m.Y'): ?string
{
    $value = $this->getDate();
    if ($value) {
        $value = $this->userDateTime->format($dateTimeFormat);
    }
    return $value;
}
```

У решения есть ряд минусов:
<ul>
<li>Потребуется отдельная реализация для методов ```getDate()``` и ```getCapitalizedDate()```, про будущии тоже не забываем;</li>
<li>Методы принимают формат как параметр, этот формат будет дублироваться и хорошо, если он в одном месте хранится, 
а если каждый будет передавать его, то получаем большое кол-во потенциальных ошибок</li>
</ul>

##### Расширение через наследование

````php
<?php

namespace src;

use DateTime;

/**
 * 
 */
class UserFriendlyDateTimeConstructorExtend extends UserFriendlyDateTimeConstructor
{

    protected string $defaultDateTimeFormat = 'd.m.Y';
    
    /**
     * @param DateTime $userDateTime
     */
    public function __construct(DateTime $userDateTime)
    {
        parent::__construct($userDateTime);
    }

    /**
     * @return string|null
     */
    public function getDate(): string
    {
        $value = parent::getDate();
        
        if (null === $value) {
           $value = $this->userDateTime->format($this->defaultDateTimeFormat); 
        }

        return $value;
    }
}
````

Реализация простая, добавили новое свойство и дальше преобразуем на выходе, просто, но накладывает ограничения:

1. Мы наследуем от какого-то класса, а значит нужно встраивать его либо после, либо до, что не удобно;
2. Разные форматы, разные дочерние классы;
3. При последующем наследование, получаем проблему с возможностью расширения, так как будет возвращаться дата в формате.

##### Расширение через декоратор

Данный вариант рассматривать бесполезно, так как мы хотим входящую дату изменить на свою, а доступа к исходной дате у
нас нет.
Исходя из этого декоратор в данном случае не решает нашу проблему.

##### Вывод

Для решения данной задачи, лучше выбирать следующие варианты:
<ul>
<li>Наследование - когда, уверены, что дальше наследования не потребуется и наш функционал всегда будет в одном классе,
но нужны разные форматы;</li>
<li>Отдельный метод - когда, уверены, что класс будет расширяться часто, но базовые методы приведения к формату всегда будут одни.</li>
</ul>

