Ready-Arena
Projet de fin d'étude formation Web

Ready-Arena est une plateforme de création de tournois non-officiel pour une selection de jeux en ligne. Ce projet regroupe également des fonctionnalités telles que la création d'équipes, un classement interne des utilisateurs et bientôt la possibilité de créer des fammilles regroupant plusieurs équipes. Chaque utilisateur s'étant inscrit à un tournois gagne des points en fonction de son classement à ce dernier. Les tournois peuvent être de différents format allant de trente-deux à huit joueurs (ou équipes). Du côté des équipes des invitations peuvent être envoyés aux utilisateurs non-inscrit et inversement un utilisateur non-inscrit peut faire une demande d'inscription aux dîtes équipes. Un utilisateur à la possibilité d'afficher les jeux sur lesquels il souhaite trouver une équipe sur sa page de profil.

La suite de ce fichier explicatif comporte des notions techniques à l'attention des examinateurs.

l'éxistence d'un "faux" profil (falseUserRank0) est nécessaire au bon déroulement du classement de tout nouvel utilisateur.

Dans de nombreux cas ( liste des participants aux tournois, déroulement des rounds, liste des équipiers dans une équipe ... ) la non-utilisation de la notion d'"INNER JOIN" à été une erreur. Cependant il m'aurait été trop fastidieux de revenir sur mon modèle de développement après en avoir pris conscience.

il est important de noter que pour effectuer les tests du déroulement d'un tournoi la date de ce dernier doit être calibrée sur une date anterieur à celle du jour de connexion.

profil test : - email : MegaTornade@gmail.com
              - mot de passe : popoMOMO99
