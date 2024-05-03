# Residential Mapping of Personnel

 ![website](https://i.imgur.com/jLAlTvS.png)

 # Description

This web application allows you to find the minimum and maximum altitude
of a student's city via a form.

Beforehand, you can run a program that will load the altitudes of cities
present in your "students" table from a database called "base.csv" containing
the minimum and maximum altitudes of numerous cities.

Upon submission of the search form, a program first retrieves the city associated
with the student in the "students" table. Using the city, it then retrieves
its altitudes from the "locations" table. If it is not found there, another
program will be executed, which updates the "locations" table by fetching
the altitude from the .csv database.

# Installation

Dependencies:

I recommend creating a virtual Python environment

```bash
python -m venv venv               # create the environment
source venv/bin/activate          # activate the environment

# you can then install the dependencies
pip install -r requirements.txt

```

# Configuration

list_to_data_base.py 

```python
# Specify the path to your CSV file
csv_file_path = 'path/to/your/csv/file'

# Replace 'username', 'password', 'localhost', 'port', and 'database' with your own information
engine = create_engine('mysql+pymysql://username:password@localhost:port/database')

```
ville_to_lieux.py

```python

# Replace 'localhost', 'username', 'password', and 'database' with your own information

connection = pymysql.connect(
    host='localhost',
    user='username',
    password='password',
    database='database'
)

```

rechercher_etudiants.php

```php

// Replace 'localhost', 'username', 'password', and 'database' with your own information

$server = "localhost";
$user = "username";
$password = "password";
$database = "sae23";

```


maj_altitudes.php

```php
// Path to the CSV file
$csvFilePath = 'path/to/your/csv/file';

// Replace 'localhost', 'username', 'password', and 'database' with your own information

$server = "localhost";
$user = "username";
$password = "password";
$database = "database";

```

# Files

```bash
index.html                    # Page web formulaire de recherche
list_to_data_base.py          # Programme d'importation des étudiants
ville_to_lieux.py             # Programme d'importation des villes
maj_altitudes.php             # Programme de mise à jour des altitudes dans la table lieux
rechercher_etudiants.php      # Programme de recherche d'informations sur un étudiant
```
