<?php
// Récupération du nom de la ville depuis les arguments de la ligne de commande
if ($argc < 2) {
    echo "Veuillez fournir le nom de la ville.\n";
    exit(1);
}

$ville = $argv[1];

// Chemin vers le fichier CSV
$cheminFichierCSV = 'chemin/vers/votre/fichier/csv';

// Vérification si le fichier CSV existe
if (file_exists($cheminFichierCSV)) {
    // Lecture du fichier CSV
    if (($fichierCSV = fopen($cheminFichierCSV, 'r')) !== FALSE) {
        // Boucle à travers chaque ligne du fichier
        while (($ligne = fgetcsv($fichierCSV)) !== FALSE) {
            // Si la ville correspond à celle recherchée
            if ($ligne[0] == $ville) {
                // Mettre à jour les altitudes dans la base de données
                // Connexion à la base de données
                $serveur = "localhost";
                $utilisateur = "username";
                $motDePasse = "password";
                $baseDeDonnees = "database";

                try {
                    $connexion = new PDO("mysql:host=$serveur;dbname=$baseDeDonnees", $utilisateur, $motDePasse);
                    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    
                    // Mettre à jour les altitudes dans la table "lieux"
                    $requete = $connexion->prepare("UPDATE lieux SET alti_min = ?, alti_max = ? WHERE ville = ?");
                    $requete->execute([$ligne[2], $ligne[3], $ville]);
                    echo "Altitudes mises à jour pour la ville : $ville\n";
                } catch(PDOException $e) {
                    echo "Erreur de connexion à la base de données : " . $e->getMessage();
                }

                // Fermeture du fichier CSV
                fclose($fichierCSV);
                exit(0);
            }
        }
        echo "Altitudes non trouvées pour la ville : $ville\n";
        fclose($fichierCSV);
    } else {
        echo "Erreur lors de l'ouverture du fichier CSV.\n";
    }
} else {
    echo "Le fichier CSV n'existe pas.\n";
}
?>
