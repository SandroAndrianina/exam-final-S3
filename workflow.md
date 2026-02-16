PRINCIPE DE BASE: 
    -La COMMUNICATION : mifampiteny foana raha misy tsy mety
    -TIMING : manaja fotoana, manaja time block

FEEDBACK:
    Badside:
    -brutalite
    -mal communication (quiproco)
    -surestimation du temps 
    -passer trop de temps sur le to do list (savoir les priorites et les prioriser)

    Solutions:
    -brutalite -> s'exprimer avec gentillesse et exprimer sa colere
    -quiproco -> reperer et comprendre le probleme avant de le communiquer

    Goodside:
    -to do list bien organise (repartition des taches detailles)
    -accomplissement des taches a l'heure (respect du "time block") -> toujours avoir un marge de temps pour les imprevues

GITHUB collaboration system:

 MAIN (branche stable)
    ▲
    │
    │ Fusion finale (site 100% fonctionnel)
    │
  DEV (branche d'intégration)
    ▲
    │
    │ Merges pour tester l'ensemble
    ├─────────────────┐
    │                 │
feature/auth    feature/catalogue    feature/paiement
(Dev 1)         (Dev 2)              (Dev 3)
    ▲                 ▲                    ▲
    │                 │                    │
  Code              Code                 Code
  perso             perso                perso

-feature/* : Vous codez en parallèle

-dev : Vous fusionnez pour vérifier que tout marche ensemble (ça peut planter ici)

-main : Ne reçoit que du code testé et validé sur dev (masina be ito, code mandeha ihany no alefa ao)