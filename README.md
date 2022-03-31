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
docker-compose -f docker-compose-plugin.yml up -d
docker-compose -f docker-compose-api.yml up -d
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
Install linux
==============================

https://cloudaffaire.com/how-to-install-git-in-aws-ec2-instance/
https://docs.aws.amazon.com/AmazonECS/latest/developerguide/docker-basics.html
https://acloudxpert.com/how-to-install-docker-compose-on-amazon-linux-ami/



sudo apt install docker          # version 19.03.13, or
sudo apt  install docker-compose  # version 1.25.0-1
sudo chown $USER /var/run/docker.sock

per api
sudo apt install composer

==============================
PROBLEMA DA RISOLVERE
==============================


docker buildx create --use --name larger_log --driver-opt env.BUILDKIT_STEP_LOG_MAX_SIZE=50000000
docker buildx create --driver-opt env.BUILDKIT_STEP_LOG_MAX_SIZE=50000000,env.BUILDKIT_STEP_LOG_MAX_SPEED=100000000 --use


/usr/local/bin/composer update

docker ps -a

Entrare in questi docker

    docker exec -ti extension-js_same-api-slim_1 bash

e lanciare i comandi

    docker-php-ext-install grpc

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
