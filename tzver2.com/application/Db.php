<?php

/**
 * Автор: Иван Кафтанчиков
 *
 * Дата создания: 06.08.2022
 *
 * Дата изменения: 08.08.2022
 *
 * Класс для работы с базами данных
 */

require_once 'Dev.php';

/**
 * Class Db
 *
 * Нужен для работы с бд, существуют методы добавления новых строк, удаления, и чтение строк из бд
 */
class Db
{
    private PDO $connection;

    public function __construct()
    {
        $config = require_once 'config.php';
        $this->connection = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['name'] . '', $config['user'], $config['password']);

        return ($this->connection);
    }

    public function __destruct()
    {

    }

    /**
     * @param int $mode
     * @param int|null $id
     * @param array $columns
     *
     * @return array
     */
    public function getRecordFromUserTable(int $mode = 2, int $id = null, array $columns = ['*']): array
    {
        if ($id) {

            return ($this
                ->query("SELECT * FROM users WHERE id = '$id'")
                ->fetch(PDO::FETCH_ASSOC));
        }

        $columns = implode(',', $columns);

        return ($this
            ->query("SELECT $columns FROM users")
            ->fetchAll($mode));
    }

    /**
     * @param array $params
     *
     * @return bool|PDOStatement
     */
    public function addRecordToUserTable(array $params = []): bool|PDOStatement
    {
        $firstName = $params[Helper::FIRST_NAME];
        $lastName = $params[Helper::LAST_NAME];
        $bornDate = $params[Helper::BORN_DATE];
        $gender = $params[Helper::GENDER];
        $city = $params[Helper::CITY];

        $query = "INSERT INTO `users` (`first_name`,`last_name`,`born_date`,`gender`,`city`) 
                      VALUE ('$firstName','$lastName','$bornDate','$gender','$city')";

        return ($this->query($query));
    }

    /**
     * @param $id
     *
     * @return bool|PDOStatement
     */
    public function deleteRecord($id): bool|PDOStatement
    {
        $query = "DELETE FROM users WHERE id = '$id'";

        return ($this->query($query));
    }

    /**
     * @param string $sql
     *
     * @return bool|PDOStatement
     */
    private function query(string $sql): bool|PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();

        return ($stmt);
    }

}



