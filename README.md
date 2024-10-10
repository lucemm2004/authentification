# authentification
# le point d'entrée est login.html ou register.html
# il était demandé dans l'énoncé de pratiquer les cookies, j'ai supposé que c'était pour gérer, se souvenir de moi. Je l'ai fait de manière ultra simple, sans jeton de sécurité vu qu'il n'était pas prévu dans la table des users.
# le bypass de login si existence du cookie remember, se trouve au tout début de login.php. On ne devrait avoir qu'un seul fichier login, login.php, et tout le bloc html après le bloc php.
# quand on fait le logout, je supprime le cookie
