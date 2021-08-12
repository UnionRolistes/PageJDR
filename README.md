# Web_Planning : Formulaire de création de partie

Le formulaire permet a un animateur (MJ) de proposer une session de JdR sur un serveur discord.
Via la commande $jdr, il recoit un lien vers un formulaire, avec diverses entrées.
Une fois le formulaire completé et validé, celui ci est envoyé vers le discord, et l'annonce mise en forme est alors disponible sur le discord dans le canal #planning-jdr, les joueurs potentiels peuvent alors lire et réagir pour s'y inscrire.
Ensuite le MJ peut les contacter pour les informations supplémentaires, telles que la creation de personnage.


# Web_Planning : Calendrier
Calendrier web affichant les parties prévues.
Via la commande $cal l'utilisateur reçoit le lien du calendrier Ce calendrier affiche horizontalement les parties prévues, par semaine ou par mois. 
Cliquer sur un événement donnera accès à plus de détails sur la partie, ainsi qu'un lien vers le message discord pour pouvoir s'y inscrire.
Les administrateurs ont accès à une section permettant de pré remplir le formulaire avec les données d'une partie déjà existante, afin de la dupliquer.
Ils peuvent aussi afficher tous les détails d'une partie selon une mise en forme leur permettant de copier facilement le texte pour une exportation sur les réseaux sociaux


# Installation
Pour une 1ère installation : 
"cd /usr/local/src && sudo git clone https://github.com/UnionRolistes/Bot_Base && cd Bot_Base && sudo bash updateBot.sh"
sudo nano /var/www/html/Web_Planning/php/config.php.default" --> Remplir ce fichier avec le Client ID, Secret ID et Redirect_URI du Bot, trouvable sur Discord developer (https://discord.com/developers/applications)

sudo nano /etc/apache2/sites-available/100-UR_Planning.conf --> Remplacer "serverName planning.unionrolistes.fr" (ligne 9) par la redirection saisie sur votre hébergeur en ligne


Pour une mise à jour :
"cd /usr/local/src/Bot_Base && sudo git checkout . && sudo git pull && sudo bash updateBot.sh"


# Section ADMIN : Web_Planning/Calendar/ADMIN/index.php
Identifiants par défaut :
default default

Pour changer les identifiants ADMIN --> Web_Planning/Calendar/ADMIN/modules/crypt.php
1) Rentrez le login et mot de passe voulu. Le script vous retournera alors les identifiants cryptés.
2) Copiez les dans /var/www/html/Web_Planning/Calendar/ADMIN/.htpasswd, sur une nouvelle ligne. Vous pouvez maintenant supprimer la ligne commencant par "default" afin d'oublier les identifiants par défaut
!! Retenez bien votre mot de passe car il n'y a aucun moyen de le retrouver, à part d'en créer un autre. Si cela vous arrivait, déplacez le fichier Web_Planning/Calendar/ADMIN/modules/crypt.php vers Web_Planning/Calendar/crypt.php par exemple (pour le sortir de la zone Admin protégée), puis créez un nouveau mot de passe via la page Web_Planning/Calendar/crypt.php

NOTE : Vous pouvez avoir plusieurs identifiants différents, en les mettant chacun sur une ligne. Mais il ne peut pas y avoir plusieurs login identiques.

La section administrateur permet de pré remplir le formulaire à partir d'une partie choisie, afin de faciliter sa duplication, ainsi que d'accéder à la mise en forme d'une partie facilitant l'exportation Facebook via un copié-collé
