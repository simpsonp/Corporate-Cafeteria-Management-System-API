# Corporate Cafeteria Management System API

This repository contains a Laravel PHP implementation of the **Corporate Cafeteria Management System** API. The primary purpose of this project is to expose data from an existing corporate cafeteria management web application via APIs, enabling integration with a new mobile app.

## Project Overview

The existing system, built with vanilla PHP, is outdated and not compatible with modern development standards. This project uses the latest Laravel framework to create a more generic, demo-friendly version of the system's API.  
**Note**: The code in this repository is not directly compatible with the original system, which remains confidential.

## Features

-   **Meal Type Management**: Endpoints to fetch meal types and their schedules.
-   **Menu Management**: Endpoints to retrieve weekly menus.
-   **User Management**: Endpoint to get details of the currently logged-in user.
-   **Authentication**: Supports both basic and token-based authentication.

## Requirements

-   Docker
-   PHP 8.3 or higher

## Setup

### Clone the Repository

```bash
git clone <repository-url>
cd <repository-directory>
```

### Configure Environment

Rename `.env.docker` to `.env` and adjust the settings as needed. Key settings to check:

-   **APP_ENV**: Should be set to `docker`.
-   **APP_SERVICE**: Docker service name, usually `app`.
-   **DB_CONNECTION**: Set to `mariadb` with appropriate host, port, and credentials.
-   **MAIL_FROM_ADDRESS** and **MAIL_FROM_NAME**: Adjust for your environment.
-   **CACHE_DRIVER**: Set to `array` in non-production environments.

### Install dependencies

    ```bash
    sail composer install
    ```

### Start the development environment

    ```bash
    sail up -d
    ```

### Run migrations

    ```bash
    sail artisan migrate
    ```

### Seed the database

    ```bash
    sail artisan db:seed
    ```

## API Endpoints

### User

-   **POST /api/users/tokens**: Generate and return a new authentication token.
-   **GET /api/user**: Fetch the profile details of the currently authenticated user.

### Meal Types

-   **GET /api/meals/types**: Retrieve all meal types with their schedules.

### Menus

-   **GET /api/menus**: Retrieve menus for the upcoming week.

## Middleware

-   **BasicOrTokenAuth**: Allows authentication via either basic auth or API token.
-   **AuthenticateOnceWithBasicAuth**: Ensures basic authentication is used once.

## Development

### Dev Container Configuration

Configured to use Docker and VSCode Dev Containers for a consistent development environment. Adjust `devcontainer.json` if necessary.

### Common Issues

-   **Permissions**: Ensure correct permissions by modifying the `postCreateCommand` in `devcontainer.json` if needed.

### Testing

For running tests, use:

```bash
sail artisan test
```

## Future Enhancements

-   **Cross-Platform Mobile App**: Development of a mobile application to interact seamlessly with this API, ensuring compatibility across various platforms.
-   **New Web Application**: Creation of a modern web application tailored for this API, replacing the outdated system currently in use.
-   **Extended API Functionality**: Expansion of the API to include write capabilities, allowing data modification. This will include implementing role-based access control and other security features.

## License

This project is licensed under the MIT License.
