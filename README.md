# Quizlet

CLI-утилита для проведения опросов

[![Code Climate](https://codeclimate.com/github/sabian/quizlet/badges/gpa.svg)](https://codeclimate.com/github/sabian/quizlet)
[![Issue Count](https://codeclimate.com/github/sabian/quizlet/badges/issue_count.svg)](https://codeclimate.com/github/sabian/quizlet)
[![Test Coverage](https://codeclimate.com/github/sabian/quizlet/badges/coverage.svg)](https://codeclimate.com/github/sabian/quizlet/coverage)

## Задание
Необходимо реализовать cli утилиту для проведения квизов.

Принцип работы такой:

Загружаем квиз из файла

quizlet path/to/quizfile

Программа спрашивает ФИО и email.

Появляются вопросы с вариантами ответа на которые надо отвечать.
После того как квиз пройден, quizlet записывает результаты в текущую папку с именем равным емейлу.
Формат описания квизов и выходной формат нужно придумать самостоятельно на основе yaml.

## Установка
```
make install
```