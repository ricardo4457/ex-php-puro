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

function updateProfile($user_id, $name = null, $birthdate = null, $phone = null, $profile_photo = null) {
    global $connection;

    // Define the fields and their corresponding values
    $fields = [
        'name' => $name,
        'birthdate' => $birthdate,
        'phone' => $phone,
        'profile_photo' => $profile_photo,
    ];

    // Initialize arrays to store the fields and values to update
    $updates = [];
    $values = [];
    $types = '';

    // Loop through the fields and build the update query dynamically
    foreach ($fields as $field => $value) {
        if ($value !== null) {
            $updates[] = "$field = ?"; // Add the field to the update list
            $values[] = $value; // Add the value to the values array
            $types .= 's'; // Add the type for bind_param (all fields are strings)
        }
    }

    // If no fields are provided to update, return false
    if (empty($updates)) {
        return false;
    }

    // Build the SQL query dynamically
    $sql = "UPDATE profiles SET " . implode(', ', $updates) . " WHERE user_id = ?";
    $values[] = $user_id; // Add user_id to the values array
    $types .= 'i'; // Add the type for bind_param (user_id is an integer)

    // Prepare and execute the query
    $search = $connection->prepare($sql);
    $search->bind_param($types, ...$values); // Bind parameters dynamically
    return $search->execute();
}
?>