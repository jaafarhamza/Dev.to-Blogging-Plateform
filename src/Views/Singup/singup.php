<?php
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Config\Database;

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$errors = [];
$success = false;
$formData = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $username = trim($_POST['username'] ?? '');
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password_hash'] ?? '';
    $repeatPassword = $_POST['RpeatPassword'] ?? '';

    // Validation
    if (empty($username)) {
        $errors[] = "Le nom d'utilisateur est requis";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide";
    }

    if (strlen($password) < 8) {
        $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
    }

    if ($password !== $repeatPassword) {
        $errors[] = "Les mots de passe ne correspondent pas";
    }

    if (empty($errors)) {
        try {
            $pdo = Database::connection();
            
            $checkEmail = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $checkEmail->execute([$email]);
            
            if ($checkEmail->fetchColumn() > 0) {
                $errors[] = "Cet email est déjà utilisé";
            } else {
                $sql = "INSERT INTO users (username, email, password_hash) VALUES (:username, :email, :password)";
                $stmt = $pdo->prepare($sql);
                
                $result = $stmt->execute([
                    ':username' => $username,
                    ':email' => $email,
                    ':password' => password_hash($password, PASSWORD_DEFAULT)
                ]);

                if ($result) {
                    $success = true;
                    header("Location: ../Login/login.php?success=1");
                    exit;
                } else {
                    $errors[] = "Erreur lors de l'inscription";
                }
            }
        } catch (PDOException $e) {
            $errors[] = "Erreur de base de données : " . $e->getMessage();
        }
    }

    $formData = [
        'username' => $username,
        'email' => $email
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Inscription</title>
</head>
<body class="bg-gray-50">
    <div class="container px-4 mx-auto min-h-screen flex items-center">
        <div class="max-w-lg mx-auto w-full">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Créer un compte</h2>
                <p class="mt-2 text-gray-600">Rejoignez-nous dès aujourd'hui</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label class="block mb-2 font-extrabold text-gray-700" for="username">
                        Nom d'utilisateur
                    </label>
                    <input
                        id="username"
                        name="username"
                        type="text"
                        value="<?= htmlspecialchars($formData['username'] ?? '') ?>"
                        required
                        class="inline-block w-full p-4 leading-6 text-lg font-extrabold placeholder-gray-400 bg-white shadow border-2 border-indigo-900 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Votre nom d'utilisateur"
                    >
                </div>

                <div>
                    <label class="block mb-2 font-extrabold text-gray-700" for="email">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?= htmlspecialchars($formData['email'] ?? '') ?>"
                        required
                        class="inline-block w-full p-4 leading-6 text-lg font-extrabold placeholder-gray-400 bg-white shadow border-2 border-indigo-900 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="votre@email.com"
                    >
                </div>

                <div>
                    <label class="block mb-2 font-extrabold text-gray-700" for="password">
                        Mot de passe
                    </label>
                    <input
                        id="password"
                        name="password_hash"
                        type="password"
                        required
                        class="inline-block w-full p-4 leading-6 text-lg font-extrabold placeholder-gray-400 bg-white shadow border-2 border-indigo-900 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Minimum 8 caractères"
                    >
                </div>

                <div>
                    <label class="block mb-2 font-extrabold text-gray-700" for="repeat-password">
                        Confirmer le mot de passe
                    </label>
                    <input
                        id="repeat-password"
                        name="RpeatPassword"
                        type="password"
                        required
                        class="inline-block w-full p-4 leading-6 text-lg font-extrabold placeholder-gray-400 bg-white shadow border-2 border-indigo-900 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Confirmer votre mot de passe"
                    >
                </div>

                <button
                    type="submit"
                    class="inline-block w-full py-4 px-6 text-center text-lg leading-6 text-white font-extrabold bg-indigo-800 hover:bg-indigo-900 border-3 border-indigo-900 shadow rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Créer mon compte
                </button>

                <p class="text-center font-extrabold text-gray-600">
                    Déjà inscrit ?
                    <a class="text-indigo-600 hover:text-indigo-800 hover:underline"
                       href="../Login/login.php">
                        Se connecter
                    </a>
                </p>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const errorDiv = document.querySelector('.bg-red-100');
            if (errorDiv) {
                setTimeout(() => {
                    errorDiv.style.opacity = '0';
                    errorDiv.style.transition = 'opacity 0.5s';
                    setTimeout(() => errorDiv.remove(), 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
