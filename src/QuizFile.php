<?php
namespace Quizlet;

interface QuizFile
{
    public function isExist(): bool;
    public function isReadable(): bool;
    public function parse(): bool;
    public function getTheme(): string;
    public function count(): int;
    public function getQuestion(int $index): string;
    public function getAnswerList(int $index): array;
    public function checkAnswer(int $question, int $answer): bool;
}