<?php
namespace Quizlet;

use Commando\Command;
use League\CLImate\CLImate;

class Quiz
{
    private $command;
    private $file;
    private $cli;

    public function __construct(Command $cmd, QuizFile $file, CLImate $cli)
    {
        $this->command = $cmd;
        $this->file = $file;
        $this->cli = $cli;
        $this->cli->output->defaultTo('out');
    }

    public function start()
    {
        if ($this->file->isExist() === false) {
            return $this->showError('Файл с данными опроса не найден');
        }

        if ($this->file->isReadable() === false) {
            return $this->showError('Недостаточно прав для чтения файла с данными опроса');
        }

        if ($this->file->parse() === false) {
            return $this->showError('Файл опроса имеет неверный формат');
        }

        $this->cli->out('Тема: "' . $this->file->getTheme() . '"');
        $this->cli->out(PHP_EOL);

        for ($i = 0; $i <= $this->file->count() - 1; $i++) {
            $this->cli->green()->out($this->file->getQuestion($i));

            foreach ($this->file->getAnswerList($i) as $num => $answer) {
                $this->cli->yellow()->out('   ' . $num . '. ' . $answer);
            }

            $input = $this->cli->input('Ответ: ');
            $input->accept(array_keys($this->file->getAnswerList($i)));

            $userAnswer = $input->prompt();

            if ($this->file->checkAnswer($i, $userAnswer)) {
                $this->cli->lightGreen()->out('Правильный ответ!');
            } else {
                $this->cli->lightRed()->out('Вы ошиблись!');
            }

            $this->cli->out(PHP_EOL);
        }

        $this->cli->lightYellow()->out('Опрос завершен.');

        return 0;
    }

    private function showError($message)
    {
        $this->cli->to('error')->red()->out($message);
        return 1;
    }
}