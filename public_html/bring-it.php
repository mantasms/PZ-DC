<?php
require '../bootloader.php';

define('USER', 'input_users');
define('USER_DRINKS', 'input_kokteiliai');

$form = [
    'fields' => [
        'drink_name' => [
            'label' => 'Drink name',
            'type' => 'text',
            'placeholder' => 'Alkoholis 3000',
            'validate' => [
                'validate_not_empty',
            ]
        ],
        'drink_abarot' => [
            'label' => 'Drink abarot',
            'type' => 'float',
            'placeholder' => '5.0',
            'validate' => [
                'validate_not_empty',
            ]
        ],
        'drink_amount' => [
            'label' => 'Drink amount',
            'type' => 'number',
            'placeholder' => '500',
            'validate' => [
                'validate_not_empty',
                'validate_is_number'
            ]
        ],
        'drink_foto' => [
            'label' => 'Drink foto',
            'placeholder' => 'file',
            'type' => 'file',
            'validate' => [
                'validate_file'
            ]
        ]
    ],
    'validate' => [
        'validate_form_file'
    ],
    'buttons' => [
        'submit' => [
            'text' => 'Paduoti!'
        ]
    ],
    'callbacks' => [
        'success' => [
            'form_success'
        ],
        'fail' => []
    ]
];

function validate_form_file(&$safe_input, &$form) {
    $file_saved_url = save_file($safe_input['drink_foto']);
    if ($file_saved_url) {
        $safe_input['drink_foto'] = 'uploads/' . $file_saved_url;
        return true;
    } else {
        $form['error_msg'] = 'Jobans/a tu buhurs/gazele nes failas supistas!';
    }
}

function form_success($safe_input, $form) {
    $gerimas = new \App\Item\Gerimas([
        'name' => $safe_input['drink_name'],
        'amount_ml' => $safe_input['drink_amount'],
        'abarot' => $safe_input['drink_abarot'],
        'image' => $safe_input['drink_foto']
    ]);

    $db = new Core\FileDB(ROOT_DIR . '/app/files/db.txt');
    $model_gerimai = new App\model\ModelGerimai($db, USER_DRINKS);
    $model_gerimai->insert(microtime(), $gerimas);
}

function save_file($file, $dir = 'uploads', $allowed_types = ['image/png', 'image/jpeg', 'image/gif']) {
    if ($file['error'] == 0 && in_array($file['type'], $allowed_types)) {
        $target_file_name = microtime() . '-' . strtolower($file['name']);
        $target_path = $dir . '/' . $target_file_name;
        if (move_uploaded_file($file['tmp_name'], $target_path)) {
            return $target_file_name;
        }
    }
    return false;
}

if (!empty($_POST)) {
    $safe_input = get_safe_input($form);
    $form_success = validate_form($safe_input, $form);
    if ($form_success) {
        $success_msg = strtr('Gerimas "@drink_name" sėkmingai sukurtas!', [
            '@drink_name' => $safe_input['drink_name']
        ]);

        $db = new Core\FileDB(ROOT_DIR . '/app/files/db.txt');
        $model_user = new App\Model\ModelUser($db, USER);
        $model_gerimas = new App\model\ModelGerimai($db, USER_DRINKS);
        $balius = new \App\Balius($model_user, $model_gerimas);

        if ($balius->getSilpniejiAmount() != 0 || $balius->getStipriejiAmount() != 0) {
            if (($balius->getSilpniejiAmount() / $balius->getStipriejiAmount()) < 2) {
                $error_msg = 'Truksta zagirono, eik nusipirk NX';
            }
        }
    }
}
?>
<html>
    <head>
        <title>PZ/DC</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <nav class="container">
            <a href="join-it.php">JOIN US TO DRINK</a>
            <a href="index.php">PZ/DC</a>
        </nav>
        <?php require '../core/views/form.php'; ?>
        <?php if (isset($success_msg)): ?>
            <h3><?php print $success_msg; ?></h3>
        <?php endif; ?>
        <?php if (isset($error_msg)): ?>
            <h3><?php print $error_msg; ?></h3>
        <?php endif; ?>
    </body>
</html>
