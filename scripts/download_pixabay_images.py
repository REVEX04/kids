import requests
import os
from time import sleep

# Configuration de l'API Pixabay
API_KEY = '40751211-c8e70f0c0d9a2f7a4d0a6e22f'  # Clé API gratuite de Pixabay
BASE_URL = 'https://pixabay.com/api/'

# Liste des animaux
animals = {
    'mammiferes': ['lion', 'elephant', 'girafe', 'gorille', 'dauphin', 'tigre', 'panda', 'kangourou', 'koala'],
    'oiseaux': ['aigle', 'colibri', 'perroquet', 'pingouin', 'paon', 'toucan', 'flamant', 'chouette', 'autruche'],
    'reptiles': ['cameleon', 'tortue', 'crocodile', 'iguane', 'python', 'komodo', 'gecko', 'cobra', 'alligator'],
    'amphibiens': ['grenouille-arc', 'salamandre', 'axolotl', 'crapaud-dore', 'triton', 'dendrobate', 
                   'grenouille-taureau', 'crapaud-geant', 'salamandre-geante'],
    'poissons': ['poisson-clown', 'requin', 'hippocampe', 'poisson-lune', 'raie-manta', 'poisson-chirurgien',
                 'anguille', 'poisson-volant', 'poisson-archer'],
    'invertebres': ['papillon', 'pieuvre', 'crabe-araignee', 'mante', 'scarabee', 'meduse', 'araignee-paon',
                    'corail', 'ver-luisant']
}

# Création du dossier de destination s'il n'existe pas
target_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'public', 'images', 'animaux')
os.makedirs(target_dir, exist_ok=True)

def search_and_download(animal_name, file_name):
    # Remplacer les tirets par des espaces pour la recherche
    search_term = animal_name.replace('-', ' ')
    
    # Paramètres de recherche
    params = {
        'key': API_KEY,
        'q': search_term,
        'image_type': 'photo',
        'orientation': 'horizontal',
        'safesearch': 'true',
        'per_page': 3
    }
    
    try:
        # Faire la requête à l'API
        response = requests.get(BASE_URL, params=params)
        data = response.json()
        
        if data['hits']:
            # Prendre la première image
            image_url = data['hits'][0]['largeImageURL']
            
            # Télécharger l'image
            image_response = requests.get(image_url)
            if image_response.status_code == 200:
                # Sauvegarder l'image
                file_path = os.path.join(target_dir, file_name)
                with open(file_path, 'wb') as f:
                    f.write(image_response.content)
                print(f"✅ Image téléchargée pour : {animal_name}")
                return True
            else:
                print(f"❌ Erreur lors du téléchargement de l'image pour : {animal_name}")
        else:
            print(f"❌ Aucune image trouvée pour : {animal_name}")
    except Exception as e:
        print(f"❌ Erreur pour {animal_name} : {str(e)}")
    
    return False

# Télécharger les images pour chaque animal
for category, animal_list in animals.items():
    print(f"\n📂 Catégorie : {category}")
    for animal in animal_list:
        # Construire le nom du fichier
        file_name = f"{animal}.jpg"
        
        # Si le fichier existe déjà, passer au suivant
        if os.path.exists(os.path.join(target_dir, file_name)):
            print(f"⏩ Image déjà existante pour : {animal}")
            continue
        
        # Télécharger l'image
        success = search_and_download(animal, file_name)
        
        # Attendre un peu entre chaque requête pour respecter les limites de l'API
        sleep(0.5)

print("\n✨ Téléchargement terminé !") 