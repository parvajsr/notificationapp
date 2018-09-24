<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Utils;

class Validator
{
    public function validateUsername($username)
    {
        if (empty($username)) {
            throw new \Exception('The username can not be empty.');
        }

        if (1 !== preg_match('/^[a-z_]+$/', $username)) {
            throw new \Exception('The username must contain only lowercase latin characters and underscores.');
        }

        return $username;
    }

    public function validatePassword($plainPassword)
    {
        if (empty($plainPassword)) {
            throw new \Exception('The password can not be empty.');
        }

        if (mb_strlen(trim($plainPassword)) < 6) {
            throw new \Exception('The password must be at least 6 characters long.');
        }

        return $plainPassword;
    }

    public function validateEmail($email)
    {
        if (empty($email)) {
            throw new \Exception('The email can not be empty.');
        }

        if (false === mb_strpos($email, '@')) {
            throw new \Exception('The email should look like a real email.');
        }

        return $email;
    }

    public function validateFullName($fullName)
    {
        if (empty($fullName)) {
            throw new \Exception('The full name can not be empty.');
        }

        return $fullName;
    }

    /**
     * @return string
     */
    public static function generateCode()
    {
        $length = 11;
        $chrDb = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

        $str = '';
        for ($count = 0; $count < $length; ++$count) {
            $chr = $chrDb[random_int(0, count($chrDb) - 1)];

            if (random_int(0, 1) == 0) {
                $chr = strtolower($chr);
            }
            $str .= $chr;
        }

        return $str;
    }
}
