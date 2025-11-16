# Knott - Full-Stack Wedding Planning Application

Knott is a comprehensive wedding planning application built with Laravel for the backend and React for the frontend. It helps couples manage various aspects of their wedding, including vendor management, budget tracking, guest lists, gift wells, and more.

## Technologies Used

### Backend
- **Laravel**: A powerful PHP framework for building robust web applications.

### Frontend
- **React**: A JavaScript library for building user interfaces.
- **Vite**: A fast frontend build tool.
- **TypeScript**: A typed superset of JavaScript that compiles to plain JavaScript.
- **Tailwind CSS**: A utility-first CSS framework for rapidly building custom designs.
- **React Leaflet**: React components for Leaflet maps.

## Features

- **Vendor Management**: Discover and manage wedding vendors.
- **Quote Requests**: Request and compare quotes from multiple vendors.
- **Budget Tracking**: Keep track of wedding expenses and categories.
- **Guest List Management**: Manage wedding guests and RSVPs.
- **Wedding To-Do List**: Organize tasks and milestones.
- **Gift Well**: Allow guests to contribute to a gift fund.
- **AI Vendor Matching**: (Potentially) Intelligent matching of vendors to couple's needs.
- **Competitions**: Engage users with wedding-related competitions.

## Setup Instructions

To get the project up and running on your local machine, follow these steps:

### 1. Clone the Repository

```bash
git clone https://github.com/Mhlave2402/knott.git
cd knott
```

### 2. Backend Setup (Laravel)

1.  **Install Composer Dependencies**:
    ```bash
    composer install
    ```

2.  **Copy Environment File**:
    ```bash
    cp .env.example .env
    ```

3.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```

4.  **Create SQLite Database (if using SQLite)**:
    ```bash
    touch database/database.sqlite
    ```
    Ensure your `.env` file is configured to use `sqlite` for `DB_CONNECTION`.

5.  **Run Migrations and Seeders**:
    ```bash
    php artisan migrate --seed
    ```

6.  **Start Laravel Development Server**:
    ```bash
    php artisan serve
    ```

### 3. Frontend Setup (React)

1.  **Install Node.js Dependencies**:
    ```bash
    npm install --force
    ```
    (The `--force` flag is used to bypass peer dependency conflicts, which may occur with `react-leaflet` and React 18. This might lead to unexpected behavior, but it's a common first step to get the dependencies installed.)

2.  **Start Vite Development Server**:
    ```bash
    npm run dev
    ```

### 4. Access the Application

-   **Backend API**: The Laravel backend will be accessible at `http://127.0.0.1:8000` (or whatever `php artisan serve` outputs).
-   **Frontend Application**: The React frontend will be accessible at `http://localhost:5173` (or whatever `npm run dev` outputs).

You should now be able to access the Knott application in your browser.

## Contributing

Contributions are welcome! Please feel free to fork the repository, make your changes, and submit a pull request.

## License

The Knott application is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
