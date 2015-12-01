<?php

namespace Views\PartialViews;

class Register {

    public function addRegisterForm() {

        echo '<form method="POST" target="">
<div class="form-group">
<label for="username">Your username</label>
<input class="form-control" type="text" name="username" placeholder="Username"/>
</div>
<div class="form-group">
<label for="inputEmail">Email address</label>
<input type="email" class="form-control" id="inputEmail" placeholder="Email">
</div>
<div class="form-group">
<label for="password">Input a password</label>
<input class="form-control" type="password" name="password" placeholder="Password"/>
</div>
<div class="form-group">
<label for="passwordRe">Input a password</label>
<input class="form-control" type="password" name="passwordRe" placeholder="Retype the password"/>
</div>
<input type="hidden" name="AFToken" value="'.\GTFramework\View::getInstance()->helper('\Helpers\AFToken', 'getToken').'"/>
<button type="submit" class="btn btn-default">Register</button>
</form>';
    }

}
