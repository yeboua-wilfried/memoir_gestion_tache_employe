<?php
while (true) {
    echo "[" . date('Y-m-d H:i:s') . "] Exécution du schedule...\n";
    exec('php artisan schedule:run');
    sleep(60); // Attendre 60 secondes
}

//php artisan schedule:work
