<?php

require __DIR__ . '/../vendor/autoload.php';

use Unsplash\HttpClient;
use Unsplash\Search;

// Configuration de l'API Unsplash
HttpClient::init([
    'applicationId' => 'q9N3q0ZF5fYKynzGK5z4gb8JiL3GQWokJuLm9zqCEVg',
    'utmSource' => 'Kids Learning App'
]);

// Liste des animaux dont nous avons besoin des images
$animals = [
    'lion', 'elephant', 'girafe', 'gorille', 'dauphin', 'tigre', 'panda', 'kangourou', 'koala',
    'aigle', 'colibri', 'perroquet', 'pingouin', 'paon', 'toucan', 'flamant', 'chouette', 'autruche',
    'cameleon', 'tortue', 'crocodile', 'iguane', 'python', 'komodo', 'gecko', 'cobra', 'alligator',
    'grenouille-arc', 'salamandre', 'axolotl', 'crapaud-dore', 'triton', 'dendrobate', 
    'grenouille-taureau', 'crapaud-geant', 'salamandre-geante',
    'poisson-clown', 'requin', 'hippocampe', 'poisson-lune', 'raie-manta', 'poisson-chirurgien',
    'anguille', 'poisson-volant', 'poisson-archer',
    'papillon', 'pieuvre', 'crabe-araignee', 'mante', 'scarabee', 'meduse', 'araignee-paon',
    'corail', 'ver-luisant'
];

// Dossier de destination
$targetDir = __DIR__ . '/../public/images/animaux/';

// Créer le dossier s'il n'existe pas
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Télécharger les images pour chaque animal
foreach ($animals as $animal) {
    try {
        // Rechercher une image
        $search = Search::photos($animal, 1);
        $results = $search->getResults();

        if (count($results) > 0) {
            $photo = $results[0];
            $imageUrl = $photo->urls['regular'];
            
            // Télécharger l'image
            $imageContent = file_get_contents($imageUrl);
            $targetPath = $targetDir . $animal . '.jpg';
            
            if (file_put_contents($targetPath, $imageContent)) {
                echo "Image téléchargée pour : $animal\n";
            } else {
                echo "Erreur lors du téléchargement de l'image pour : $animal\n";
            }
        } else {
            echo "Aucune image trouvée pour : $animal\n";
        }
        
        // Attendre un peu pour respecter les limites de l'API
        sleep(1);
    } catch (Exception $e) {
        echo "Erreur pour $animal : " . $e->getMessage() . "\n";
    }
}

echo "Téléchargement terminé !\n"; 