<?php
namespace App\Controllers;

use App\Models\User;
use App\Includes\Auth;

class UserController {
    private $userModel;
    private $auth;

    public function __construct() {
        $this->userModel = new User();
        $this->auth = Auth::getInstance();
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password_hash'])) {
                $this->auth->login($user);
                header('Location: /dashboard');
                exit();
            } else {
                return ['error' => 'Email ou mot de passe incorrect'];
            }
        }
        require_once '../views/login/login.php';
    }

    public function signup() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'password_hash' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'bio' => $_POST['bio'] ?? null
            ];

            // Gestion de l'upload de l'image
            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
                $uploadDir = 'uploads/profiles/';
                $uploadFile = $uploadDir . uniqid() . '_' . basename($_FILES['profile_picture']['name']);

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                    $userData['profile_picture_url'] = $uploadFile;
                }
            }

            if ($this->userModel->create($userData)) {
                header('Location: /login?message=Account created successfully');
                exit();
            } else {
                return ['error' => 'Error creating account'];
            }
        }
        require_once '../views/signup/signup.php';
    }

    public function logout() {
        $this->auth->logout();
        header('Location: /login');
        exit();
    }
}
