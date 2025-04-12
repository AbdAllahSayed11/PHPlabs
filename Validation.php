<?php
class Validation {
    public function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function validatePassword($password, $confirm_password) {
        if (strlen($password) < 8) {
            return "Password must be at least 8 characters long.";
        } elseif ($password !== $confirm_password) {
            return "Passwords do not match.";
        }
        return null;
    }

    public function validateProfilePicture($file) {
        if (!isset($file) || $file['error']) {
            return "Please upload a valid profile picture.";
        }
        return null;
    }
}
?>
