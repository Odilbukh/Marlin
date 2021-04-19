<?php
class Session {
    /**
     * Метод для создания сессии
     *
     * @param string $name
     * @param string $value
     * @return void
     */
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    /**
     * Метод для проверки существует ли сессия
     *
     * @param string $name
     * @return void
     */
    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Метод для удаления сессии
     *
     * @param string $name
     * @return void
     */
    public static function delete($name) {
        if(self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    /**
     * Метод для получения сессии
     *
     * @param string $name
     * @return void
     */
    public static function get($name) {
        return $_SESSION[$name];
    }

    /**
     * Flash Метод для получения и удаления сессии
     *
     * @param string $name
     * @param string $string
     * @return void
     */
    public static function flash($name, $string = '') {
        if(self::exists($name) && self::get($name) !== '') {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}