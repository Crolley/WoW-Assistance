1 . Installer les dépendance 
    
    composer install

2 . Créer le .env

    DATABASE_URL="postgresql://user:password@127.0.0.1:5433/nom_bdd"

3 . Créer la bdd 

    php bin/console doctrine:database:create
    php bin/console doctrine:migrations:migrate

4. Charger des données de test 

    php bin/console doctrine:fixtures:load

5 . Lancer le serveur 

    symfony server:start

La création de User est possible sinon il y à déjà des données de test

   Username : Jaina@wow.com
   Password : magepass