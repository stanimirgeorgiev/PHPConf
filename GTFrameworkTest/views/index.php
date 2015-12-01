<div class="input-group input-group-lg">
                <a  href="http://localhost/Kofa">SELF TAGING</a>
                <form method="POST" target="">
                    <input class="btn btn-default" type="text" name="Username" />
                    <input class="btn btn-default" type="text" name="Password" />
                    <input type="hidden" name="token" value=<?= $this->token[0] ?>/>
                    <input class="btn btn-default" type="submit" name="Submitni be" value="Login"/>
                </form>
            </div>