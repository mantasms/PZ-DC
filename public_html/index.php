<?php
require '../bootloader.php';

define('USER', 'input_users');
define('USER_DRINKS', 'input_kokteiliai');

$db = new Core\FileDB(ROOT_DIR . '/app/files/db.txt');
$model_user = new App\Model\ModelUser($db, USER);
$model_gerimas = new App\model\ModelGerimai($db, USER_DRINKS);
$balius = new \App\Balius($model_user, $model_gerimas);
?>
<html>
    <head>
        <title>P-OOP party !</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body class="<?php print $balius->partyStatus(); ?>">
        <nav class="container">
            <a href="join-it.php">JOIN US TO DRINK</a>
            <a href="bring-it.php">BRING SOME DRINKS</a>
        </nav>
        <h1>P-OOOPPARTY IS ON!</h1>
        <h2><?php print $balius->partyStatus(); ?></h2>
        <div class="container">
            <div class="flex-container">
                <h3>Baliaus dalyviai:</h3>
                <?php foreach ($model_user->loadAll() as $user): ?>
                    <h4><?php print $user->getUsername(); ?></h4>
                <?php endforeach; ?>
            </div>
            <div class="flex-container">
                <h3>Zagironas</h3>
                <?php foreach ($model_gerimas->loadAll() as $zagironas): ?>
                    <?php if ($zagironas->getAbarot() == 0): ?>
                        <div>
                            <p>Drink name: <?php print $zagironas->getName(); ?></p>
                            <span>Abarot: <?php print $zagironas->getAbarot(); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <h3>Silpnieji</h3>
                <?php foreach ($model_gerimas->loadAll() as $silpnasis): ?>
                    <?php if ($silpnasis->getAbarot() > 0 && $silpnasis->getAbarot() <= 20): ?>
                        <div>
                            <p>Drink name: <?php print $silpnasis->getName(); ?></p>
                            <span>Abarot: <?php print $silpnasis->getAbarot(); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <h3>Stiprieji</h3>
                <?php foreach ($model_gerimas->loadAll() as $stiprusis): ?>
                    <?php if ($stiprusis->getAbarot() > 20): ?>
                        <div>
                            <p>Drink name: <?php print $stiprusis->getName(); ?></p>
                            <span>Abarot: <?php print $stiprusis->getAbarot(); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </body>
</html>
