1. Please, have [Docker](https://www.docker.com/) installed.
2. On the project root folder run:
```bash
sudo chmod -R 777 storage && sudo chmod -R 777 bootstrap/cache
```
3. It may be necessary do apply [these settings](https://www.civo.com/learn/fixing-networking-for-docker) to avoid connectivity issues.
4. Use `docker compose up -d --build` on the root folder to run the app
5. Use `composer run dev` on the root folder

