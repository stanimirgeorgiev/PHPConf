<?php

namespace Views\Layouts;

class Header {

    public function addNavBar() {
        echo    '<ul class = "btn-group" role = "group" aria-label = "...">
                    <li class = "btn btn-default"><a href="'. \GTFramework\View::getInstance()->helper('\Helpers\Link', 'getPages').'" >Home</a></li>
                    <li class = "btn btn-default"><a href="">About</a></li>
                    <li class = "btn btn-default"><a href="">FAQ\'S</a></li>
                    <li class="btn btn-default"><a href="">Login</a></li>
                </ul>'.PHP_EOL;
    }

}
