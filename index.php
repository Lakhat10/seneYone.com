<?php
session_start();

// Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Initialiser les fichiers de données s'ils n'existent pas
if (!file_exists('data')) {
    mkdir('data', 0777, true);
}

// Initialiser les fichiers JSON avec des données par défaut
$dataFiles = [
    'routes.json' => [
        [
            'id' => 'line1',
            'number' => 'Ligne 1',
            'name' => 'Plateau - Yoff',
            'color' => '#27AE60',
            'stops' => ['Plateau', 'Place de l\'Indépendance', 'Rue Sandinieri', 'HLM 5', 'Fann', 'Mermoz', 'Yoff'],
            'schedule' => ['06:00-22:00', '06:15-22:15', '06:30-22:30'],
            'frequency' => '10-15 min',
            'price' => '300 FCFA',
            'duration' => '45 min',
            'active' => true
        ],
        [
            'id' => 'line2',
            'number' => 'Ligne 2',
            'name' => 'Gare Routière - Ouakam',
            'color' => '#F39C12',
            'stops' => ['Gare Routière', 'Castors', 'Sacré Coeur', 'Ouakam'],
            'schedule' => ['05:30-21:30', '05:45-21:45', '06:00-22:00'],
            'frequency' => '12-18 min',
            'price' => '250 FCFA',
            'duration' => '35 min',
            'active' => true
        ],
        [
            'id' => 'line3',
            'number' => 'Ligne 3',
            'name' => 'Colobane - Parcelles Assainies',
            'color' => '#E74C3C',
            'stops' => ['Colobane', 'Grand Yoff', 'HLM', 'Parcelles Assainies'],
            'schedule' => ['06:15-21:45', '06:30-22:00', '06:45-22:15'],
            'frequency' => '15-20 min',
            'price' => '200 FCFA',
            'duration' => '40 min',
            'active' => true
        ],
        [
            'id' => 'line4',
            'number' => 'Ligne 4',
            'name' => 'Pikine - Guédiawaye',
            'color' => '#9B59B6',
            'stops' => ['Pikine', 'Thiaroye', 'Yeumbeul', 'Guédiawaye'],
            'schedule' => ['05:45-21:15', '06:00-21:30', '06:15-21:45'],
            'frequency' => '15-20 min',
            'price' => '200 FCFA',
            'duration' => '35 min',
            'active' => true
        ],
        [
            'id' => 'line5',
            'number' => 'Ligne 5',
            'name' => 'Rufisque - Cambérène',
            'color' => '#3498DB',
            'stops' => ['Rufisque', 'Bargny', 'Diamniadio', 'Cambérène'],
            'schedule' => ['06:00-22:00', '06:20-22:20', '06:40-22:40'],
            'frequency' => '20-25 min',
            'price' => '350 FCFA',
            'duration' => '55 min',
            'active' => true
        ]
    ],
    'buses.json' => [
        [
            'id' => 'bus_1_001',
            'line' => 'line1',
            'number' => 'Ligne 1',
            'route' => 'Plateau - Yoff',
            'current_stop' => 'Plateau',
            'next_stop' => 'Place de l\'Indépendance',
            'position' => ['lat' => 14.6642, 'lng' => -17.4311],
            'speed' => '25 km/h',
            'passengers' => 45,
            'capacity' => 60,
            'status' => 'on_time',
            'delay' => '0 min',
            'last_update' => date('H:i:s'),
            'direction' => 'aller',
            'arrival_time' => '14:32',
            'driver' => 'M. Diallo',
            'vehicle_type' => 'Bus articulé'
        ],
        [
            'id' => 'bus_2_001',
            'line' => 'line2',
            'number' => 'Ligne 2',
            'route' => 'Gare Routière - Ouakam',
            'current_stop' => 'Gare Routière',
            'next_stop' => 'Castors',
            'position' => ['lat' => 14.6833, 'lng' => -17.4500],
            'speed' => '20 km/h',
            'passengers' => 32,
            'capacity' => 60,
            'status' => 'delayed',
            'delay' => '8 min',
            'last_update' => date('H:i:s'),
            'direction' => 'aller',
            'arrival_time' => '14:35',
            'driver' => 'M. Ndiaye',
            'vehicle_type' => 'Bus standard'
        ],
        [
            'id' => 'bus_3_001',
            'line' => 'line3',
            'number' => 'Ligne 3',
            'route' => 'Colobane - Parcelles Assainies',
            'current_stop' => 'Colobane',
            'next_stop' => 'Grand Yoff',
            'position' => ['lat' => 14.6931, 'lng' => -17.4639],
            'speed' => '28 km/h',
            'passengers' => 28,
            'capacity' => 60,
            'status' => 'on_time',
            'delay' => '0 min',
            'last_update' => date('H:i:s'),
            'direction' => 'aller',
            'arrival_time' => '14:38',
            'driver' => 'M. Sarr',
            'vehicle_type' => 'Bus standard'
        ],
        [
            'id' => 'bus_4_001',
            'line' => 'line4',
            'number' => 'Ligne 4',
            'route' => 'Pikine - Guédiawaye',
            'current_stop' => 'Pikine',
            'next_stop' => 'Thiaroye',
            'position' => ['lat' => 14.75, 'lng' => -17.4],
            'speed' => '22 km/h',
            'passengers' => 38,
            'capacity' => 60,
            'status' => 'on_route',
            'delay' => '0 min',
            'last_update' => date('H:i:s'),
            'direction' => 'aller',
            'arrival_time' => '14:45',
            'driver' => 'M. Fall',
            'vehicle_type' => 'Minibus'
        ],
        [
            'id' => 'bus_5_001',
            'line' => 'line5',
            'number' => 'Ligne 5',
            'route' => 'Rufisque - Cambérène',
            'current_stop' => 'Rufisque',
            'next_stop' => 'Bargny',
            'position' => ['lat' => 14.7167, 'lng' => -17.2667],
            'speed' => '30 km/h',
            'passengers' => 42,
            'capacity' => 60,
            'status' => 'on_route',
            'delay' => '0 min',
            'last_update' => date('H:i:s'),
            'direction' => 'aller',
            'arrival_time' => '14:50',
            'driver' => 'M. Diop',
            'vehicle_type' => 'Bus articulé'
        ]
    ],
    'alerts.json' => [
        [
            'id' => 'alert_1',
            'title' => 'Embouteillages denses',
            'message' => 'Bouchons importants sur la Corniche Ouest vers le centre-ville',
            'location' => 'Centre-ville Plateau',
            'delay' => '+15-25 min',
            'level' => 'high',
            'created_at' => date('Y-m-d H:i:s'),
            'type' => 'traffic'
        ],
        [
            'id' => 'alert_2',
            'title' => 'Accident signalé',
            'message' => 'Accident mineur rue Sandinieri, circulation ralentie',
            'location' => 'Rue Sandinieri',
            'delay' => '+5-10 min',
            'level' => 'medium',
            'created_at' => date('Y-m-d H:i:s'),
            'type' => 'incident'
        ],
        [
            'id' => 'alert_3',
            'title' => 'Travaux de voirie',
            'message' => 'Travaux en cours sur l\'avenue Cheikh Anta Diop',
            'location' => 'Avenue Cheikh Anta Diop',
            'delay' => '+10-15 min',
            'level' => 'medium',
            'created_at' => date('Y-m-d H:i:s'),
            'type' => 'works'
        ],
        [
            'id' => 'alert_4',
            'title' => 'Météo défavorable',
            'message' => 'Pluies intenses ralentissant la circulation',
            'location' => 'Toute la région de Dakar',
            'delay' => '+10-20 min',
            'level' => 'medium',
            'created_at' => date('Y-m-d H:i:s'),
            'type' => 'weather'
        ]
    ],
    'unknown_lines.json' => [
        [
            'id' => 'unknown_1',
            'number' => 'Ligne Express A',
            'name' => 'Dakar Nord Express',
            'color' => '#FF6B6B',
            'stops' => ['Parcelles Assainies', 'Grand Yoff', 'Plateau'],
            'schedule' => ['07:00-09:00', '16:00-19:00'],
            'frequency' => '20-25 min',
            'price' => '400 FCFA',
            'duration' => '30 min',
            'active' => true,
            'type' => 'express'
        ],
        [
            'id' => 'unknown_2',
            'number' => 'Ligne Nuit 1',
            'name' => 'Service Nocturne Centre',
            'color' => '#4ECDC4',
            'stops' => ['Plateau', 'Fann', 'Mermoz', 'Ouakam'],
            'schedule' => ['22:00-02:00'],
            'frequency' => '30-40 min',
            'price' => '500 FCFA',
            'duration' => '35 min',
            'active' => true,
            'type' => 'nocturne'
        ]
    ],
    'notifications.json' => [
        [
            'id' => 'notif_1',
            'title' => 'Bus en approche',
            'message' => 'Le bus Ligne 1 arrive dans 5 minutes à l\'arrêt Plateau',
            'type' => 'bus_arrival',
            'read' => false,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 'notif_2',
            'title' => 'Trafic dense',
            'message' => 'Retard prévu sur votre ligne habituelle',
            'type' => 'traffic_alert',
            'read' => false,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 'notif_3',
            'title' => 'Promotion spéciale',
            'message' => 'Réduction de 20% sur les abonnements ce mois-ci',
            'type' => 'promotion',
            'read' => true,
            'created_at' => date('Y-m-d H:i:s')
        ]
    ]
];

