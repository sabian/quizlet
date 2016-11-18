<?php
namespace Quizlet;

use Symfony\Component\Yaml\Yaml;

class QuizYml implements QuizFile
{
    /** @var string */
    private $path;

    /** @var Yaml */
    private $yml;

    /** @var null|array */
    private $data = null;

    const THEME = 'theme';
    const QUESTIONS = 'questions';
    const QUESTION = 'question';
    const ANSWERS = 'answers';
    const EXPECTED = 'expected';

    /**
     * QuizYml constructor.
     *
     * @param Yaml $yml
     * @param string $path Path to quiz file
     */
    public function __construct(Yaml $yml, string $path)
    {
        $this->yml = $yml;
        $this->path = $path;
    }

    /**
     * Is quiz file exists?
     *
     * @return bool
     */
    public function isExist(): bool
    {
        return file_exists($this->path);
    }

    /**
     * Is quiz file readable?
     *
     * @return bool
     */
    public function isReadable(): bool
    {
        return is_readable($this->path);
    }

    /**
     * Parse quiz file
     *
     * @param bool $validate Validate parsed data. Default: true
     * @return bool
     */
    public function parse(bool $validate = true): bool
    {
        try {
            $this->data = $this->yml->parse(file_get_contents($this->path));
        } catch (\Exception $e) {
            return false;
        }

        return $validate ? $this->isValid() : true;
    }

    /**
     * Is quiz file valid?
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (is_null($this->data) || !isset($this->data[self::THEME], $this->data[self::QUESTIONS])) {
            return false;
        }

        foreach ($this->getQuestionList() as $question) {
            if (!isset($question[self::QUESTION], $question[self::ANSWERS], $question[self::EXPECTED]) || !is_array($question[self::ANSWERS])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns quiz theme
     *
     * @return string
     */
    public function getTheme(): string
    {
        return $this->data[self::THEME];
    }

    /**
     * Returns questions list
     *
     * @return array
     */
    public function getQuestionList(): array
    {
        return $this->data[self::QUESTIONS];
    }

    /**
     * Returns quiz questions amount
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->getQuestionList());
    }

    /**
     * Get question by index
     *
     * @param int $index
     * @return string
     */
    public function getQuestion(int $index): string
    {
        $data = $this->getQuestionList();

        return $data[$index][self::QUESTION];
    }

    /**
     * Return possible answers list for particular quiz
     *
     * @param int $index
     * @return array
     */
    public function getAnswerList(int $index): array
    {
        $data = $this->getQuestionList();

        return $data[$index][self::ANSWERS];
    }

    /**
     * Compare user answer with expected value
     *
     * @param int $question Quiz question index
     * @param int $answer User answer
     * @return bool
     */
    public function checkAnswer(int $question, int $answer): bool
    {
        $data = $this->getQuestionList();

        return $data[$question][self::EXPECTED] === $answer;
    }
}