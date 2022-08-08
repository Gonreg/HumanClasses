<?php

/**
 * Автор: Иван Кафтанчиков
 *
 * Дата создания: 06.08.2022
 *
 * Дата изменения: 08.08.2022
 *
 * Класс для работы с базой данных людей
 */

/**
 * Class Human
 *
 * Класс для работы с базой данных людей, конструктор создает экземпляр класса базы данных, и он используется для
 * остальных методов
 */

class Human
{
    /**
     * @var int
     */
    public int $id;

    /**
     * @var string
     */
    public string $lastName = '';

    /**
     * @var string
     */
    public string $firstName = '' ;

    /**
     * @var string
     */
    public string $bornDate = '';

    /**
     * @var ?int
     */
    public ?int $gender = null;

    /**
     * @var string
     */
    public string $city = '';

    /**
     * @var Db
     */
    protected Db $db;

    /**
     * @var Helper
     */
    protected Helper $helper;

    public function __construct($params = [])
    {
        $this->db = new Db();
        $this->helper = new Helper();

        if (!empty($params)) {
            if ($id = $params['id']) {
                $this->getHumanInfo($id);
            } else {
                $this->addHumanToDb($params);
            }
        }
    }

    /**
     * @param int $mode
     * @param null $id
     * @param string[] $columns
     *
     * mode 2 - Получение всех строк бд
     * mode 7 - Получение одного столбца
     *
     * @return array
     */
    public function getHumanInfo(int $mode = 2, $id = null, array $columns = ['*']): array
    {
        return ($this->db->getRecordFromUserTable($mode, $id, $columns));
    }

    /**
     * @param array $params
     *
     * @return bool|PDOStatement
     */
    public function addHumanToDb(array $params): bool|PDOStatement
    {
        if(!$this->helper->validateData($params)){
            return false;
        }

        return ($this->db->addRecordToUserTable($params));
    }

    /**
     * @param $id
     *
     * @return bool|PDOStatement
     */
    public function deleteHumanFromDb($id): bool|PDOStatement
    {
        return ($this->db->deleteRecord($id));
    }

    /**
     * @param string $bornDate
     *
     * @return string
     *
     * @throws Exception
     */
    public static function howOld(string $bornDate): string
    {

        $interval = (new DateTime())->diff(new DateTime($bornDate));

        return ($interval->format('%y'));
    }

    /**
     * @param int $genderOfUser
     *
     * @return string
     */
    public static function gender(int $genderOfUser): string
    {
        return ($genderOfUser === 0 ? 'муж': 'жен');
    }


    /**
     * @param int|null $gender
     * @param string $bornDate
     *
     * @return stdClass
     *
     * @throws Exception
     */
    public function format(int $gender = null, string $bornDate = ''): stdClass
    {
        $human = new stdClass();
        $human->firstName = $this->firstName;
        $human->lastName = $this->lastName;
        $human->bornDate = $this->bornDate;
        $human->gender = $this->gender;
        $human->city = $this->city;

        if (isset($gender)){
            $human->gender = self::gender($gender);

            return $human;
        }
        if (!empty($bornDate)){
            $human->bornDate = self::howOld($bornDate);

            return $human;
        }

        return $human;
    }
}