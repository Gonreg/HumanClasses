<?php
/**
 * Автор: Иван Кафтанчиков
 *
 * Дата создания: 06.08.2022
 *
 * Дата изменения: 08.08.2022
 *
 * Класс для работы со списками людей
 */

/**
 * Class Humans
 *
 * Класс для работы со списками людей, использует экземпляры класса Human
 */

class Humans
{
    /**
     * @var array
     */
    public array $ids = [];

    /**
     * @var Human
     */
    public Human $human;

    public function __construct()
    {
        if (!class_exists('Human'))
        {
            echo 'Класс хуман не создан';
            exit;
        }
        $this->human = new Human();
        $this->ids = $this->human->getHumanInfo(null, ['id']);

    }

    /**
     * @return array
     */
    public function getHumans(): array
    {
        $humans = [];

        foreach ($this->ids as $id)
        {
            $v = clone $this->human;
            $v->id = $id;
            $humans[] = $v;
        }
        return $humans;
    }


    public function deleteAll()
    {
        $humans = $this->getHumans();

        foreach ($humans as $human)
        {
            $human->deleteHumanFromDb($human->id);
        }
    }

}