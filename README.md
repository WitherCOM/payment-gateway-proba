# Payment Gateway Próba feladat
Készíts egy olyan REST vagy GraphQL API-t, ami alkalmas az alábbi entitások létrehozására, módosítására és törlésére, valamint azok listázására úgy, hogy a lista léptethető és a kötelező paraméterek alapján rendezhető legyen.


User entitás:

id - mentéskor generálódik

name

email

dateOfBirth

isActive

createdAt - létrehozás időpontja

updatedAt - módosítás időpontja (auto update)



User telefonszám entitás reláció:

user_id

phoneNumber

	

Egy felhasználóhoz kötelezően egy, de nem több, alapértelmezett(isDefault) telefonszám tartozhat. A felhasználó telefonszáma csak magyar telefonszám lehet.


Létrehozáskor kötelező paraméterek:

name

email

phoneNumber

dateOfBirth

isActive



A feladatot PHP7 vagy PHP8 nyelven kell megoldani, Laravel keretrendszer használatával. Különböző külső könyvtárak használata megengedett. 


Az elkészült feladat Docker-compose-ból vezérelve Docker-ben fusson, valamint lehetőleg tesztek is készüljenek hozzá. Az adatok perzisztálására PostgresQL-t használj, ami szintén a Docker-ben van.

# Docker compose setuphoz

Elindítja a konténereket
```bash
docker-compose up
```
Az első indítást követően installálni kell a composer-el a packageket és jogosultságokat kell adni a php-fpm-nek hogy tudja szerkeszteni, illetve olvasni a laravel projekt fáljait.
```bash
docker exec payment-gateway-proba_php_1 composer install -d /srv/http
docker exec payment-gateway-proba_php_1 chown <userid>:www-data -R /srv/http
docker exec payment-gateway-proba_php_1 chown www-data:www-data -R /srv/http/storage
```
# Környezeti változók beállítása
Alapjáraton a ```.env``` fájl nincs feltöltve, csak a ```.env.example```. Erről másolatot csinálva kell létrehozni a laravel-hez a ```.env``` fájlt.
```
cp .env.example .env
```
A fájlban az adatbázis eléréséhez kell kitölteni a megfelelő sorokat:
```
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=paymentgateway
DB_USERNAME=paymentgateway
DB_PASSWORD=payment
```
Az adatbázis felhasználónevét és a jelszavát vagy a Postgres konténerbe belépve vagy a ```docker-compose.yml``` fájlban lehet beállítani. Az utóbbi lépéssel automatikusan létrejön egy felhasználó azonos nevű adatbázissal, ha nem akarunk más adatbázist létrehozni ebben akkor ezt érdemes használni. Ehhez a ```docker-compose.yml``` fájlban a következő sorokat kell módosítani
```yaml
    environment:
      POSTGRES_PASSWORD: payment
      POSTGRES_USER: paymentgateway
```
# Migráció futtatás
Ahhoz, hogy az adatbázisban létrejöjjenek a megfelelő táblák le kell futatni egy migrációt.
```bash
docker exec payment-gateway-proba_php_1 php \srv\http\artisan migrate
```
 Ezek után meg fut is az api, a 80-as porton "hallgatózik.
 # API
 Négy metódust definiáltam
 <ul>
    <li>GET ("basepath"/api/v1/user) , itt az order query parameter segítségével meglehet adni az rendezési szempontot, valamint a page query parameterrel lehet lapozni</li>
    <li>POST ("basepath"/api/v1/user) itt form-data ként elküldve a kötelező adatokat létre lehet hozni egy új user-t</li>
    <li>PUT ("basepath"/api/v1/user/{id}) Itt kiválasztva a megfelelő id-ú user-t lehet módosítani úgy, hogy a módosítani kivánt adatot form-data ként küldjük. </li>
    <li>DELETE ("basepath"/api/v1/user/{id}) a megfelelő userid alapján lehet törölni a kivánt user-t</li>
 </ul>