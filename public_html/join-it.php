<?php
require '../bootloader.php';

define('USER', 'input_users');
define('USER_DRINKS', 'input_kokteiliai');

$form = [
    'fields' => [
        'username' => [
            'label' => 'Username',
            'type' => 'text',
            'placeholder' => 'Zirgas69',
            'validate' => [
                'validate_not_empty',
            ]
        ],
        'email' => [
            'label' => 'Email',
            'type' => 'text',
            'placeholder' => 'email@gmail.com',
            'validate' => [
                'validate_not_empty',
            ]
        ],
        'full_name' => [
            'label' => 'Full Name',
            'type' => 'text',
            'placeholder' => 'Ernestas Zidokas',
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'age' => [
            'label' => 'Age',
            'placeholder' => '26',
            'type' => 'number',
            'min' => 0,
            'max' => 999,
            'validate' => [
                'validate_not_empty',
                'validate_is_number'
            ]
        ],
        'gender' => [
            'label' => 'Gender',
            'type' => 'select',
            'placeholder' => '',
            'options' => App\User::getGenderOptions(),
            'validate' => [
                'validate_not_empty'
            ]
        ],
        'orientation' => [
            'label' => 'Orientation',
            'type' => 'select',
            'placeholder' => '',
            'options' => App\User::getOrientationOptions(),
            'validate' => [
                'validate_not_empty'
            ],
        ],
        'photo' => [
            'label' => 'Photo',
            'placeholder' => 'file',
            'type' => 'file',
            'validate' => [
                'validate_file'
            ]
        ],
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

function form_success($safe_input, $form) {
    $user = new \App\User([
        'username' => $safe_input['username'],
        'email' => $safe_input['email'],
        'full_name' => $safe_input['full_name'],
        'age' => $safe_input['age'],
        'gender' => $safe_input['gender'],
        'orientation' => $safe_input['orientation'],
        'photo' => $safe_input['photo']
    ]);

    $db = new Core\FileDB(ROOT_DIR . '/app/files/db.txt');
    $model_user = new App\model\ModelUser($db, USER);
    $model_user->insert(microtime(), $user);
}

function validate_form_file(&$safe_input, &$form) {
    $file_saved_url = save_file($safe_input['photo']);

    if ($file_saved_url) {
        $safe_input['photo'] = 'uploads/' . $file_saved_url;

        return true;
    } else {
        $form['error_msg'] = 'Jobans/a tu buhurs/gazele nes failas supistas!';
    }
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
        $success_msg = strtr('User "@username" sėkmingai sukurtas!', [
            '@username' => $safe_input['username']
        ]);
    }
}

$db = new Core\FileDB(ROOT_DIR . '/app/files/db.txt');
$model_user = new App\Model\ModelUser($db, USER);
$model_gerimas = new App\model\ModelGerimai($db, USER_DRINKS);
$balius = new \App\Balius($model_user, $model_gerimas);

$fail_msg = 'Party is already pooped. Bring some drinks first, you cheap-ass!';
?>
<html>
    <head>
        <title>PZ/DC</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <nav class="container">
            <a href="index.php">PZ/DC</a>
            <a href="bring-it.php">BRING SOME DRINKS</a>
        </nav>
        <?php if ($balius->partyStatus() != 'POOP'): ?>
            <?php require '../core/views/form.php'; ?>
        <?php else: ?>
            <?php print $fail_msg; ?>
        <?php endif; ?>
        <?php if (isset($success_msg)): ?>
            <h3><?php print $success_msg; ?></h3>
        <?php endif; ?>
    </body>
</html>
