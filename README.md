# Template: 📦 Laravel Jetstream shadcn-vue Starter

🛠️ A powerful starter kit for modern web applications, featuring:
• Laravel 10.x
• Jetstream with Inertia.js
• Vue 3
• shadcn-vue components
• Tailwind CSS
• 📱 Mobile-responsive shadcn-vue components
• 🌙 Dark mode support out of the box
• 🔌 Easy-to-use API integration helpers
• 🚀 Performance optimizations for lightning-fast load times
• 🧩 Modular architecture for easy customization
• 🎨 Beautiful UI out of the box
•  ⚡ Rapid development
•  🔒 Built-in authentication

👉 Check it out on GitHub: <https://github.com/hugo-abdou/laravel-jetstream-shadcn-vue-starter>

## Features

-   Laravel 11.9
-   Jetstream with Inertia.js
-   Vue 3 for the frontend
-   shadcn-vue components
-   Tailwind CSS for styling

## Requirements

Make sure you have the following installed on your machine:

-   PHP >= 8.1
-   Composer
-   Node.js >= 16.x
-   npm or yarn

## Installation without Docker:

Follow these steps to get your development environment running:

1. Clone the repository

    ```bash
    git clone https://github.com/hugo-abdou/laravel-jetstream-shadcn-vue-starter.git
    cd your-repo-name
    ```

2. Install PHP dependencies

    ```bash
    composer install
    ```

3. Install NPM dependencies

    ```bash
    npm install
    # or
    yarn install
    ```

4. Create a copy of your .env file

    ```bash
    cp .env.example .env
    ```

5. Generate an app encryption key

    ```bash
    php artisan key:generate
    ```

6. Create an empty database for our application

7. In the .env file, add database information to allow Laravel to connect to the database

8. Migrate the database

    ```bash
    php artisan migrate
    ```

9. Build assets

    ```bash
    npm run dev
    # or
    yarn dev
    ```

10. Run the dev server (the output will give the address)

    ```bash
    php artisan serve
    ```

You're ready to go! Visit the app in your browser, and login with the default credentials.

## Installation with Laravel Sail (Docker) for development:

1. Clone the repository

    ```bash
    git clone https://github.com/hugo-abdou/laravel-jetstream-shadcn-vue-starter.git
    cd your-repo-name
    ```

2. Install PHP dependencies (you will need the correct PHP version in your host)

    ```bash
    composer install
    ```

4. Create a copy of your .env file and configure it

    ```bash
    cp .env.example .env
    ```

5. Start containers

    ```bash
    ./vendor/bin/sail up -d
    ```

6. Execute the migrations

    ```bash
    ./vendor/bin/sail artisan migrate
    ```

7. Install npm dependencies

    ```bash
    ./vendor/bin/sail npm i
    ```

8. Execute the development server

    ```bash
    ./vendor/bin/sail npm run dev
    ```
9. Set the key

    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

You're ready to go! Visit the app in your browser, and login with the default credentials.

## Usage

Explain how to use your project, any important commands, or key features that users should know about.

## Contributing

We welcome contributions to this project. Please feel free to submit a Pull Request.

## License
