<?php

namespace Database\Seeders;

use App\Models\Animeaux;
use Illuminate\Database\Seeder;

class AnimeauxSeeder extends Seeder
{
    public function run(): void
    {
        $animaux = [
            // Mammifères (9)
            [
                'nom' => 'Lion',
                'type' => 'mammifere',
                'espece' => 'Panthera leo',
                'description' => 'Le lion est un grand félin connu comme le "roi des animaux". Les mâles sont reconnaissables à leur imposante crinière.',
                'image_path' => 'images/animaux/lion.jpg',
            ],
            [
                'nom' => 'Éléphant d\'Afrique',
                'type' => 'mammifere',
                'espece' => 'Loxodonta africana',
                'description' => 'Plus grand mammifère terrestre, l\'éléphant d\'Afrique est reconnaissable à ses grandes oreilles et ses défenses en ivoire.',
                'image_path' => 'images/animaux/elephant.jpg',
            ],
            [
                'nom' => 'Girafe',
                'type' => 'mammifere',
                'espece' => 'Giraffa camelopardalis',
                'description' => 'La girafe est l\'animal le plus grand en hauteur. Son long cou lui permet d\'atteindre les feuilles en hauteur.',
                'image_path' => 'images/animaux/girafe.jpg',
            ],
            [
                'nom' => 'Gorille',
                'type' => 'mammifere',
                'espece' => 'Gorilla beringei',
                'description' => 'Le gorille est le plus grand des primates. C\'est un animal intelligent et social qui vit en groupe.',
                'image_path' => 'images/animaux/gorille.jpg',
            ],
            [
                'nom' => 'Dauphin',
                'type' => 'mammifere',
                'espece' => 'Tursiops truncatus',
                'description' => 'Le dauphin est un mammifère marin très intelligent. Il est connu pour sa sociabilité et sa capacité à communiquer.',
                'image_path' => 'images/animaux/dauphin.jpg',
            ],
            [
                'nom' => 'Tigre',
                'type' => 'mammifere',
                'espece' => 'Panthera tigris',
                'description' => 'Le plus grand des félins sauvages. Le tigre est un chasseur solitaire reconnaissable à ses rayures uniques.',
                'image_path' => 'images/animaux/tigre.jpg',
            ],
            [
                'nom' => 'Panda Géant',
                'type' => 'mammifere',
                'espece' => 'Ailuropoda melanoleuca',
                'description' => 'Le panda géant est célèbre pour son pelage noir et blanc. Il se nourrit presque exclusivement de bambou.',
                'image_path' => 'images/animaux/panda.jpg',
            ],
            [
                'nom' => 'Kangourou',
                'type' => 'mammifere',
                'espece' => 'Macropus rufus',
                'description' => 'Le kangourou se déplace en sautant et utilise sa queue pour l\'équilibre. La femelle porte son petit dans sa poche.',
                'image_path' => 'images/animaux/kangourou.jpg',
            ],
            [
                'nom' => 'Koala',
                'type' => 'mammifere',
                'espece' => 'Phascolarctos cinereus',
                'description' => 'Le koala vit dans les arbres et se nourrit presque exclusivement de feuilles d\'eucalyptus. Il dort jusqu\'à 20 heures par jour !',
                'image_path' => 'images/animaux/koala.jpg',
            ],

            // Oiseaux (9)
            [
                'nom' => 'Aigle Royal',
                'type' => 'oiseau',
                'espece' => 'Aquila chrysaetos',
                'description' => 'L\'aigle royal est un rapace majestueux avec une excellente vue. Il peut repérer ses proies à plus d\'un kilomètre.',
                'image_path' => 'images/animaux/aigle.jpg',
            ],
            [
                'nom' => 'Colibri',
                'type' => 'oiseau',
                'espece' => 'Trochilidae',
                'description' => 'Le plus petit oiseau du monde ! Le colibri peut battre des ailes jusqu\'à 80 fois par seconde.',
                'image_path' => 'images/animaux/colibri.jpg',
            ],
            [
                'nom' => 'Perroquet Ara',
                'type' => 'oiseau',
                'espece' => 'Ara macao',
                'description' => 'Le perroquet ara est connu pour ses plumes colorées et sa capacité à imiter la voix humaine.',
                'image_path' => 'images/animaux/perroquet.jpg',
            ],
            [
                'nom' => 'Pingouin Empereur',
                'type' => 'oiseau',
                'espece' => 'Aptenodytes forsteri',
                'description' => 'Le plus grand des pingouins, capable de plonger jusqu\'à 500 mètres de profondeur pour chercher sa nourriture.',
                'image_path' => 'images/animaux/pingouin.jpg',
            ],
            [
                'nom' => 'Paon',
                'type' => 'oiseau',
                'espece' => 'Pavo cristatus',
                'description' => 'Le paon mâle est célèbre pour sa queue spectaculaire qu\'il déploie en éventail pour séduire les femelles.',
                'image_path' => 'images/animaux/paon.jpg',
            ],
            [
                'nom' => 'Toucan',
                'type' => 'oiseau',
                'espece' => 'Ramphastidae',
                'description' => 'Reconnaissable à son grand bec coloré, le toucan vit dans les forêts tropicales d\'Amérique.',
                'image_path' => 'images/animaux/toucan.jpg',
            ],
            [
                'nom' => 'Flamant Rose',
                'type' => 'oiseau',
                'espece' => 'Phoenicopterus roseus',
                'description' => 'Sa couleur rose vient des crevettes qu\'il mange. Il se tient souvent sur une seule patte.',
                'image_path' => 'images/animaux/flamant.jpg',
            ],
            [
                'nom' => 'Chouette',
                'type' => 'oiseau',
                'espece' => 'Strigiformes',
                'description' => 'Oiseau nocturne avec une excellente vision et une capacité à tourner sa tête à 270 degrés.',
                'image_path' => 'images/animaux/chouette.jpg',
            ],
            [
                'nom' => 'Autruche',
                'type' => 'oiseau',
                'espece' => 'Struthio camelus',
                'description' => 'Le plus grand oiseau du monde, incapable de voler mais excellent coureur pouvant atteindre 70 km/h.',
                'image_path' => 'images/animaux/autruche.jpg',
            ],

            // Reptiles (9)
            [
                'nom' => 'Caméléon',
                'type' => 'reptile',
                'espece' => 'Chamaeleonidae',
                'description' => 'Le caméléon peut changer de couleur et bouger ses yeux indépendamment l\'un de l\'autre.',
                'image_path' => 'images/animaux/cameleon.jpg',
            ],
            [
                'nom' => 'Tortue Géante',
                'type' => 'reptile',
                'espece' => 'Chelonoidis niger',
                'description' => 'La tortue géante peut vivre plus de 100 ans. Sa carapace la protège des prédateurs.',
                'image_path' => 'images/animaux/tortue.jpg',
            ],
            [
                'nom' => 'Crocodile du Nil',
                'type' => 'reptile',
                'espece' => 'Crocodylus niloticus',
                'description' => 'Un des plus grands reptiles du monde, excellent nageur et chasseur redoutable.',
                'image_path' => 'images/animaux/crocodile.jpg',
            ],
            [
                'nom' => 'Iguane Vert',
                'type' => 'reptile',
                'espece' => 'Iguana iguana',
                'description' => 'L\'iguane vert est un excellent grimpeur qui peut changer de couleur selon son humeur.',
                'image_path' => 'images/animaux/iguane.jpg',
            ],
            [
                'nom' => 'Python Royal',
                'type' => 'reptile',
                'espece' => 'Python regius',
                'description' => 'Ce serpent non venimeux étouffe ses proies. Il est connu pour sa docilité.',
                'image_path' => 'images/animaux/python.jpg',
            ],
            [
                'nom' => 'Dragon de Komodo',
                'type' => 'reptile',
                'espece' => 'Varanus komodoensis',
                'description' => 'Le plus grand lézard du monde, capable de détecter des odeurs à plusieurs kilomètres.',
                'image_path' => 'images/animaux/komodo.jpg',
            ],
            [
                'nom' => 'Gecko',
                'type' => 'reptile',
                'espece' => 'Gekkonidae',
                'description' => 'Le gecko peut grimper sur presque toutes les surfaces grâce à ses pattes spéciales.',
                'image_path' => 'images/animaux/gecko.jpg',
            ],
            [
                'nom' => 'Cobra Royal',
                'type' => 'reptile',
                'espece' => 'Ophiophagus hannah',
                'description' => 'Le plus long serpent venimeux du monde, capable de se dresser et d\'étendre sa collerette.',
                'image_path' => 'images/animaux/cobra.jpg',
            ],
            [
                'nom' => 'Alligator',
                'type' => 'reptile',
                'espece' => 'Alligator mississippiensis',
                'description' => 'Excellent nageur avec une mâchoire puissante, il peut vivre jusqu\'à 50 ans.',
                'image_path' => 'images/animaux/alligator.jpg',
            ],

            // Amphibiens (9)
            [
                'nom' => 'Grenouille Arc-en-ciel',
                'type' => 'amphibien',
                'espece' => 'Agalychnis callidryas',
                'description' => 'Cette grenouille aux yeux rouges vifs est un véritable arc-en-ciel vivant !',
                'image_path' => 'images/animaux/grenouille-arc.jpg',
            ],
            [
                'nom' => 'Salamandre Tachetée',
                'type' => 'amphibien',
                'espece' => 'Salamandra salamandra',
                'description' => 'Reconnaissable à ses taches jaunes sur fond noir, elle sécrète un venin pour se défendre.',
                'image_path' => 'images/animaux/salamandre.jpg',
            ],
            [
                'nom' => 'Axolotl',
                'type' => 'amphibien',
                'espece' => 'Ambystoma mexicanum',
                'description' => 'Capable de régénérer ses membres, l\'axolotl garde ses branchies toute sa vie.',
                'image_path' => 'images/animaux/axolotl.jpg',
            ],
            [
                'nom' => 'Crapaud Doré',
                'type' => 'amphibien',
                'espece' => 'Incilius periglenes',
                'description' => 'Sa peau brillante orange vif le rend très distinctif.',
                'image_path' => 'images/animaux/crapaud-dore.jpg',
            ],
            [
                'nom' => 'Triton Alpestre',
                'type' => 'amphibien',
                'espece' => 'Ichthyosaura alpestris',
                'description' => 'Ce petit amphibien aux couleurs vives vit dans les lacs de montagne.',
                'image_path' => 'images/animaux/triton.jpg',
            ],
            [
                'nom' => 'Dendrobate',
                'type' => 'amphibien',
                'espece' => 'Dendrobates tinctorius',
                'description' => 'Cette petite grenouille très colorée est l\'une des plus venimeuses au monde.',
                'image_path' => 'images/animaux/dendrobate.jpg',
            ],
            [
                'nom' => 'Grenouille Taureau',
                'type' => 'amphibien',
                'espece' => 'Lithobates catesbeianus',
                'description' => 'La plus grande grenouille d\'Amérique du Nord, avec un coassement qui ressemble à un meuglement.',
                'image_path' => 'images/animaux/grenouille-taureau.jpg',
            ],
            [
                'nom' => 'Crapaud Géant',
                'type' => 'amphibien',
                'espece' => 'Rhinella marina',
                'description' => 'Un des plus grands crapauds du monde, sécrétant un venin puissant pour se défendre.',
                'image_path' => 'images/animaux/crapaud-geant.jpg',
            ],
            [
                'nom' => 'Salamandre Géante',
                'type' => 'amphibien',
                'espece' => 'Andrias japonicus',
                'description' => 'Le plus grand amphibien du monde, pouvant atteindre 1,5 mètre de long.',
                'image_path' => 'images/animaux/salamandre-geante.jpg',
            ],

            // Poissons (9)
            [
                'nom' => 'Poisson-clown',
                'type' => 'poisson',
                'espece' => 'Amphiprioninae',
                'description' => 'Vit en symbiose avec les anémones de mer qui le protègent avec leurs tentacules.',
                'image_path' => 'images/animaux/poisson-clown.jpg',
            ],
            [
                'nom' => 'Requin Blanc',
                'type' => 'poisson',
                'espece' => 'Carcharodon carcharias',
                'description' => 'Le plus grand prédateur des océans, avec des dents qui peuvent mesurer jusqu\'à 7 cm.',
                'image_path' => 'images/animaux/requin.jpg',
            ],
            [
                'nom' => 'Hippocampe',
                'type' => 'poisson',
                'espece' => 'Hippocampus',
                'description' => 'Un poisson unique en forme de cheval, où c\'est le mâle qui porte les bébés.',
                'image_path' => 'images/animaux/hippocampe.jpg',
            ],
            [
                'nom' => 'Poisson-lune',
                'type' => 'poisson',
                'espece' => 'Mola mola',
                'description' => 'Le plus lourd des poissons osseux, avec une forme très particulière.',
                'image_path' => 'images/animaux/poisson-lune.jpg',
            ],
            [
                'nom' => 'Raie Manta',
                'type' => 'poisson',
                'espece' => 'Manta birostris',
                'description' => 'La plus grande raie du monde, elle semble voler sous l\'eau avec ses nageoires.',
                'image_path' => 'images/animaux/raie-manta.jpg',
            ],
            [
                'nom' => 'Poisson-chirurgien',
                'type' => 'poisson',
                'espece' => 'Paracanthurus hepatus',
                'description' => 'Connu pour sa couleur bleue vive et sa capacité à se défendre avec des épines.',
                'image_path' => 'images/animaux/poisson-chirurgien.jpg',
            ],
            [
                'nom' => 'Anguille Électrique',
                'type' => 'poisson',
                'espece' => 'Electrophorus electricus',
                'description' => 'Capable de produire des décharges électriques jusqu\'à 860 volts.',
                'image_path' => 'images/animaux/anguille.jpg',
            ],
            [
                'nom' => 'Poisson Volant',
                'type' => 'poisson',
                'espece' => 'Exocoetidae',
                'description' => 'Peut sauter hors de l\'eau et planer sur plusieurs mètres pour échapper aux prédateurs.',
                'image_path' => 'images/animaux/poisson-volant.jpg',
            ],
            [
                'nom' => 'Poisson-archer',
                'type' => 'poisson',
                'espece' => 'Toxotes jaculatrix',
                'description' => 'Capable de cracher de l\'eau pour faire tomber des insectes dans l\'eau.',
                'image_path' => 'images/animaux/poisson-archer.jpg',
            ],

            // Invertébrés (9)
            [
                'nom' => 'Papillon Monarque',
                'type' => 'invertebré',
                'espece' => 'Danaus plexippus',
                'description' => 'Connu pour sa migration spectaculaire de plus de 4000 km.',
                'image_path' => 'images/animaux/papillon.jpg',
            ],
            [
                'nom' => 'Pieuvre à Anneaux Bleus',
                'type' => 'invertebré',
                'espece' => 'Hapalochlaena',
                'description' => 'Petite mais très venimeuse, reconnaissable à ses anneaux bleus lumineux.',
                'image_path' => 'images/animaux/pieuvre.jpg',
            ],
            [
                'nom' => 'Crabe Araignée Géant',
                'type' => 'invertebré',
                'espece' => 'Macrocheira kaempferi',
                'description' => 'Le plus grand arthropode du monde avec une envergure pouvant atteindre 3,7m.',
                'image_path' => 'images/animaux/crabe-araignee.jpg',
            ],
            [
                'nom' => 'Mante Religieuse Orchidée',
                'type' => 'invertebré',
                'espece' => 'Hymenopus coronatus',
                'description' => 'Ressemble à une fleur d\'orchidée pour attraper ses proies.',
                'image_path' => 'images/animaux/mante.jpg',
            ],
            [
                'nom' => 'Scarabée Atlas',
                'type' => 'invertebré',
                'espece' => 'Chalcosoma atlas',
                'description' => 'Un des plus grands coléoptères du monde avec ses cornes impressionnantes.',
                'image_path' => 'images/animaux/scarabee.jpg',
            ],
            [
                'nom' => 'Méduse Lune',
                'type' => 'invertebré',
                'espece' => 'Aurelia aurita',
                'description' => 'Transparente et bioluminescente, elle pulse doucement dans l\'eau.',
                'image_path' => 'images/animaux/meduse.jpg',
            ],
            [
                'nom' => 'Araignée Paon',
                'type' => 'invertebré',
                'espece' => 'Maratus volans',
                'description' => 'Le mâle fait une danse colorée pour séduire la femelle.',
                'image_path' => 'images/animaux/araignee-paon.jpg',
            ],
            [
                'nom' => 'Corail Corne de Cerf',
                'type' => 'invertebré',
                'espece' => 'Acropora cervicornis',
                'description' => 'Forme des colonies ramifiées qui ressemblent à des bois de cerf.',
                'image_path' => 'images/animaux/corail.jpg',
            ],
            [
                'nom' => 'Ver Luisant',
                'type' => 'invertebré',
                'espece' => 'Lampyris noctiluca',
                'description' => 'Capable de produire de la lumière par bioluminescence.',
                'image_path' => 'images/animaux/ver-luisant.jpg',
            ],
        ];

        foreach ($animaux as $animal) {
            Animeaux::create($animal);
        }
    }
} 