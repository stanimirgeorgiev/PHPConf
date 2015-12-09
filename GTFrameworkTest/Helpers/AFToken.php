<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Helpers;

/**
 * Description of AFToken
 *
 * @author ACER
 */
class AFToken {

    public function getToken() {
        if (empty($_COOKIE)) {
            throw new \Exception('Problem startin a sessions', 500);
        }
        $aft = md5(uniqid());
        $_SESSION['afToken'] = $aft;
        return $aft;
    }
}
