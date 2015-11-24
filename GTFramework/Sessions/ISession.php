<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author ACER
 */

namespace GTFramework\Sessions;

interface ISession {

    public function getSessionId();

    public function saveSession();

    public function destroySession();

    public function __get($name);

    public function __set($name, $value);
}
