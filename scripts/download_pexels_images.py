import requests
import os
from time import sleep

# Configuration de l'API Pexels
headers = {
    'Authorization': 'Uw5RoGZEe8EGh6fuOQzGKrh6sMk5h8zPwTF6AJwGUwzpnUQYs9BwAkKM'
}

# Liste des animaux avec leurs termes de recherche en anglais
animals = {
    'mammiferes': [
        ('lion', 'lion'),
        ('elephant', 'elephant'),
        ('girafe', 'giraffe'),
        ('gorille', 'gorilla'),
        ('dauphin', 'dolphin'),
        ('tigre', 'tiger'),
        ('panda', 'panda'),
        ('kangourou', 'kangaroo'),
        ('koala', 'koala')
    ],
    'oiseaux': [
        ('aigle', 'eagle'),
        ('colibri', 'hummingbird'),
        ('perroquet', 'parrot'),
        ('pingouin', 'penguin'),
        ('paon', 'peacock'),
        ('toucan', 'toucan'),
        ('flamant', 'flamingo'),
        ('chouette', 'owl'),
        ('autruche', 'ostrich')
    ],
    'reptiles': [
        ('cameleon', 'chameleon'),
        ('tortue', 'turtle'),
        ('crocodile', 'crocodile'),
        ('iguane', 'iguana'),
        ('python', 'python snake'),
        ('komodo', 'komodo dragon'),
        ('gecko', 'gecko'),
        ('cobra', 'cobra'),
        ('alligator', 'alligator')
    ],
    'amphibiens': [
        ('grenouille-arc', 'tree frog'),
        ('salamandre', 'salamander'),
        ('axolotl', 'axolotl'),
        ('crapaud-dore', 'toad'),
        ('triton', 'newt'),
        ('dendrobate', 'poison frog'),
        ('grenouille-taureau', 'bullfrog'),
        ('crapaud-geant', 'giant toad'),
        ('salamandre-geante', 'giant salamander')
    ],
    'poissons': [
        ('poisson-clown', 'clownfish'),
        ('requin', 'shark'),
        ('hippocampe', 'seahorse'),
        ('poisson-lune', 'sunfish'),
        ('raie-manta', 'manta ray'),
        ('poisson-chirurgien', 'surgeonfish'),
        ('anguille', 'eel'),
        ('poisson-volant', 'flying fish'),
        ('poisson-archer', 'archerfish')
    ],
    'invertebres': [
        ('papillon', 'butterfly'),
        ('pieuvre', 'octopus'),
        ('crabe-araignee', 'spider crab'),
        ('mante', 'praying mantis'),
        ('scarabee', 'beetle'),
        ('meduse', 'jellyfish'),
        ('araignee-paon', 'peacock spider'),
        ('corail', 'coral'),
        ('ver-luisant', 'firefly')
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
    url = f'https://api.pexels.com/v1/search?query={search_term}&per_page=1'
    
    try:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            data = response.json()
            if data.get('photos'):
                photo = data['photos'][0]
                image_url = photo['src']['large']
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