import pandas as pd
import pymysql

# Connexion à la base de données MySQL
connexion = pymysql.connect(
    host='localhost',
    user='votre_username',
    password='votre_mot_de_passe',
    database='votre_base'
)

# Créer un curseur pour exécuter des requêtes SQL
curseur = connexion.cursor()

# Récupérer les villes présentes dans les colonnes "adresse_principal" et "adresse_secondaire" de la table "etudiants"
curseur.execute("SELECT DISTINCT adresse_principal FROM etudiants")
villes_principales = [row[0] for row in curseur.fetchall()]

curseur.execute("SELECT DISTINCT adresse_secondaire FROM etudiants")
villes_secondaires = [row[0] for row in curseur.fetchall()]

# Fermer le curseur
curseur.close()

# Fermer la connexion
connexion.close()

# Combiner les listes de villes principales et secondaires
villes_etudiants = villes_principales + villes_secondaires

# Charger les données CSV
df = pd.read_csv("altitude_villes.csv")

# Parcourir les lignes du DataFrame
for index, row in df.iterrows():
    # Récupérer les valeurs de la colonne "ville" et "code_postal"
    ville = row["ville"]
    code_postal = row["code_postal"]
    
    # Vérifier si la ville est présente dans la liste des villes des étudiants
    if ville in villes_etudiants:
        # Connexion à la base de données MySQL
        connexion = pymysql.connect(
            host='localhost',
            user='votre_username',
            password='votre_mot_de_passe',
            database='votre_base'
        )

        # Créer un curseur pour exécuter des requêtes SQL
        curseur = connexion.cursor()

        # Insérer les valeurs dans la table "lieux" de la base de données "sae23"
        # Notez que vous devrez adapter cette requête en fonction de votre schéma de base de données
        curseur.execute("INSERT INTO lieux (ville, code_postal) VALUES (%s, %s)", (ville, code_postal))

        # Valider les modifications dans la base de données
        connexion.commit()

        # Fermer le curseur et la connexion
        curseur.close()
        connexion.close()

print("Les données ont été insérées avec succès dans la base de données.")
