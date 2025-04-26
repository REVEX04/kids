<?php

// Configuration de l'API Unsplash
$headers = [
    'Authorization: Client-ID gGtfp0HpGOpmxMP-3ciOUBqZmEy41zqAMtQib0ENVBQ'
];

// Liste des animaux avec leurs termes de recherche en anglais
$animals = [
    'invertebres' => [
        ['meduse', 'jellyfish underwater'],
        ['araignee-paon', 'peacock spider macro'],
        ['corail', 'coral reef underwater'],
        ['ver-luisant', 'firefly night glow']
    ]
];

// Création du dossier de destination s'il n'existe pas
$target_dir = dirname(__DIR__) . '/public/images/animaux';
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

/**
 * Télécharge une image depuis une URL
 */
function downloadImage($url, $file_path) {
    try {
        $ch = curl_init($url);
        $fp = fopen($file_path, 'wb');
        
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        $success = curl_exec($ch);
        
        curl_close($ch);
        fclose($fp);
        
        return $success;
    } catch (Exception $e) {
        echo "Erreur lors du téléchargement : " . $e->getMessage() . "\n";
        return false;
    }
}

/**
 * Recherche et télécharge une image depuis Unsplash
 */
function searchAndDownload($file_name, $search_term, $headers) {
    $url = 'https://api.unsplash.com/search/photos';
    $params = http_build_query([
        'query' => $search_term,
        'per_page' => 1,
        'orientation' => 'landscape'
    ]);
    
    try {
        $ch = curl_init($url . '?' . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36');
        
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($status_code === 200) {
            $data = json_decode($response, true);
            if (!empty($data['results'])) {
                $photo = $data['results'][0];
                $image_url = $photo['urls']['regular'];
                
                global $target_dir;
                $file_path = $target_dir . '/' . $file_name;
                
                if (downloadImage($image_url, $file_path)) {
                    echo "✅ Image téléchargée pour : $file_name\n";
                    return true;
                } else {
                    echo "❌ Erreur lors du téléchargement de l'image pour : $file_name\n";
                }
            } else {
                echo "❌ Aucune image trouvée pour : $search_term\n";
            }
        } else {
            echo "❌ Erreur API : $status_code (Response: " . $response . ")\n";
        }
        curl_close($ch);
    } catch (Exception $e) {
        echo "❌ Erreur pour $file_name : " . $e->getMessage() . "\n";
    }
    
    return false;
}

// Télécharger les images pour chaque animal
foreach ($animals as $category => $animal_list) {
    echo "\n📂 Catégorie : $category\n";
    foreach ($animal_list as [$file_name, $search_term]) {
        // Construire le nom du fichier
        $file_name .= '.jpg';
        
        // Si le fichier existe déjà, passer au suivant
        if (file_exists($target_dir . '/' . $file_name)) {
            echo "⏩ Image déjà existante pour : $file_name\n";
            continue;
        }
        
        // Télécharger l'image
        searchAndDownload($file_name, $search_term, $headers);
        
        // Attendre un peu entre chaque requête pour respecter les limites de l'API
        sleep(1);
    }
}

echo "\n✨ Téléchargement terminé !\n"; 