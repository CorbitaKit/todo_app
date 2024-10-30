# Todo App

## Getting Started

Follow these steps to set up the project locally.

### 1. Clone the repository

Clone the project using the following command:
git clone https://github.com/CorbitaKit/todo_app.git

### 2. Navigate to the project directory

Change to the project directory:
cd todo_app

### 3. Set up the environment file

For macOS users, run the following command in the terminal: cp env.example .env
For Windows users, use: copy .env.example .env

### 4. Update the .env file

Open the `.env` file and update the database settings to match your configuration, including changing the database name.

### 5. Generate the application key

Run the following command to generate the application key: php artisan key:generate

### 6. Install PHP dependencies

Run the following command to install PHP dependencies: composer install

### 7. Install Node.js dependencies

After running `composer install`, install Node.js dependencies with: npm install

### 8. Compile assets

Compile the assets by running: npm run dev

### 9. Start the development server

Finally, start the Laravel development server: php artisan serve
