# bunq-chat

Simple chat backend example (Slim + SQLite).

Purpose
-------
This project implements a minimal chat backend with the following features:

- Create users
- Create public groups and join them
- Send messages in groups and list group messages
- Layered architecture: Controllers → Services → Repositories → Models
- Persistent storage using SQLite
- Unit and integration tests with PHPUnit

Prerequisites
-------------
- PHP 8.1+ (development used PHP 8.5)
- Composer

Quick setup (local development)
-------------------------------
1. Install dependencies

```bash
composer install
```

2. Initialize database

Create `database/schema.sql` with the following content and apply it to create `database/chat.db`:

```sql
CREATE TABLE users (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	username TEXT UNIQUE
);

CREATE TABLE groups (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	name TEXT
);

CREATE TABLE group_members (
	group_id INTEGER,
	# bunq-chat

	Minimal chat backend example (Slim + SQLite).

	Overview
	--------
	Small example backend illustrating a layered PHP app (Controllers → Services → Repositories → Models).

	Quickstart
	----------
	Requirements:

	- PHP 8.1+
	- Composer

	1. Install dependencies

	```bash
	composer install
	```

	2. Prepare the database

	Schema file is included as `database/schema.sql`. To (re)create the DB:

	```bash
	mkdir -p database
	sqlite3 database/chat.db < database/schema.sql
	```

	Note: the local DB was reset for a clean history. A backup `database/chat.db.bak` exists if you need it.

	3. Start the server

	```bash
	php -S localhost:8080 -t public
	```

	Open API docs:

	http://localhost:8080/docs

	Common endpoints
	----------------
	- Create user: POST /users  { "username": "alice" }
	- Get all users: GET /getAllUsers
	- Create group: POST /groups  { "name": "team-a" }
	- Join group: POST /groups/{id}/join  { "user_id": "1" }
	- Send message: POST /groups/{id}/messages  { "user_id": "1", "message": "hello" }
	- List messages: GET /groups/{id}/messages

	Tests
	-----

	Run tests with:

	```bash
	vendor/bin/phpunit
	```

	License
	-------
	Unlicensed example code — adapt as you wish.

