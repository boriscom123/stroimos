<?php
namespace AppBundle\Model\ValueObject;

final class PersonName
{
    private $name;
    private $patronymic;
    private $surname;

    protected function __construct($surname, $name, $patronymic = null)
    {
        $this->name = $name;
        $this->patronymic = $patronymic;
        $this->surname = $surname;
    }

    public static function createFromFIO($fullName)
    {
        $pieces = array_filter(explode(' ', $fullName));
        if (count($pieces) < 2) {
            throw new \InvalidArgumentException('FIO cannot contain less then 2 words');
        }

        $surname = array_shift($pieces);
        $name = array_shift($pieces);
        $patronymic = array_shift($pieces);

        return new self($surname, $name, $patronymic);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    public function getFIO()
    {
        return implode(' ', [$this->getSurname(), $this->getName(), $this->getPatronymic()]);
    }
}
