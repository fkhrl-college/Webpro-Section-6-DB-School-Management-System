# Section 6 - DB School Management System

This is my submission for task 6 on web programming for designing CRUD DB School Management System using minimal php, mysql, and bootstrap.

## Get Started With Local Server

0. Prerequisites, make sure you have this installed on your device:
   - XAMPP
   - Laragon
   - Any apache and mysql local server
1. Comment [.htaccess](./src/htaccess) this line:

```htaccess
#RewriteEngine On
```

2. Go to your local server root
3. Clone this repository
<!-- TODO: add script -->
4. Run your apache and mysql local server.
5. Run [database](./init.sql) sql script first for database scheme.
6. Go to your browser and access `seed_admin.php` first then comment [.htaccess](./src/.htaccess) this line:

```htaccess
RewriteEngine On
```

Now you can login using `admin` with password `admin123`

## Get Started With Docker

0. Prerequisites, make sure you have this installed on your device:
   - (Only for windows) install WSL
   - Install Docker Engine and Docker Compose
1. Uncomment [.htaccess](./src/htaccess) this line:

```htaccess
#RewriteEngine On
```

2. First run using:

```bash
docker compose up -d
```

3. Go to browser and access [http://localhost:8080/seed_admin.php](http://localhost:8080/seed_admin.php)
4. Then turn off container:

```bash
docker compose down -v
```

5. Comment [.htaccess](./src/.htaccess) this line:

```htaccess
RewriteEngine On
```

6. Rebuild and run again:

```bash
docker compose up -d
```

Now you can login using `admin` with password `admin123`
