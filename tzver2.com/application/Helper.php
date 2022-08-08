<?php

/**
 * Автор: Иван Кафтанчиков
 *
 * Дата создания: 06.08.2022
 *
 * Дата изменения: 08.08.2022
 *
 * Класс для валидации данных
 */

/**
 * Class Helper
 *
 * Класс обрабатывает массив с параметрами человека, и в зависимости от входных данных вернет либо true либо false
 */
class Helper
{
    public const FIRST_NAME = 'first_name';

    public const LAST_NAME = 'last_name';

    public const BORN_DATE = 'born_date';

    public const GENDER = 'gender';

    public const CITY = 'city';

    private const VALID_USER = [self::FIRST_NAME, self::LAST_NAME, self::BORN_DATE, self::GENDER, self::CITY];

    /**
     * @param array $params
     *
     * @return bool
     */
    public function validateData(array $params): bool
    {
        if (array_diff(self::VALID_USER, array_keys($params))) {
            return false;
        }

        foreach ($params as $key => $param) {
            switch ($key) {
                case self::FIRST_NAME:
                    if (!$this->checkFirstName($param)) {
                        return false;
                    }

                    break;
                case self::LAST_NAME:
                    if (!$this->checkLastName($param)){
                        return false;
                    }

                    break;
                case self::BORN_DATE:
                    if (!$this->checkBornDate()){
                        return false;
                    }

                    break;
                case self::GENDER:
                    if (!$this->checkGender($param)){
                        return false;
                    }

                    break;
                case self::CITY:
                    if (!$this->checkCity()){
                        return false;
                    }

                    break;
                default:
                    return false;
            }
        }

        return true;
    }

    /**
     * @param string $param
     *
     * @return bool
     */
    private function checkFirstName(string $param): bool
    {
        return $this->checkIfOnlyLetters($param);
    }

    /**
     * @param string $param
     *
     * @return bool
     */
    private function checkLastName(string $param): bool
    {
        return $this->checkIfOnlyLetters($param);
    }

    /**
     * @return bool
     */
    private function checkBornDate(): bool
    {
        return true;
    }

    /**
     * @param $param
     *
     * @return bool
     */
    private function checkGender($param): bool
    {
        if ($param === 1 || $param === 0){
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    private function checkCity(): bool
    {
        return true;
    }

    /**
     * @param string $param
     *
     * @return bool
     */
    private function checkIfOnlyLetters(string $param): bool
    {
        return !ctype_punct($param) && !ctype_digit($param);
    }


}