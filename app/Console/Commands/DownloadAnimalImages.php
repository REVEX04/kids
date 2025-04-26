<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadAnimalImages extends Command
{
    protected $signature = 'animals:download-images';
    protected $description = 'Télécharge les images des animaux depuis Unsplash';

    private $animals = [
        'lion', 'elephant', 'girafe', 'gorille', 'dauphin', 'tigre', 'panda', 'kangourou', 'koala',
        'aigle', 'colibri', 'perroquet', 'pingouin', 'paon', 'toucan', 'flamant', 'chouette', 'autruche',
        'cameleon', 'tortue', 'crocodile', 'iguane', 'python', 'komodo', 'gecko', 'cobra', 'alligator',
        'grenouille-arc', 'salamandre', 'axolotl', 'crapaud-dore', 'triton', 'dendrobate', 'grenouille-taureau', 'crapaud-geant', 'salamandre-geante',
        'poisson-clown', 'requin', 'hippocampe', 'poisson-lune', 'raie-manta', 'poisson-chirurgien', 'anguille', 'poisson-volant', 'poisson-archer',
        'papillon', 'pieuvre', 'crabe-araignee', 'mante', 'scarabee', 'meduse', 'araignee-paon', 'corail', 'ver-luisant'
    ];

    public function handle()
    {
        $this->info('Début du téléchargement des images...');
        
        if (!Storage::exists('public/images/animaux')) {
            Storage::makeDirectory('public/images/animaux');
        }

        foreach ($this->animals as $animal) {
            $this->info("Téléchargement de l'image pour : $animal");
            
            try {
                // Utilisation de l'API Unsplash (vous devrez ajouter votre clé API)
                $response = Http::get("https://api.unsplash.com/search/photos", [
                    'query' => $animal . ' animal',
                    'per_page' => 1,
                    'client_id' => env('UNSPLASH_ACCESS_KEY')
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (!empty($data['results'])) {
                        $imageUrl = $data['results'][0]['urls']['regular'];
                        $imageContent = Http::get($imageUrl)->body();
                        Storage::put("public/images/animaux/{$animal}.jpg", $imageContent);
                        $this->info("✓ Image téléchargée pour : $animal");
                    }
                }
            } catch (\Exception $e) {
                $this->error("Erreur lors du téléchargement de l'image pour : $animal");
                $this->error($e->getMessage());
            }

            // Attendre 1 seconde entre chaque requête pour respecter les limites de l'API
            sleep(1);
        }

        $this->info('Téléchargement des images terminé !');
    }
} 