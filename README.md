# Bleiras

Paprasta naujienų valdymo aplikacija sukurta naudojant Laravel, Vue.js ir PrimeVue.

## Technologijos

* PHP 8.4
* Laravel
* Vue 3
* Vite
* PrimeVue
* MySQL
* Docker
* Nginx

## Projekto paleidimas

### 1. Nukopijuoti `.env` failą

```bash
cp .env.example .env
```

### 2. Paleisti Docker konteinerius

```bash
docker compose up -d --build
```

### 3. Įdiegti PHP priklausomybes

```bash
docker compose exec app composer install
```

### 4. Sugeneruoti Laravel aplikacijos raktą

```bash
docker compose exec app php artisan key:generate
```

### 5. Paleisti migracijas ir Seeder

```bash
docker compose exec app php artisan migrate --seed
```

Seeder sukuria administratoriaus vartotoją:

**El. paštas:**

```text
admin@example.com
```

**Slaptažodis:**

```text
password
```

### 6. Sugeneruoti testines naujienas

Norint ištrinti esamas naujienas ir sugeneruoti **100 naujų testinių naujienų**, galima paleisti `NewSeeder`:

```bash
docker compose exec app php artisan db:seed --class=NewSeeder
```

`NewSeeder`:

* ištrina visas esamas naujienas;
* iš naujo sukuria 100 testinių naujienų.

> **Dėmesio:** paleidus šį Seeder, visos tuo metu esančios naujienos bus ištrintos.

### 7. Įdiegti frontend priklausomybes

```bash
npm install
```

### 8. Paleisti Vite

```bash
npm run dev
```

## Aplikacijos atidarymas

Naršyklėje atidarykite:

```text
http://localhost:8080
```

Prisijungimo puslapis:

```text
http://localhost:8080/login
```

## Administravimas

Prisijungus administratoriaus paskyra galima:

* kurti naujienas;
* redaguoti naujienas;
* šalinti naujienas;
* nustatyti publikavimo datą.

Viešą naujienų sąrašą galima peržiūrėti neprisijungus.
