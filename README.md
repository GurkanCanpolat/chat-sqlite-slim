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
	user_id INTEGER,
	UNIQUE(group_id, user_id)
);

CREATE TABLE messages (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	group_id INTEGER,
	user_id INTEGER,
	message TEXT,
	created_at TEXT
);
```

To apply:

```bash
mkdir -p database
sqlite3 database/chat.db < database/schema.sql
```

3. Start the server

```bash
php -S localhost:8080 -t public
```

The server will be available at http://localhost:8080

API examples
------------

Create user

POST /users
Content-Type: application/json

Body: { "username": "alice" }

Create group

POST /groups
Content-Type: application/json

Body: { "name": "team-a" }

Join group

POST /groups/{id}/join
Content-Type: application/json

Body: { "user_id": 1 }

Send message

POST /groups/{id}/messages
Content-Type: application/json

Body: { "user_id": "1", "message": "hello" }

List messages

GET /groups/{id}/messages

Tests
-----

Run the test suite:

```bash
vendor/bin/phpunit
```

