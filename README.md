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

Pour une mise à jour :
"cd /usr/local/src/Bot_Base && sudo git pull && sudo bash updateBot.sh"
