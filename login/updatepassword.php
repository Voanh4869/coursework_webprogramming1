<?php
include_once '../includes/DatabaseConnection.php'; 

$users = [
    'admin@gmail.com' => 'pass123',
    'jane@gmail.com' => 'jane456',
    'jake@gmail.com' => 'jake789',
    'votuananh0925@gmail.com' => 'anhvo1234',
    'voanh1010@gmail.com' => 'anhvo1010',
    'matthias@example.com' => 'matty1234',
    'luke@example.com' => 'luke1234',
];

foreach ($users as $email => $plain_password) {
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET password_hash = :password WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'password' => $hashed_password,
        'email' => $email
    ]);

    echo "✅ Updated password for: $email <br>";
}
