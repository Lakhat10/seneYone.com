<?php
session_start();

// Rediriger vers la page d'accueil si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validation simple
    if (!empty($email) && !empty($password)) {
        // Vérifier les informations d'identification
        $users_file = 'data/users.json';
        
        if (file_exists($users_file)) {
            $users = json_decode(file_get_contents($users_file), true);
        } else {
            // Créer un utilisateur par défaut
            $users = [
                [
                    'id' => 1,
                    'name' => 'Utilisateur Test',
                    'email' => 'test@senyone.sn',
                    'password' => password_hash('password123', PASSWORD_DEFAULT),
                    'created_at' => date('Y-m-d H:i:s')
                ]
            ];
            file_put_contents($users_file, json_encode($users, JSON_PRETTY_PRINT));
        }
        
        // Rechercher l'utilisateur
        $user = null;
        foreach ($users as $u) {
            if ($u['email'] === $email && password_verify($password, $u['password'])) {
                $user = $u;
                break;
            }
        }
        
        if ($user) {
            // Créer la session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            // Rediriger vers la page d'accueil
            header('Location: index.php');
            exit();
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Sen'Yone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Variables CSS pour thèmes */
        :root {
            --primary-color: #27AE60;
            --primary-light: #58D68D;
            --primary-dark: #1E8449;
            --secondary-color: #F39C12;
            --secondary-light: #F7DC6F;
            --secondary-dark: #B9770E;
            --accent-color: #E74C3C;
            --accent-light: #EC7063;
            --accent-dark: #A93226;
            --success-color: #27AE60;
            --warning-color: #F39C12;
            --danger-color: #E74C3C;
            --info-color: #3498DB;
            --dark-color: #2C3E50;
            --light-color: #ECF0F1;
            --text-color: #2C3E50;
            --text-muted: #7F8C8D;
            --border-color: #BDC3C7;
            --bg-color: #F8F9FA;
            --card-bg: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            --gradient-secondary: linear-gradient(135deg, var(--secondary-color), var(--secondary-light));
            --gradient-accent: linear-gradient(135deg, var(--accent-color), var(--accent-light));
            --gradient-special: linear-gradient(135deg, #9B59B6, #3498DB);
            --gradient-rainbow: linear-gradient(135deg, #FF6B6B, #4ECDC4, #45B7D1, #96CEB4, #FFEAA7);
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --radius: 16px;
            --radius-lg: 20px;
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        [data-theme="dark"] {
            --text-color: #ECF0F1;
            --text-muted: #B0BEC5;
            --bg-color: #121212;
            --card-bg: #1E1E1E;
            --border-color: #333333;
            --light-color: #2d2d2d;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.4);
        }

        [data-theme="vibrant"] {
            --primary-color: #FF6B6B;
            --primary-light: #FF8E8E;
            --primary-dark: #E74C3C;
            --secondary-color: #4ECDC4;
            --secondary-light: #6EF0E7;
            --secondary-dark: #2C9C94;
            --accent-color: #FFE66D;
            --accent-light: #FFF9B2;
            --accent-dark: #F7DC6F;
            --success-color: #1DD1A1;
            --warning-color: #F9CA24;
            --danger-color: #FF6B6B;
            --info-color: #54A0FF;
            --dark-color: #2D3436;
            --light-color: #F7F7F7;
            --text-color: #2D3436;
            --text-muted: #636E72;
            --border-color: #DFE6E9;
            --bg-color: #FFFFFF;
            --card-bg: #FFFFFF;
            --gradient-primary: linear-gradient(135deg, #FF6B6B, #FF8E8E);
            --gradient-secondary: linear-gradient(135deg, #4ECDC4, #6EF0E7);
            --gradient-accent: linear-gradient(135deg, #FFE66D, #FFF9B2);
            --gradient-special: linear-gradient(135deg, #9B59B6, #3498DB);
            --gradient-rainbow: linear-gradient(135deg, #FF6B6B, #4ECDC4, #45B7D1, #96CEB4, #FFEAA7);
        }

        /* Reset et base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        html {
            height: 100%;
            overflow: hidden;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--gradient-rainbow);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            color: var(--text-color);
            transition: var(--transition);
        }

        /* Container mobile */
        .mobile-app {
            width: 100%;
            max-width: 400px;
            background: var(--card-bg);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: fadeIn 0.5s ease;
        }

        /* En-tête premium */
        .header {
            background: var(--gradient-rainbow);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .header:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M0,0 L100,0 L100,100 Z" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            font-size: 2rem;
            background: rgba(255,255,255,0.2);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 800;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo-text .slogan {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        /* Corps de la page */
        .login-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-input {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: var(--transition);
            background: var(--card-bg);
            color: var(--text-color);
        }

        .form-input:focus {
            border-color: var(--primary-color);
            outline: none;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .login-btn {
            width: 100%;
            padding: 1rem;
            background: var(--gradient-primary);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .error-message {
            background: #FEE2E2;
            color: #991B1B;
            padding: 1rem;
            border-radius: var(--radius);
            margin-bottom: 1rem;
            text-align: center;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-muted);
        }

        .register-link a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div class="mobile-app">
        <div class="header">
            <div class="logo floating">
                <div class="logo-icon">🚌</div>
                <div class="logo-text">
                    <h1>Sen'Yone</h1>
                    <div class="slogan">Transport Intelligent Dakar</div>
                </div>
            </div>
        </div>
        
        <div class="login-body">
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php">
                <div class="form-group">
                    <label class="form-label" for="email">
                        <i class="fas fa-envelope"></i> Adresse email
                    </label>
                    <input type="email" id="email" name="email" class="form-input" placeholder="votre@email.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">
                        <i class="fas fa-lock"></i> Mot de passe
                    </label>
                    <input type="password" id="password" name="password" class="form-input" placeholder="Votre mot de passe" required>
                </div>
                
                <button type="submit" class="login-btn">
                    <i class="fas fa-sign-in-alt"></i> Se connecter
                </button>
            </form>
            
            <div class="register-link">
                Pas encore de compte? <a href="register.php">S'inscrire</a>
            </div>
        </div>
    </div>

    <script>
        // Gestion du thème
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('senyone-theme');
            if (savedTheme) {
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        });
    </script>
</body>
</html>