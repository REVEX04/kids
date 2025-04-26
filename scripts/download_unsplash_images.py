import requests
import os
from time import sleep

# Configuration de l'API Unsplash
headers = {
    'Authorization': 'NaLVrW1jtnRJllbD-pNK10ZbTXMSQnO8QXXaSqIm1Zo'  # Replace with your access key
}

# Liste des animaux avec leurs termes de recherche en anglais
animals = {
    'mammiferes': [
        ('lion', 'lion wildlife'),
        ('elephant', 'elephant wildlife'),
        ('girafe', 'giraffe wildlife'),
        ('gorille', 'gorilla wildlife'),
        ('dauphin', 'dolphin ocean'),
        ('tigre', 'tiger wildlife'),
        ('panda', 'giant panda'),
        ('kangourou', 'kangaroo wildlife'),
        ('koala', 'koala wildlife')
    ],
    'oiseaux': [
        ('aigle', 'eagle bird'),
        ('colibri', 'hummingbird'),
        ('perroquet', 'colorful parrot'),
        ('pingouin', 'penguin wildlife'),
        ('paon', 'peacock bird'),
        ('toucan', 'toucan bird'),
        ('flamant', 'flamingo bird'),
        ('chouette', 'owl bird'),
        ('autruche', 'ostrich bird')
    ],
    'reptiles': [
        ('cameleon', 'chameleon'),
        ('tortue', 'turtle wildlife'),
        ('crocodile', 'crocodile wildlife'),
        ('iguane', 'iguana reptile'),
        ('python', 'python snake'),
        ('komodo', 'komodo dragon'),
        ('gecko', 'gecko lizard'),
        ('cobra', 'cobra snake'),
        ('alligator', 'alligator wildlife')
    ],
    'amphibiens': [
        ('grenouille-arc', 'tree frog'),
        ('salamandre', 'salamander'),
        ('axolotl', 'axolotl'),
        ('crapaud-dore', 'golden toad'),
        ('triton', 'newt amphibian'),
        ('dendrobate', 'poison dart frog'),
        ('grenouille-taureau', 'bullfrog'),
        ('crapaud-geant', 'giant toad'),
        ('salamandre-geante', 'giant salamander')
    ],
    'poissons': [
        ('poisson-clown', 'clownfish'),
        ('requin', 'shark ocean'),
        ('hippocampe', 'seahorse'),
        ('poisson-lune', 'ocean sunfish'),
        ('raie-manta', 'manta ray'),
        ('poisson-chirurgien', 'surgeonfish'),
        ('anguille', 'moray eel'),
        ('poisson-volant', 'flying fish'),
        ('poisson-archer', 'archerfish')
    ],
    'invertebres': [
        ('papillon', 'butterfly macro'),
        ('pieuvre', 'octopus'),
        ('crabe-araignee', 'spider crab'),
        ('mante', 'praying mantis'),
        ('scarabee', 'beetle macro'),
        ('meduse', 'jellyfish'),
        ('araignee-paon', 'peacock spider'),
        ('corail', 'coral reef'),
        ('ver-luisant', 'firefly night')
    ]
}

# Création du dossier de destination s'il n'existe pas
target_dir = os.path.join(os.path.dirname(os.path.dirname(__file__)), 'public', 'images', 'animaux')
os.makedirs(target_dir, exist_ok=True)

def download_image(url, file_path):
    try:
        response = requests.get(url)
        if response.status_code == 200:
            with open(file_path, 'wb') as f:
                f.write(response.content)
            return True
    except Exception as e:
        print(f"Erreur lors du téléchargement : {str(e)}")
    return False

def search_and_download(file_name, search_term):
    url = f'https://api.unsplash.com/search/photos'
    params = {
        'query': search_term,
        'per_page': 1,
        'orientation': 'landscape'
    }
    
    try:
        response = requests.get(url, headers=headers, params=params)
        if response.status_code == 200:
            data = response.json()
            if data['results']:
                photo = data['results'][0]
                image_url = photo['urls']['regular']
                file_path = os.path.join(target_dir, file_name)
                
                if download_image(image_url, file_path):
                    print(f"✅ Image téléchargée pour : {file_name}")
                    return True
                else:
                    print(f"❌ Erreur lors du téléchargement de l'image pour : {file_name}")
            else:
                print(f"❌ Aucune image trouvée pour : {search_term}")
        else:
            print(f"❌ Erreur API : {response.status_code}")
    except Exception as e:
        print(f"❌ Erreur pour {file_name} : {str(e)}")
    
    return False

# Télécharger les images pour chaque animal
for category, animal_list in animals.items():
    print(f"\n📂 Catégorie : {category}")
    for file_name, search_term in animal_list:
        # Construire le nom du fichier
        file_name = f"{file_name}.jpg"
        
        # Si le fichier existe déjà, passer au suivant
        if os.path.exists(os.path.join(target_dir, file_name)):
            print(f"⏩ Image déjà existante pour : {file_name}")
            continue
        
        # Télécharger l'image
        success = search_and_download(file_name, search_term)
        
        # Attendre un peu entre chaque requête pour respecter les limites de l'API
        sleep(1)

print("\n✨ Téléchargement terminé !") 