foreach ($dataFiles as $filename => $defaultData) {
    if (!file_exists("data/$filename")) {
        file_put_contents("data/$filename", json_encode($defaultData, JSON_PRETTY_PRINT));
    }
}

// Charger les données
$routes = json_decode(file_get_contents('data/routes.json'), true);
$buses = json_decode(file_get_contents('data/buses.json'), true);
$alerts = json_decode(file_get_contents('data/alerts.json'), true);
$unknown_lines = json_decode(file_get_contents('data/unknown_lines.json'), true);
$notifications = json_decode(file_get_contents('data/notifications.json'), true);

// Compter les notifications non lues
$unread_notifications = array_filter($notifications, function($notif) {
    return !$notif['read'];
});

// Données des arrêts
$stops = [
    'Plateau' => ['lat' => 14.6642, 'lng' => -17.4311, 'name' => 'Plateau'],
    'Place de l\'Indépendance' => ['lat' => 14.6700, 'lng' => -17.4344, 'name' => 'Place de l\'Indépendance'],
    'Rue Sandinieri' => ['lat' => 14.6814, 'lng' => -17.4472, 'name' => 'Rue Sandinieri'],
    'HLM 5' => ['lat' => 14.6981, 'lng' => -17.4569, 'name' => 'HLM 5'],
    'Fann' => ['lat' => 14.6889, 'lng' => -17.4708, 'name' => 'Fann'],
    'Mermoz' => ['lat' => 14.7056, 'lng' => -17.4750, 'name' => 'Mermoz'],
    'Yoff' => ['lat' => 14.7397, 'lng' => -17.4883, 'name' => 'Yoff'],
    'Gare Routière' => ['lat' => 14.6833, 'lng' => -17.4500, 'name' => 'Gare Routière'],
    'Castors' => ['lat' => 14.7208, 'lng' => -17.4722, 'name' => 'Castors'],
    'Sacré Coeur' => ['lat' => 14.7167, 'lng' => -17.4678, 'name' => 'Sacré Coeur'],
    'Ouakam' => ['lat' => 14.7239, 'lng' => -17.4900, 'name' => 'Ouakam'],
    'Colobane' => ['lat' => 14.6931, 'lng' => -17.4639, 'name' => 'Colobane'],
    'Grand Yoff' => ['lat' => 14.7167, 'lng' => -17.4667, 'name' => 'Grand Yoff'],
    'Parcelles Assainies' => ['lat' => 14.7667, 'lng' => -17.4000, 'name' => 'Parcelles Assainies'],
    'Pikine' => ['lat' => 14.75, 'lng' => -17.4, 'name' => 'Pikine'],
    'Thiaroye' => ['lat' => 14.7569, 'lng' => -17.3858, 'name' => 'Thiaroye'],
    'Yeumbeul' => ['lat' => 14.7639, 'lng' => -17.3722, 'name' => 'Yeumbeul'],
    'Guédiawaye' => ['lat' => 14.7833, 'lng' => -17.4, 'name' => 'Guédiawaye'],
    'Rufisque' => ['lat' => 14.7167, 'lng' => -17.2667, 'name' => 'Rufisque'],
    'Bargny' => ['lat' => 14.7167, 'lng' => -17.2333, 'name' => 'Bargny'],
    'Diamniadio' => ['lat' => 14.7167, 'lng' => -17.2, 'name' => 'Diamniadio'],
    'Cambérène' => ['lat' => 14.75, 'lng' => -17.4333, 'name' => 'Cambérène']
];

