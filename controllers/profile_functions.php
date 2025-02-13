<?php
include 'connection/db.php';

function getProfile($user_id) {
    global $connection;

    $sql = "SELECT name, birthdate, phone, profile_photo FROM profiles WHERE user_id = ?";
    $search = $connection->prepare($sql);
    $search->bind_param('i', $user_id);
    $search->execute();
    $search->bind_result($name, $birthdate, $phone, $profile_photo);
    $search->fetch();

    return [
        'name' => $name,
        'birthdate' => $birthdate,
        'phone' => $phone,
        'profile_photo' => $profile_photo
    ];
}

function updateProfile($user_id, $name, $birthdate, $phone, $profile_photo = null) {
    global $connection;

    if ($profile_photo) {
        $sql = "UPDATE profiles SET name = ?, birthdate = ?, phone = ?, profile_photo = ? WHERE user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('ssssi', $name, $birthdate, $phone, $profile_photo, $user_id);
    } else {
        $sql = "UPDATE profiles SET name = ?, birthdate = ?, phone = ? WHERE user_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('sssi', $name, $birthdate, $phone, $user_id);
    }

    return $stmt->execute();
}
?>