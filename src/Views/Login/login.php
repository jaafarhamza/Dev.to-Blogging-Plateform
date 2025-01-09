<?php
// login.php
session_start();
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Config\Database;

$error = '';
$email = '';

try {
    $pdo = Database::connection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $error = "Tous les champs sont requis.";
        } else {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password_hash'])) {

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['last_login'] = time();

                if ($user['role'] === 'admin') {
                    header("Location: /admin/dashboard");
                } else {
                    header("Location: /dashboard");
                }
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        }
    }
} catch (PDOException $e) {
    $error = "Une erreur est survenue. Veuillez réessayer plus tard.";
    error_log($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Connexion</title>
</head>
<body class="bg-gray-50">
    <div class="container px-4 mx-auto min-h-screen flex items-center">
        <div class="max-w-lg mx-auto w-full">
            <div class="text-center mb-8">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900">Connexion</h2>
                <p class="mt-2 text-gray-600">Bienvenue, veuillez vous connecter</p>
            </div>

            <?php if ($error): ?>
                <div class="mb-4 p-4 rounded bg-red-100 border border-red-400 text-red-700">
                    <?=htmlspecialchars($error)?>
                </div>
            <?php endif;?>

            <form method="POST" action="" class="space-y-6">
                <div>
                    <label class="block mb-2 font-extrabold text-gray-700" for="email">
                        Email
                    </label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="<?=htmlspecialchars($email)?>"
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
                        name="password"
                        type="password"
                        required
                        class="inline-block w-full p-4 leading-6 text-lg font-extrabold placeholder-gray-400 bg-white shadow border-2 border-indigo-900 rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="••••••••"
                    >
                </div>

                <div class=" hidden flex flex-wrap -mx-4 mb-6 items-center justify-between">
                    <div class="w-full lg:w-auto px-4 mb-4 lg:mb-0">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="form-checkbox text-indigo-600">
                            <span class="ml-2 font-extrabold text-gray-700">Se souvenir de moi</span>
                        </label>
                    </div>
                    <div class="w-full lg:w-auto px-4">
                        <a class="inline-block font-extrabold text-indigo-600 hover:text-indigo-800 hover:underline"
                           href="/forgot-password">
                            Mot de passe oublié ?
                        </a>
                    </div>
                </div>

                <button
                    type="submit"
                    class="inline-block w-full py-4 px-6 mb-6 text-center text-lg leading-6 text-white font-extrabold bg-indigo-800 hover:bg-indigo-900 border-3 border-indigo-900 shadow rounded transition duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Se connecter
                </button>

                <p class="text-center font-extrabold text-gray-600">
                    Pas encore de compte ?
                    <a class="text-indigo-600 hover:text-indigo-800 hover:underline"
                       href="../Singup/singup.php">
                        S'inscrire
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
