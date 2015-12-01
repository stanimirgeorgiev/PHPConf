<?php

namespace Views\Layouts;

class Header {

    public function addNavBar() {
        echo '<ul class = "btn-group" role = "group" aria-label = "...">'.PHP_EOL.
            '  <li class = "btn btn-default"><a href="" >Home</a></li>'.PHP_EOL.
            '  <li class = "btn btn-default"><a href="">About</a></li>'.PHP_EOL.
            '  <li class = "btn btn-default"><a href="">About</a></li>'.PHP_EOL.
            '  <li class = "btn btn-default"><a href="">FAQ\'S</a></li>'.PHP_EOL.
            '  <li class="btn btn-default"><a href="">Login</a></li>'.PHP_EOL;
            '</ul>'.PHP_EOL;
    }

}
