import pandas as pd
from sqlalchemy import create_engine

# Spécifiez le chemin vers votre fichier CSV
chemin_fichier_csv = 'chemin/vers/votre/fichier/csv'

# Créez une connexion à votre base de données
# Remplacez 'username', 'password', 'localhost', 'port' et 'database' par vos propres informations
engine = create_engine('mysql+pymysql://votre_username:votre_mot_de_passe@localhost:3306/votre_base')

# Lisez le fichier CSV avec pandas
df = pd.read_csv(chemin_fichier_csv)

# Importez les données dans votre base de données
# Remplacez 'nom_table' par le nom de la table dans laquelle vous voulez importer les données
df.to_sql('etudiants', con=engine, if_exists='append', index=False)

