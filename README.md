# SAMEAPP

GIT
========

git push https://Salesmeet@github.com/Salesmeet/extension-js.git

Overview
========

Scadenza dominio 2023-02-19
AWS

Local domain
===========

Aggiungere all'hosts i seguenti records

127.0.0.1 plugin.sameapp.net
127.0.0.1 api.sameapp.net
127.0.0.1 monitor.sameapp.net

Starting services - Docker
==============================

```
docker-compose up -d
```

Se non è ancora stata creato la networks seguire le indicazioni di docker-compose.

In caso di errore "docker-compose --verbose up"


Avvio siti DEMO

```
docker-compose -f docker-compose-uiex.yml up

o

docker-compose -f docker-compose-salesmeet.yml up
docker-compose -f docker-compose-togetherjs.yml up
docker-compose -f docker-compose-uiex.yml up
```

docker-compose -f docker-compose-uiex-init.yml up

Stoping services
==============================

```
docker-compose stop
```

HTTPS locale
==============================

Installare https://certbot.eff.org

Per il mac la cartella di riferimento è: /etc/letsencrypt/archive/.../

Creare il certificato

```
sudo certbot certonly --manual -d *.sameapp.net
https://devcenter.heroku.com/articles/ssl-certificate-self
```

Spostare il certificato nella cartella di traefik/

Verificare che non crei cert4 o cert5 o certN

```
cd  /traefik
sudo cp /etc/letsencrypt/archive/sameapp.net/cert1.pem cert1.pem
sudo cp /etc/letsencrypt/archive/sameapp.net/chain1.pem chain1.pem
sudo cp /etc/letsencrypt/archive/sameapp.net/fullchain1.pem fullchain1.pem
sudo cp /etc/letsencrypt/archive/sameapp.net/privkey1.pem privkey1.pem

/etc/letsencrypt/live/salesmeet.it/fullchain.pem
Key is saved at:         /etc/letsencrypt/live/salesmeet.it/privkey.pem


Componenti esterni
===========

https://www.tiny.cloud/
corrado@salesmeet.ai


==============================
Compression Tools Javascript
==============================

https://javascript-minifier.com/
o
https://closure-compiler.appspot.com/home

==============================
Install linux
==============================

https://cloudaffaire.com/how-to-install-git-in-aws-ec2-instance/
https://docs.aws.amazon.com/AmazonECS/latest/developerguide/docker-basics.html
https://acloudxpert.com/how-to-install-docker-compose-on-amazon-linux-ami/


sudo snap install docker          # version 19.03.13, or
sudo apt  install docker-compose  # version 1.25.0-1

==============================
PROBLEMA DA RISOLVERE
==============================

docker ps -a

Entrare in questi docker

    docker exec -ti salesmeetdemo_salesmeet-booking_1 bash
    docker exec -ti salesmeetdemo_salesmeet-app_1 bash
    docker exec -ti salesmeetdemo_salesmeet-expert_1 bash
    docker exec -ti salesmeetdemo_salesmeet-profile_1 bash
    docker exec -ti salesmeetdemo_salesmeet-plugin_1 bash

e lanciare i comandi

    apt-get update
    docker-php-ext-install pdo_mysql
    docker-php-ext-install pdo pdo_mysql

restartare servizio


==============================
docker down
==============================

sudo service docker status
sudo systemctl start docker


HTTPS varie
==============================


https://blog.shahednasser.com/how-to-take-screenshots-in-chrome-extension/#:~:text=Go%20to%20chrome%3A%2F%2Fextensions%20again%20and%20reload%20the%20extension,and%20saved%20on%20your%20machine.


Lucio Bonandrini21:39
https://firebase.google.com/docs/web/setup
Lucio Bonandrini21:41
https://github.com/firebase/quickstart-js/blob/master/auth/chromextension/README.md
