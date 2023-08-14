## API Documentation

This document provides documentation for the API endpoints available in the application.

### .env Configuration

Below is the configuration for the `.env` file in the Laravel application:

```plaintext
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:He+xYMwx19SFNDdFBvYiOA3N4AN/tHbNDwGUwv9IFrE=
APP_DEBUG=true
APP_URL=http://your-url

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

Please make sure to configure the `.env` file with the appropriate values based on your environment and requirements.

### Database
    - Make database based on db configuration on env
    - run ```php artisan migrate``` to create the tables

### Auth Endpoints


#### Register

Registers a new user.

- **URL**: `/api/register`
- **Method**: `POST`
- **Request Body**:
    - `name` (required, string): The name of the user.
    - `email` (required, string): The email address of the user.
    - `password` (required, string): The password of the user.
    - `password_confirmation` (required, string): The confirmation of the password.
- **Response**:
    - `user` (object): The user object containing user details.
    - `access_token` (string): The access token for authentication.
- **Status Codes**:
    - `201`: Successful registration.
    - `422`: Validation error.
    - `500`: Server error.

#### Login

Authenticates a user and returns an access token.

- **URL**: `/api/login`
- **Method**: `POST`
- **Request Body**:
    - `email` (required, string): The email address of the user.
    - `password` (required, string): The password of the user.
- **Response**:
    - `user` (object): The user object containing user details.
    - `access_token` (string): The access token for authentication.
- **Status Codes**:
    - `200`: Successful login.
    - `401`: Invalid credentials.
    - `500`: Server error.

# Movie API Documentation

This documentation provides information about the endpoints and functionality of the Movie API.
### List Movies

Endpoint: `GET /movies`

Retrieves a list of all movies.

#### Response

- `200 OK`

```json
[
  {
    "id": 1,
    "title": "Movie Title",
    "description": "Movie description.",
    "rating": 8.5,
    "image": "image_url",
    "created_at": "2023-08-15T12:34:56Z",
    "updated_at": "2023-08-15T12:34:56Z"
  },
]
```

### Get Movie Details

Endpoint: `GET /movies/{id}`

Retrieves details of a specific movie.

#### Response

- `200 OK`

```json
{
  "id": 1,
  "title": "Movie Title",
  "description": "Movie description.",
  "rating": 8.5,
  "image": "image_url",
  "created_at": "2023-08-15T12:34:56Z",
  "updated_at": "2023-08-15T12:34:56Z"
}
```

- `404 Not Found`

```json
{
  "message": "Movie not found"
}
```

### Add Movie

Endpoint: `POST /movies`

Adds a new movie.

#### Request

```json
{
  "title": "New Movie",
  "description": "A new movie description.",
  "rating": 9.2,
  "image": "base64_encoded_image_data"
}
```

#### Response

- `201 Created`

```json
{
  "id": 2,
  "title": "New Movie",
  "description": "A new movie description.",
  "rating": 9.2,
  "image": "image_url",
  "created_at": "2023-08-15T12:34:56Z",
  "updated_at": "2023-08-15T12:34:56Z"
}
```

- `400 Bad Request`

```json
{
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."]
  }
}
```

### Update Movie

Endpoint: `PUT /movies/{id}`

Updates details of a specific movie.

#### Request

PUT /movies/1

```json

{
  "title": "Updated Movie Title",
  "description": "Updated movie description.",
  "rating": 8.7
}
```

#### Response

- `200 OK`

```json
{
  "id": 1,
  "title": "Updated Movie Title",
  "description": "Updated movie description.",
  "rating": 8.7,
  "image": "image_url",
  "created_at": "2023-08-15T12:34:56Z",
  "updated_at": "2023-08-15T12:34:56Z"
}
```

- `400 Bad Request`

```json
{
  "message": "Validation failed",
  "errors": {
    "rating": ["The rating field must be between 0 and 10."]
  }
}
```

- `404 Not Found`

```json
{
  "message": "Movie not found"
}
```

### Delete Movie

Endpoint: `DELETE /movies/{id}`

Deletes a specific movie.

#### Response

- `200 OK`

```json
{
  "message": "Movie deleted"
}
```

- `404 Not Found`

```json
{
  "message": "Movie not found"
}
```

---

# Unit Tests

Run 

```
    php artisan test
```
---

Note: 
1. All endpoints that require authentication should include the `Authorization` header with the value `Bearer {access_token}`. 
2. The header should include Accept: application/json, or it will be redirected/show error instead of unauthenticated message.