// Fonction pour calculer le temps d'arrivée estimé
function calculateETA($bus, $stops) {
    if (!isset($bus['current_stop']) || !isset($bus['next_stop'])) {
        return '--:--';
    }
    
    $current_stop = $bus['current_stop'];
    $next_stop = $bus['next_stop'];
    
    // Simuler un calcul d'ETA basé sur la distance et la vitesse
    if (isset($stops[$current_stop]) && isset($stops[$next_stop])) {
        $current_pos = $stops[$current_stop];
        $next_pos = $stops[$next_stop];
        
        // Calcul de distance simplifié (formule de Haversine)
        $lat1 = $current_pos['lat'];
        $lon1 = $current_pos['lng'];
        $lat2 = $next_pos['lat'];
        $lon2 = $next_pos['lng'];
        
        $earth_radius = 6371; // Rayon de la Terre en km
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        $distance = $earth_radius * $c; // Distance en km
        
        // Vitesse moyenne en km/h
        $speed = isset($bus['speed']) ? (float)filter_var($bus['speed'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 25;
        
        // Temps en heures
        $time_hours = $distance / $speed;
        
        // Convertir en minutes
        $time_minutes = $time_hours * 60;
        
        // Ajouter un délai si le bus est en retard
        if (isset($bus['delay']) && $bus['delay'] != '0 min') {
            $delay_minutes = (int)filter_var($bus['delay'], FILTER_SANITIZE_NUMBER_INT);
            $time_minutes += $delay_minutes;
        }
        
        // Calculer l'heure d'arrivée
        $now = time();
        $arrival_time = $now + ($time_minutes * 60);
        
        return date('H:i', $arrival_time);
    }
    
    return '--:--';
}

// Mettre à jour les heures d'arrivée pour tous les bus
foreach ($buses as &$bus) {
    $bus['arrival_time'] = calculateETA($bus, $stops);
}
?>
<!DOCTYPE html>
<html lang="fr" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#27AE60">
    <title>Sen'Yone - Transport Intelligent Dakar</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
</head>
<body>
    <div class="mobile-app">
        <!-- Toast Container pour les notifications -->
        <div class="toast-container" id="toast-container"></div>

        <!-- Sidebar amélioré -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-profile">
                    <div class="sidebar-avatar"><?php echo isset($_SESSION['user_name']) ? substr($_SESSION['user_name'], 0, 1) : 'U'; ?></div>
                    <div class="sidebar-user-info">
                        <div class="sidebar-user-name"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Utilisateur'; ?></div>
                        <div class="sidebar-user-email"><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'email@example.com'; ?></div>
                    </div>
                </div>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-section">
                    <div class="menu-title">Navigation</div>
                    <a href="#" class="menu-item active" data-page="dashboard">
                        <i class="fas fa-home"></i>
                        <span>Tableau de bord</span>
                    </a>
                    <a href="#" class="menu-item" data-page="map">
                        <i class="fas fa-map"></i>
                        <span>Carte en temps réel</span>
                    </a>
                    <a href="#" class="menu-item" data-page="trips">
                        <i class="fas fa-route"></i>
                        <span>Planifier un trajet</span>
                    </a>
                    <a href="#" class="menu-item" data-page="notifications">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <?php if(count($unread_notifications) > 0): ?>
                            <span class="menu-badge"><?php echo count($unread_notifications); ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Services</div>
                    <a href="#" class="menu-item" data-page="alerts">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Alertes trafic</span>
                    </a>
                    <a href="#" class="menu-item" data-page="lines">
                        <i class="fas fa-bus"></i>
                        <span>Lignes & Horaires</span>
                    </a>
                    <a href="#" class="menu-item" data-page="favorites">
                        <i class="fas fa-star"></i>
                        <span>Favoris</span>
                    </a>
                    <a href="#" class="menu-item" data-page="history">
                        <i class="fas fa-history"></i>
                        <span>Historique</span>
                    </a>
                </div>
                
                <div class="menu-section">
                    <div class="menu-title">Compte</div>
                    <a href="#" class="menu-item" data-page="profile">
                        <i class="fas fa-user"></i>
                        <span>Mon profil</span>
                    </a>
                    <a href="#" class="menu-item" data-page="settings">
                        <i class="fas fa-cog"></i>
                        <span>Paramètres</span>
                    </a>
                    <a href="#" class="menu-item" data-page="help">
                        <i class="fas fa-question-circle"></i>
                        <span>Aide & Support</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-footer">
                <a href="logout.php" class="trip-btn" style="background: var(--danger-color); color: white; text-decoration: none; display: block; text-align: center;">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </a>
            </div>
        </div>
        
        <!-- Overlay pour sidebar -->
        <div class="sidebar-overlay"></div>

        <!-- En-tête amélioré -->
        <div class="header">
            <div class="header-content">
                <button class="menu-toggle" id="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="logo">
                    <div class="logo-icon">🚌</div>
                    <div class="logo-text">
                        <h1>Sen'Yone</h1>
                        <div class="slogan">Transport Intelligent Dakar</div>
                    </div>
                </div>
                
                <div class="header-actions">
                    <button class="header-btn" id="theme-toggle">
                        <i class="fas fa-moon"></i>
                    </button>
                    <button class="header-btn" id="notification-btn">
                        <i class="fas fa-bell"></i>
                        <?php if(count($unread_notifications) > 0): ?>
                            <span class="header-badge"><?php echo count($unread_notifications); ?></span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenu principal amélioré -->
        <div class="main-content">
            <!-- Tableau de bord amélioré -->
            <div class="app-page active" id="dashboard-page">
                <!-- Actions rapides -->
                <div class="quick-actions">
                    <a href="#" class="quick-action" data-page="trips">
                        <div class="quick-action-icon">
                            <i class="fas fa-route"></i>
                        </div>
                        <div class="quick-action-label">Trajet</div>
                    </a>
                    <a href="#" class="quick-action" data-page="map">
                        <div class="quick-action-icon">
                            <i class="fas fa-map"></i>
                        </div>
                        <div class="quick-action-label">Carte</div>
                    </a>
                    <a href="#" class="quick-action" data-page="alerts">
                        <div class="quick-action-icon">
                            <i class="fas fa-traffic-light"></i>
                        </div>
                        <div class="quick-action-label">Trafic</div>
                    </a>
                    <a href="#" class="quick-action" data-page="favorites">
                        <div class="quick-action-icon">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="quick-action-label">Favoris</div>
                    </a>
                </div>
                
                <div class="content-section">
                    <!-- Métriques en temps réel -->
                    <div class="metrics-grid">
                        <div class="metric-card">
                            <div class="metric-value"><?php echo count($buses); ?></div>
                            <div class="metric-label">Bus en circulation</div>
                            <div class="metric-trend trend-up">
                                <i class="fas fa-arrow-up"></i> 2 de plus
                            </div>
                        </div>
                        <div class="metric-card">
                            <div class="metric-value">8min</div>
                            <div class="metric-label">Temps d'attente moyen</div>
                            <div class="metric-trend trend-down">
                                <i class="fas fa-arrow-down"></i> 3min de moins
                            </div>
                        </div>
                    </div>

                    <!-- Alertes trafic améliorées -->
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Alertes Trafic
                        </h2>
                        <a href="#" class="section-link" id="view-all-alerts">Voir tout</a>
                    </div>
                    <div class="alerts-container">
                        <?php foreach($alerts as $alert): 
                            $alertType = isset($alert['type']) ? $alert['type'] : 'traffic';
                        ?>
                        <div class="alert-card <?php echo $alert['level']; ?>">
                            <div class="alert-type">
                                <div class="alert-type-icon type-<?php echo $alertType; ?>">
                                    <?php 
                                    if ($alertType === 'traffic') echo '🚦';
                                    elseif ($alertType === 'incident') echo '🚨';
                                    elseif ($alertType === 'works') echo '🚧';
                                    else echo '🌧️';
                                    ?>
                                </div>
                                <div class="alert-title"><?php echo htmlspecialchars($alert['title']); ?></div>
                            </div>
                            <div class="alert-message"><?php echo htmlspecialchars($alert['message']); ?></div>
                            <div class="alert-footer">
                                <span><?php echo htmlspecialchars($alert['location']); ?></span>
                                <span><?php echo htmlspecialchars($alert['delay']); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Prochains départs améliorés -->
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-bus"></i>
                            Prochains Départs
                        </h2>
                        <a href="#" class="section-link" id="view-schedule">Voir horaires</a>
                    </div>
                    <div class="schedule-list">
                        <?php foreach($buses as $bus): 
                            $route = null;
                            foreach($routes as $r) {
                                if ($r['id'] === $bus['line']) {
                                    $route = $r;
                                    break;
                                }
                            }
                        ?>
                        <div class="schedule-item" style="border-left-color: <?php echo $route ? $route['color'] : '#27AE60'; ?>">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge"><?php echo htmlspecialchars($bus['number']); ?></div>
                                    <div class="bus-number"><?php echo htmlspecialchars($bus['route']); ?></div>
                                </div>
                                <div class="bus-route">Prochain arrêt: <?php echo htmlspecialchars($bus['next_stop']); ?></div>
                                <div class="bus-details">
                                    <i class="fas fa-users"></i> <?php echo $bus['passengers']; ?>/<?php echo $bus['capacity']; ?> passagers
                                    <i class="fas fa-clock"></i> Fréquence: <?php echo $route ? $route['frequency'] : '10-15min'; ?>
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="arrival-time"><?php echo htmlspecialchars($bus['arrival_time']); ?></div>
                                <div class="status-badge status-<?php echo $bus['status']; ?>">
                                    <?php 
                                    if ($bus['status'] === 'on_time') {
                                        echo 'À l\'heure';
                                    } elseif ($bus['status'] === 'delayed') {
                                        echo 'Retard ' . $bus['delay'];
                                    } else {
                                        echo 'En route';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Lignes spéciales améliorées -->
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            Lignes Spéciales
                        </h2>
                        <a href="#" class="section-link" id="view-special-lines">Voir tout</a>
                    </div>
                    <div class="schedule-list">
                        <?php foreach($unknown_lines as $line): ?>
                        <div class="schedule-item" style="border-left-color: <?php echo $line['color']; ?>">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <?php if (isset($line['type']) && $line['type'] === 'express'): ?>
                                        <div class="express-badge"><?php echo htmlspecialchars($line['number']); ?></div>
                                    <?php else: ?>
                                        <div class="special-badge"><?php echo htmlspecialchars($line['number']); ?></div>
                                    <?php endif; ?>
                                    <div class="bus-number"><?php echo htmlspecialchars($line['name']); ?></div>
                                </div>
                                <div class="bus-route">Arrêts: <?php echo implode(' → ', array_slice($line['stops'], 0, 3)); ?>...</div>
                                <div class="bus-details">
                                    <i class="fas fa-clock"></i> Horaires: <?php echo implode(', ', $line['schedule']); ?>
                                    <i class="fas fa-coins"></i> <?php echo $line['price']; ?>
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="arrival-time"><?php echo $line['duration']; ?></div>
                                <div class="status-badge status-on-time">
                                    <?php echo (isset($line['type']) && $line['type'] === 'express') ? 'Express' : 'Nocturne'; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Page Carte améliorée -->
            <div class="app-page" id="map-page">
                <div class="map-container">
                    <div id="live-map"></div>
                    <div class="map-overlay">
                        <div class="map-search">
                            <i class="fas fa-search"></i>
                            <input type="text" id="map-search-input" placeholder="Rechercher un arrêt ou une ligne...">
                        </div>
                        <div class="map-controls">
                            <button class="map-btn" id="locate-btn" title="Me localiser">
                                <i class="fas fa-crosshairs"></i>
                            </button>
                            <button class="map-btn" id="refresh-map" title="Actualiser">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <button class="map-btn" id="filter-map" title="Filtrer">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Trajets améliorée -->
            <div class="app-page" id="trips-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-route"></i>
                            Planifier un Trajet
                        </h2>
                    </div>
                    
                    <div class="trip-planner">
                        <div class="trip-inputs">
                            <div class="trip-input-group">
                                <div class="trip-input-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <input type="text" class="trip-input" id="trip-start" placeholder="Point de départ">
                            </div>
                            <div class="trip-input-group">
                                <div class="trip-input-icon">
                                    <i class="fas fa-flag"></i>
                                </div>
                                <input type="text" class="trip-input" id="trip-end" placeholder="Destination">
                            </div>
                        </div>
                        
                        <div class="trip-actions">
                            <button class="trip-btn trip-btn-primary" id="plan-trip">
                                <i class="fas fa-search"></i> Planifier
                            </button>
                            <button class="trip-btn trip-btn-secondary" id="current-location">
                                <i class="fas fa-crosshairs"></i> Ma position
                            </button>
                        </div>
                    </div>

                    <div id="trip-results" class="hidden">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-route"></i>
                                Itinéraires trouvés
                            </h2>
                        </div>
                        
                        <div class="trip-results">
                            <div class="trip-option" data-route="line1">
                                <div class="trip-option-header">
                                    <div class="trip-route">Ligne 1: Plateau - Yoff</div>
                                    <div class="trip-duration">45 min</div>
                                </div>
                                <div class="trip-details">
                                    <div>3 arrêts • 300 FCFA</div>
                                    <div>Prochain bus: 14:32</div>
                                </div>
                            </div>
                            
                            <div class="trip-option" data-route="line2">
                                <div class="trip-option-header">
                                    <div class="trip-route">Ligne 2: Gare Routière - Ouakam</div>
                                    <div class="trip-duration">35 min</div>
                                </div>
                                <div class="trip-details">
                                    <div>2 arrêts • 250 FCFA</div>
                                    <div>Prochain bus: 14:35</div>
                                </div>
                            </div>
                            
                            <div class="trip-option" data-route="line3">
                                <div class="trip-option-header">
                                    <div class="trip-route">Ligne 3: Colobane - Parcelles Assainies</div>
                                    <div class="trip-duration">40 min</div>
                                </div>
                                <div class="trip-details">
                                    <div>3 arrêts • 200 FCFA</div>
                                    <div>Prochain bus: 14:38</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-header mt-2">
                        <h2 class="section-title">
                            <i class="fas fa-history"></i>
                            Historique Récent
                        </h2>
                        <a href="#" class="section-link" id="view-all-history">Voir tout</a>
                    </div>
                    
                    <div class="schedule-list">
                        <div class="schedule-item">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge">Trajet</div>
                                    <div class="bus-number">Plateau → Yoff</div>
                                </div>
                                <div class="bus-route">Aujourd'hui, 14:20 • Durée: 42min</div>
                                <div class="bus-details">
                                    <i class="fas fa-star" style="color: #F39C12;"></i> 4.8
                                    <i class="fas fa-coins" style="color: #27AE60;"></i> 300 FCFA
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="status-badge status-on-time">Terminé</div>
                            </div>
                        </div>
                        <div class="schedule-item">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge">Trajet</div>
                                    <div class="bus-number">Gare Routière → Ouakam</div>
                                </div>
                                <div class="bus-route">Hier, 08:15 • Durée: 38min</div>
                                <div class="bus-details">
                                    <i class="fas fa-star" style="color: #F39C12;"></i> 4.5
                                    <i class="fas fa-coins" style="color: #27AE60;"></i> 250 FCFA
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="status-badge status-on-time">Terminé</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Notifications -->
            <div class="app-page" id="notifications-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-bell"></i>
                            Notifications
                        </h2>
                        <a href="#" class="section-link" id="mark-all-read">Tout marquer comme lu</a>
                    </div>
                    
                    <div class="notifications-list">
                        <?php foreach($notifications as $notification): ?>
                        <div class="notification-item <?php echo $notification['read'] ? '' : 'unread'; ?>">
                            <div class="notification-header">
                                <div class="notification-title"><?php echo htmlspecialchars($notification['title']); ?></div>
                                <div class="notification-time"><?php echo date('H:i', strtotime($notification['created_at'])); ?></div>
                            </div>
                            <div class="notification-message"><?php echo htmlspecialchars($notification['message']); ?></div>
                            <div class="notification-actions">
                                <button class="notification-action" data-notification-id="<?php echo $notification['id']; ?>">
                                    <i class="fas fa-check"></i> Marquer comme lu
                                </button>
                                <button class="notification-action" data-notification-id="<?php echo $notification['id']; ?>">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Page Paramètres améliorée -->
            <div class="app-page" id="settings-page">
                <div class="content-section">
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-palette"></i>
                            Apparence
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Thème de l'application</div>
                                    <div class="setting-desc">Personnalisez l'apparence de Sen'Yone</div>
                                </div>
                                <select id="theme-selector" class="form-input">
                                    <option value="light">Clair</option>
                                    <option value="dark">Sombre</option>
                                    <option value="vibrant">Vibrant</option>
                                </select>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Mode sombre automatique</div>
                                    <div class="setting-desc">Activer/désactiver en fonction de l'heure</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="auto-dark-mode">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-bell"></i>
                            Notifications
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Notifications push</div>
                                    <div class="setting-desc">Recevoir des alertes en temps réel</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="push-notifications" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Alertes trafic</div>
                                    <div class="setting-desc">Notifications sur les embouteillages</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="traffic-alerts" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Rappels de bus</div>
                                    <div class="setting-desc">Alertes avant l'arrivée du bus</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="bus-reminders" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-map"></i>
                            Carte et Navigation
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Géolocalisation</div>
                                    <div class="setting-desc">Utiliser ma position pour des trajets précis</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="geolocation" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Mode hors ligne</div>
                                    <div class="setting-desc">Fonctionnalités limitées sans connexion</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="offline-mode">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Cartes détaillées</div>
                                    <div class="setting-desc">Charger des cartes haute résolution</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="detailed-maps">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-shield-alt"></i>
                            Confidentialité et Sécurité
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Données de diagnostic</div>
                                    <div class="setting-desc">Partager pour améliorer l'application</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="diagnostic-data">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Historique de localisation</div>
                                    <div class="setting-desc">Sauvegarder mes trajets fréquents</div>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" id="location-history" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Profil améliorée -->
            <div class="app-page" id="profile-page">
                <div class="profile-header">
                    <div class="profile-avatar"><?php echo isset($_SESSION['user_name']) ? substr($_SESSION['user_name'], 0, 1) : 'U'; ?></div>
                    <div class="profile-name"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Utilisateur'; ?></div>
                    <div class="profile-email"><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'email@example.com'; ?></div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">24</div>
                        <div class="stat-label">Trajets effectués</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">18h</div>
                        <div class="stat-label">Temps économisé</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">4.7</div>
                        <div class="stat-label">Note moyenne</div>
                    </div>
                </div>
                
                <div class="content-section">
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-user-cog"></i>
                            Informations personnelles
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Nom complet</div>
                                    <div class="setting-desc"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Utilisateur'; ?></div>
                                </div>
                                <button class="trip-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Adresse email</div>
                                    <div class="setting-desc"><?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : 'email@example.com'; ?></div>
                                </div>
                                <button class="trip-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Mot de passe</div>
                                    <div class="setting-desc">••••••••</div>
                                </div>
                                <button class="trip-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-edit"></i> Modifier
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-heart"></i>
                            Préférences
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Lignes favorites</div>
                                    <div class="setting-desc">3 lignes enregistrées</div>
                                </div>
                                <button class="trip-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Voir
                                </button>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Trajets récurrents</div>
                                    <div class="setting-desc">2 trajets réguliers</div>
                                </div>
                                <button class="trip-btn" style="padding: 0.5rem 1rem; font-size: 0.9rem;">
                                    <i class="fas fa-eye"></i> Voir
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <a href="logout.php" class="trip-btn" style="background: var(--danger-color); color: white; text-decoration: none; display: block; text-align: center;">
                            <i class="fas fa-sign-out-alt"></i> Déconnexion
                        </a>
                    </div>
                </div>
            </div>

            <!-- Autres pages (placeholder) -->
            <div class="app-page" id="alerts-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Alertes Trafic
                        </h2>
                    </div>
                    <div class="alerts-container">
                        <?php foreach($alerts as $alert): 
                            $alertType = isset($alert['type']) ? $alert['type'] : 'traffic';
                        ?>
                        <div class="alert-card <?php echo $alert['level']; ?>">
                            <div class="alert-type">
                                <div class="alert-type-icon type-<?php echo $alertType; ?>">
                                    <?php 
                                    if ($alertType === 'traffic') echo '🚦';
                                    elseif ($alertType === 'incident') echo '🚨';
                                    elseif ($alertType === 'works') echo '🚧';
                                    else echo '🌧️';
                                    ?>
                                </div>
                                <div class="alert-title"><?php echo htmlspecialchars($alert['title']); ?></div>
                            </div>
                            <div class="alert-message"><?php echo htmlspecialchars($alert['message']); ?></div>
                            <div class="alert-footer">
                                <span><?php echo htmlspecialchars($alert['location']); ?></span>
                                <span><?php echo htmlspecialchars($alert['delay']); ?></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="app-page" id="lines-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-bus"></i>
                            Toutes les Lignes
                        </h2>
                    </div>
                    <div class="schedule-list">
                        <?php foreach($routes as $route): ?>
                        <div class="schedule-item" style="border-left-color: <?php echo $route['color']; ?>">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge"><?php echo htmlspecialchars($route['number']); ?></div>
                                    <div class="bus-number"><?php echo htmlspecialchars($route['name']); ?></div>
                                </div>
                                <div class="bus-route">Arrêts: <?php echo implode(' → ', $route['stops']); ?></div>
                                <div class="bus-details">
                                    <i class="fas fa-clock"></i> Horaires: <?php echo implode(', ', $route['schedule']); ?>
                                    <i class="fas fa-coins"></i> <?php echo $route['price']; ?>
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="arrival-time"><?php echo $route['duration']; ?></div>
                                <div class="status-badge status-on-time">
                                    Fréquence: <?php echo $route['frequency']; ?>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="app-page" id="favorites-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-star"></i>
                            Mes Favoris
                        </h2>
                    </div>
                    <div class="text-center" style="padding: 3rem 1rem; color: var(--text-muted);">
                        <i class="fas fa-star" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                        <p>Aucun favori pour le moment</p>
                        <p class="mt-1" style="font-size: 0.9rem;">Ajoutez des lignes ou des trajets à vos favoris pour y accéder rapidement</p>
                    </div>
                </div>
            </div>

            <div class="app-page" id="history-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-history"></i>
                            Historique des Trajets
                        </h2>
                    </div>
                    <div class="schedule-list">
                        <div class="schedule-item">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge">Trajet</div>
                                    <div class="bus-number">Plateau → Yoff</div>
                                </div>
                                <div class="bus-route">Aujourd'hui, 14:20 • Durée: 42min</div>
                                <div class="bus-details">
                                    <i class="fas fa-star" style="color: #F39C12;"></i> 4.8
                                    <i class="fas fa-coins" style="color: #27AE60;"></i> 300 FCFA
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="status-badge status-on-time">Terminé</div>
                            </div>
                        </div>
                        <div class="schedule-item">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge">Trajet</div>
                                    <div class="bus-number">Gare Routière → Ouakam</div>
                                </div>
                                <div class="bus-route">Hier, 08:15 • Durée: 38min</div>
                                <div class="bus-details">
                                    <i class="fas fa-star" style="color: #F39C12;"></i> 4.5
                                    <i class="fas fa-coins" style="color: #27AE60;"></i> 250 FCFA
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="status-badge status-on-time">Terminé</div>
                            </div>
                        </div>
                        <div class="schedule-item">
                            <div class="bus-info">
                                <div class="bus-header">
                                    <div class="bus-badge">Trajet</div>
                                    <div class="bus-number">Colobane → Parcelles Assainies</div>
                                </div>
                                <div class="bus-route">12 Mars 2024, 17:30 • Durée: 45min</div>
                                <div class="bus-details">
                                    <i class="fas fa-star" style="color: #F39C12;"></i> 4.2
                                    <i class="fas fa-coins" style="color: #27AE60;"></i> 200 FCFA
                                </div>
                            </div>
                            <div class="arrival-info">
                                <div class="status-badge status-on-time">Terminé</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="app-page" id="help-page">
                <div class="content-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-question-circle"></i>
                            Aide & Support
                        </h2>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-info-circle"></i>
                            Centre d'aide
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Comment planifier un trajet</div>
                                    <div class="setting-desc">Guide complet pour utiliser la planification</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Comprendre les alertes trafic</div>
                                    <div class="setting-desc">Interpréter les différents types d'alertes</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Gérer mes notifications</div>
                                    <div class="setting-desc">Personnaliser les alertes reçues</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-headset"></i>
                            Support client
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Contactez-nous</div>
                                    <div class="setting-desc">Service client disponible 7j/7</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">FAQ</div>
                                    <div class="setting-desc">Questions fréquemment posées</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Signaler un problème</div>
                                    <div class="setting-desc">Problème technique ou suggestion</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="settings-section">
                        <h2 class="settings-title">
                            <i class="fas fa-mobile-alt"></i>
                            À propos de l'application
                        </h2>
                        <div class="settings-list">
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Version</div>
                                    <div class="setting-desc">Sen'Yone v2.0.0</div>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Dernière mise à jour</div>
                                    <div class="setting-desc">15 Mars 2024</div>
                                </div>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Politique de confidentialité</div>
                                    <div class="setting-desc">Comment nous protégeons vos données</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                            <div class="setting-item">
                                <div class="setting-info">
                                    <div class="setting-name">Conditions d'utilisation</div>
                                    <div class="setting-desc">Règles d'utilisation de l'application</div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: var(--text-muted);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation bas améliorée -->
        <nav class="bottom-nav">
            <a href="#" class="nav-item active" data-page="dashboard">
                <div class="nav-icon-large"><i class="fas fa-home"></i></div>
                <div>Accueil</div>
            </a>
            <a href="#" class="nav-item" data-page="map">
                <div class="nav-icon-large"><i class="fas fa-map"></i></div>
                <div>Carte</div>
            </a>
            <a href="#" class="nav-item" data-page="trips">
                <div class="nav-icon-large"><i class="fas fa-route"></i></div>
                <div>Trajets</div>
            </a>
            <a href="#" class="nav-item" data-page="notifications">
                <div class="nav-icon-large"><i class="fas fa-bell"></i></div>
                <div>Alertes</div>
                <?php if(count($unread_notifications) > 0): ?>
                    <span class="nav-badge"><?php echo count($unread_notifications); ?></span>
                <?php endif; ?>
            </a>
        </nav>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
          // Variables globales améliorées
        let map;
        let userLocationMarker;
        let busMarkers = [];
        let stopMarkers = [];
        let currentTheme = 'light';
        let currentPage = 'dashboard';

        // Données des routes, bus et alertes (chargées depuis PHP)
        const routes = <?php echo json_encode($routes); ?>;
        const buses = <?php echo json_encode($buses); ?>;
        const stops = <?php echo json_encode($stops); ?>;
        const alerts = <?php echo json_encode($alerts); ?>;
        const unknownLines = <?php echo json_encode($unknown_lines); ?>;
        const notifications = <?php echo json_encode($notifications); ?>;

        // Initialisation de l'application améliorée
        document.addEventListener('DOMContentLoaded', function() {
            // Navigation entre pages
            document.querySelectorAll('.nav-item, .menu-item, .quick-action').forEach(item => {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    const page = this.getAttribute('data-page');
                    
                    if (page) {
                        navigateToPage(page);
                    }
                });
            });

            // Gestion du thème
            document.getElementById('theme-toggle').addEventListener('click', toggleTheme);
            
            // Menu toggle
            document.getElementById('menu-toggle').addEventListener('click', toggleSidebar);
            document.querySelector('.sidebar-overlay').addEventListener('click', toggleSidebar);
            
            // Initialiser la carte si sur la page carte
            if (document.getElementById('map-page').classList.contains('active')) {
                initMap();
            }
            
            // Boutons de la carte
            document.getElementById('locate-btn')?.addEventListener('click', locateUser);
            document.getElementById('refresh-map')?.addEventListener('click', refreshMap);
            
            // Planification de trajet
            document.getElementById('plan-trip')?.addEventListener('click', planTrip);
            document.getElementById('current-location')?.addEventListener('click', useCurrentLocation);
            
            // Sélection d'itinéraire
            document.querySelectorAll('.trip-option').forEach(option => {
                option.addEventListener('click', function() {
                    document.querySelectorAll('.trip-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    this.classList.add('selected');
                    
                    const routeId = this.getAttribute('data-route');
                    showNotification(`Itinéraire sélectionné: ${routeId}`, 'success');
                });
            });
            
            // Gestion des notifications
            document.getElementById('mark-all-read')?.addEventListener('click', markAllNotificationsAsRead);
            document.querySelectorAll('.notification-action').forEach(button => {
                button.addEventListener('click', function() {
                    const notificationId = this.getAttribute('data-notification-id');
                    if (this.querySelector('.fa-check')) {
                        markNotificationAsRead(notificationId);
                    } else if (this.querySelector('.fa-trash')) {
                        deleteNotification(notificationId);
                    }
                });
            });
            
            // Paramètres
            document.getElementById('theme-selector')?.addEventListener('change', function() {
                changeTheme(this.value);
            });
            
            // Simuler des mises à jour en temps réel
            setInterval(updateRealTimeData, 30000);
            
            // Charger le thème sauvegardé
            const savedTheme = localStorage.getItem('senyone-theme');
            if (savedTheme) {
                currentTheme = savedTheme;
                document.documentElement.setAttribute('data-theme', currentTheme);
                updateThemeIcon();
                
                // Mettre à jour le sélecteur de thème
                const themeSelector = document.getElementById('theme-selector');
                if (themeSelector) {
                    themeSelector.value = currentTheme;
                }
            }
            
            // Afficher une notification de bienvenue
            setTimeout(() => {
                showNotification('Bienvenue sur Sen\'Yone ! Votre application de transport intelligent.', 'success');
            }, 1000);
        });

        // Navigation entre pages
        function navigateToPage(page) {
            // Mettre à jour la navigation active
            document.querySelectorAll('.nav-item').forEach(nav => {
                nav.classList.remove('active');
            });
            document.querySelector(`.nav-item[data-page="${page}"]`)?.classList.add('active');
            
            document.querySelectorAll('.menu-item').forEach(menu => {
                menu.classList.remove('active');
            });
            document.querySelector(`.menu-item[data-page="${page}"]`)?.classList.add('active');
            
            // Afficher la page correspondante
            document.querySelectorAll('.app-page').forEach(pageEl => {
                pageEl.classList.remove('active');
            });
            document.getElementById(`${page}-page`).classList.add('active');
            
            // Fermer le sidebar
            toggleSidebar(false);
            
            // Initialiser la carte si nécessaire
            if (page === 'map' && !map) {
                setTimeout(initMap, 100);
            }
            
            currentPage = page;
        }

        // Fonction pour basculer le sidebar
        function toggleSidebar(show) {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (show !== undefined) {
                if (show) {
                    sidebar.classList.add('active');
                    overlay.classList.add('active');
                } else {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                }
            } else {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            }
        }

        // Fonction pour basculer le thème
        function toggleTheme() {
            const themes = ['light', 'dark', 'vibrant'];
            const currentIndex = themes.indexOf(currentTheme);
            currentTheme = themes[(currentIndex + 1) % themes.length];
            
            changeTheme(currentTheme);
        }

        // Changer le thème
        function changeTheme(theme) {
            currentTheme = theme;
            document.documentElement.setAttribute('data-theme', currentTheme);
            
            // Mettre à jour l'icône
            updateThemeIcon();
            
            // Mettre à jour le sélecteur de thème
            const themeSelector = document.getElementById('theme-selector');
            if (themeSelector) {
                themeSelector.value = currentTheme;
            }
            
            // Sauvegarder la préférence
            localStorage.setItem('senyone-theme', currentTheme);
            
            showNotification(`Thème ${currentTheme} activé`, 'success');
        }

        // Mettre à jour l'icône du thème
        function updateThemeIcon() {
            const themeIcon = document.querySelector('#theme-toggle i');
            if (currentTheme === 'light') {
                themeIcon.className = 'fas fa-moon';
            } else if (currentTheme === 'dark') {
                themeIcon.className = 'fas fa-sun';
            } else {
                themeIcon.className = 'fas fa-palette';
            }
        }

        // Initialisation de la carte améliorée
        function initMap() {
            if (!document.getElementById('live-map')) return;
            
            map = L.map('live-map').setView([14.7167, -17.4677], 13);
            
            // Utiliser un style de carte adapté au thème
            const isDark = currentTheme === 'dark';
            const tileUrl = isDark 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                
            const attribution = isDark
                ? '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
                : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
            
            L.tileLayer(tileUrl, {
                attribution: attribution,
                maxZoom: 19
            }).addTo(map);

            // Ajouter les arrêts de bus
            Object.values(stops).forEach(stop => {
                const stopIcon = L.divIcon({
                    html: `
                        <div style="
                            background: ${isDark ? '#3498DB' : '#27AE60'};
                            color: white;
                            border: 3px solid white;
                            border-radius: 50%;
                            width: 24px;
                            height: 24px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: bold;
                            box-shadow: 0 3px 6px rgba(0,0,0,0.3);
                        ">🚏</div>
                    `,
                    className: 'stop-marker',
                    iconSize: [24, 24],
                    iconAnchor: [12, 12]
                });

                const stopMarker = L.marker([stop.lat, stop.lng], { icon: stopIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="text-align: center; min-width: 180px;">
                            <strong>${stop.name}</strong><br>
                            <small>Arrêt de bus Sen'Yone</small>
                            <div style="margin-top: 0.5rem;">
                                <button class="trip-btn" style="padding: 0.5rem; font-size: 0.8rem; margin: 0.25rem;" onclick="setAsTripStart('${stop.name}')">
                                    Départ
                                </button>
                                <button class="trip-btn" style="padding: 0.5rem; font-size: 0.8rem; margin: 0.25rem; background: #F39C12;" onclick="setAsTripEnd('${stop.name}')">
                                    Arrivée
                                </button>
                            </div>
                        </div>
                    `);
                stopMarkers.push(stopMarker);
            });

            // Ajouter les bus en circulation
            buses.forEach(bus => {
                const route = routes.find(r => r.id === bus.line) || {};
                const isOnTime = bus.status === 'on_time';
                const isDelayed = bus.status === 'delayed';
                let busColor = isDark ? '#58D68D' : '#27AE60'; // Vert par défaut
                
                if (isDelayed) {
                    busColor = isDark ? '#EC7063' : '#E74C3C'; // Rouge pour retard
                } else if (bus.status === 'on_route') {
                    busColor = isDark ? '#5DADE2' : '#3498DB'; // Bleu pour en route
                }
                
                const busIcon = L.divIcon({
                    html: `
                        <div style="
                            background: ${busColor};
                            color: white;
                            border: 3px solid white;
                            border-radius: 50%;
                            width: 36px;
                            height: 36px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-weight: bold;
                            box-shadow: 0 3px 6px rgba(0,0,0,0.3);
                            animation: pulse 2s infinite;
                        ">🚌</div>
                    `,
                    className: 'bus-marker',
                    iconSize: [36, 36],
                    iconAnchor: [18, 18]
                });

                const busMarker = L.marker([bus.position.lat, bus.position.lng], { icon: busIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width: 220px;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <div style="background: ${route.color || '#3498DB'}; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-weight: bold; font-size: 0.8rem;">${bus.number}</div>
                                <strong>${bus.route}</strong>
                            </div>
                            <div style="font-size: 0.9rem;">
                                <div><strong>Statut:</strong> ${isOnTime ? 'À l\'heure' : isDelayed ? 'Retard ' + bus.delay : 'En route'}</div>
                                <div><strong>Position:</strong> ${bus.current_stop}</div>
                                <div><strong>Prochain arrêt:</strong> ${bus.next_stop}</div>
                                <div><strong>Passagers:</strong> ${bus.passengers}/${bus.capacity}</div>
                                <div><strong>Prochain passage:</strong> ${bus.arrival_time || '--:--'}</div>
                                ${bus.driver ? `<div><strong>Chauffeur:</strong> ${bus.driver}</div>` : ''}
                                ${bus.vehicle_type ? `<div><strong>Véhicule:</strong> ${bus.vehicle_type}</div>` : ''}
                            </div>
                        </div>
                    `);
                busMarkers.push(busMarker);
            });

            console.log('Carte Sen\'Yone initialisée avec', buses.length, 'bus et', Object.keys(stops).length, 'arrêts');
            
            // Ajouter le CSS pour l'animation de pulsation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes pulse {
                    0% { transform: scale(1); }
                    50% { transform: scale(1.05); }
                    100% { transform: scale(1); }
                }
            `;
            document.head.appendChild(style);
        }

        // Localisation utilisateur améliorée
        function locateUser() {
            if (!map) return;
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Supprimer l'ancien marqueur
                        if (userLocationMarker) {
                            map.removeLayer(userLocationMarker);
                        }
                        
                        // Ajouter le nouveau marqueur
                        userLocationMarker = L.marker([lat, lng], {
                            icon: L.divIcon({
                                html: `
                                    <div style="
                                        background: #3498DB;
                                        color: white;
                                        border: 3px solid white;
                                        border-radius: 50%;
                                        width: 24px;
                                        height: 24px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        font-weight: bold;
                                        box-shadow: 0 3px 6px rgba(0,0,0,0.3);
                                    "></div>
                                `,
                                className: 'user-location-marker',
                                iconSize: [24, 24],
                                iconAnchor: [12, 12]
                            })
                        })
                            .addTo(map)
                            .bindPopup('Votre position actuelle')
                            .openPopup();
                        
                        // Centrer la carte sur la position
                        map.setView([lat, lng], 15);
                        showNotification('Position localisée avec succès', 'success');
                    },
                    function(error) {
                        showNotification('Impossible de récupérer votre position', 'error');
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 60000
                    }
                );
            } else {
                showNotification('La géolocalisation n\'est pas supportée par votre navigateur', 'error');
            }
        }

        // Actualiser la carte améliorée
        function refreshMap() {
            if (map) {
                // Simuler le rechargement des données
                showNotification('Carte actualisée', 'success');
            }
        }

        // Planifier un trajet amélioré
        function planTrip() {
            const start = document.getElementById('trip-start').value;
            const end = document.getElementById('trip-end').value;
            
            if (!start || !end) {
                showNotification('Veuillez renseigner le point de départ et la destination', 'error');
                return;
            }
            
            // Afficher les résultats
            document.getElementById('trip-results').classList.remove('hidden');
            showNotification('Itinéraires trouvés pour votre trajet', 'success');
            
            // Faire défiler jusqu'aux résultats
            document.getElementById('trip-results').scrollIntoView({ behavior: 'smooth' });
        }

        // Utiliser la position actuelle améliorée
        function useCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        // Simuler l'obtention d'un nom de lieu à partir des coordonnées
                        document.getElementById('trip-start').value = 'Votre position actuelle';
                        showNotification('Position actuelle définie comme point de départ', 'success');
                    },
                    function(error) {
                        showNotification('Impossible de récupérer votre position', 'error');
                    }
                );
            } else {
                showNotification('La géolocalisation n\'est pas supportée par votre navigateur', 'error');
            }
        }

        // Définir le point de départ depuis la carte
        function setAsTripStart(stopName) {
            document.getElementById('trip-start').value = stopName;
            showNotification(`Point de départ défini: ${stopName}`, 'success');
            if (currentPage !== 'trips') {
                navigateToPage('trips');
            }
        }

        // Définir la destination depuis la carte
        function setAsTripEnd(stopName) {
            document.getElementById('trip-end').value = stopName;
            showNotification(`Destination définie: ${stopName}`, 'success');
            if (currentPage !== 'trips') {
                navigateToPage('trips');
            }
        }

        // Gestion des notifications
        function markAllNotificationsAsRead() {
            document.querySelectorAll('.notification-item.unread').forEach(item => {
                item.classList.remove('unread');
            });
            showNotification('Toutes les notifications marquées comme lues', 'success');
            
            // Mettre à jour le badge
            updateNotificationBadge(0);
        }

        function markNotificationAsRead(notificationId) {
            const notificationItem = document.querySelector(`.notification-action[data-notification-id="${notificationId}"]`).closest('.notification-item');
            notificationItem.classList.remove('unread');
            showNotification('Notification marquée comme lue', 'success');
            
            // Mettre à jour le badge
            const unreadCount = document.querySelectorAll('.notification-item.unread').length;
            updateNotificationBadge(unreadCount);
        }

        function deleteNotification(notificationId) {
            const notificationItem = document.querySelector(`.notification-action[data-notification-id="${notificationId}"]`).closest('.notification-item');
            notificationItem.style.opacity = '0';
            setTimeout(() => {
                notificationItem.remove();
                showNotification('Notification supprimée', 'success');
                
                // Mettre à jour le badge
                const unreadCount = document.querySelectorAll('.notification-item.unread').length;
                updateNotificationBadge(unreadCount);
            }, 300);
        }

        function updateNotificationBadge(count) {
            const badges = document.querySelectorAll('.header-badge, .nav-badge, .menu-badge');
            badges.forEach(badge => {
                if (count > 0) {
                    badge.textContent = count;
                    badge.style.display = 'flex';
                } else {
                    badge.style.display = 'none';
                }
            });
        }

        // Mettre à jour les données en temps réel amélioré
        function updateRealTimeData() {
            // Simuler des mises à jour de données
            const now = new Date();
            console.log('Mise à jour des données Sen\'Yone:', now.toLocaleTimeString());
            
            // Mettre à jour les heures d'arrivée (simulation)
            document.querySelectorAll('.arrival-time').forEach((el, index) => {
                if (index % 3 === 0) { // Modifier seulement certains horaires
                    const currentTime = el.textContent;
                    if (currentTime !== '--:--') {
                        const [hours, minutes] = currentTime.split(':');
                        const newMinutes = (parseInt(minutes) + 1) % 60;
                        const newHours = newMinutes === 0 ? (parseInt(hours) + 1) % 24 : hours;
                        el.textContent = `${newHours.toString().padStart(2, '0')}:${newMinutes.toString().padStart(2, '0')}`;
                    }
                }
            });
            
            // Simuler des changements de statut
            document.querySelectorAll('.status-badge').forEach((badge, index) => {
                if (index % 5 === 0 && badge.classList.contains('status-on-time')) {
                    badge.classList.remove('status-on-time');
                    badge.classList.add('status-delayed');
                    badge.textContent = 'Retard 5 min';
                }
            });
        }

        // Afficher les notifications améliorées
        function showNotification(message, type = 'info') {
            const toastContainer = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            let icon = 'info-circle';
            if (type === 'success') icon = 'check-circle';
            else if (type === 'error') icon = 'exclamation-triangle';
            else if (type === 'warning') icon = 'exclamation-circle';
            
            toast.innerHTML = `
                <i class="fas fa-${icon}"></i>
                <span>${message}</span>
            `;
            
            toastContainer.appendChild(toast);
            
            // Supprimer la notification après 3 secondes
            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>