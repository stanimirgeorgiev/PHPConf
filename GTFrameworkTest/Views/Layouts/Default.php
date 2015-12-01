<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->helper('\Helpers\LoadCDN', 'loadAll'); ?>
        <title><?= $this->title; ?></title>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <?php   $navBar = new \Views\Layouts\Header();
                        $navBar->addNavBar();
                ?>
            </header>
            <main>
                <?php $register = new Views\PartialViews\Register() ;
                        $register->addRegisterForm();
                ?>
                <?= $this->getLayoutData('body2') . PHP_EOL; ?>
            </main>
            <footer>
                <?php   $license = new \Views\Layouts\Footer();
                        $license->license();
                ?>
            </footer>
        </div>
    </body>
</html>