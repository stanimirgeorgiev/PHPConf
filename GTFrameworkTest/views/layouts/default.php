<!DOCTYPE html>
<html lang="en">
    <head>
        <?= $this->helper('LoadCDN', 'loadAll'); ?>
        <title><?= $this->title; ?></title>
    </head>
    <body>
        <div id="wrapper">
            <header>
                <?= $this->helper('Header', 'navBar'); ?>
            </header>
            <main>
                <?= $this->getLayoutData('body1') . PHP_EOL; ?>
                <?= $this->getLayoutData('body2') . PHP_EOL; ?>
            </main>
            <footer>
                <?= $this->helper('Footer', 'license'); ?>
            </footer>
        </div>
    </body>
</html>