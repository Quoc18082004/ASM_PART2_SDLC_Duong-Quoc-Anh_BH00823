<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/ASM/Admin/AdminConner.php');

// Check if 'id' is passed via URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // SQL query to delete the user
    $sql = "DELETE FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            // Deletion successful
            header("Location: http://localhost/ASM/Admin/Admin_User.php.php?message=success");
        } else {
            // Error during execution
            header("Location: ../Admin_User.php?message=error");
        }
        $stmt->close();
    } else {
        // Error preparing SQL statement
        header("Location: ../Admin_User.php?message=error");
    }
} else {
    // If no valid ID is provided
    header("Location: ../Admin_User.php?message=invalid");
}
$conn->close();
?>
