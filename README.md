1. Please, have [Docker](https://www.docker.com/) installed.
2. On the project root folder run:
```bash
sudo chmod -R 777 storage && sudo chmod -R 777 bootstrap/cache
```
3. It may be necessary do apply [these settings](https://www.civo.com/learn/fixing-networking-for-docker) to avoid connectivity issues.
4. Alter nginx settings in nginx/conf.d/nginx.conf
5. To have self-signed certificate locally you may run the following commands om the project's root folder:
```bash
sudo openssl ecparam -name prime256v1 -genkey -out certs/live/localhost/private_key.pem
```
```bash
sudo openssl req -new -x509 -key certs/live/localhost/private_key.pem -out
certs/live/localhost/certificate.pem -days 365
```

6. To obtain certificate on the prod, please, visit the containter `app_certbot`:
```bash
docker exec -it app_certbot sh
```
Then call:
```bash
certbot certonly \
> -d www.example.com \
> -d example.com
```

When the bot asks the location of webroot, tell: `/etc/webroot/`.

7. Don't forget to alter the nginx conf respectively (see nginx/conf.d/nginx.conf.prod).
