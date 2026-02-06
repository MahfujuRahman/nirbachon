# Nirbachon - Voting Management System

A comprehensive Laravel-based voting management system with separate admin and agent panels, featuring live result tracking and responsive design.

## Features

### Admin Panel
- **Dashboard**: Overview of system statistics
- **Ashon Management**: Create and manage election events
- **Centar Management**: 
  - Manual creation of voting centers
  - Bulk import via CSV/Excel files
- **Marka Management**: 
  - Create political parties/candidates
  - Upload symbols (automatically resized to 200x200px)
- **Agent Management**: Create and manage agent accounts

### Agent Panel
- **Result Upload**: Submit voting results with multiple images
- **Result Management**: Edit and update submitted results
- **Image Gallery**: Manage uploaded result images

### Public Frontend
- **Live Results**: Real-time voting results display
- **Filter by Ashon**: View results for specific elections
- **Auto-refresh**: Page refreshes every 30 seconds
- **Responsive Design**: Works on all devices

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL/MariaDB database

### Setup Steps

1. **Clone and Install Dependencies**
```bash
composer install
npm install
```

2. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure Database**
Edit `.env` file:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nirbachon
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Run Migrations and Seed Database**
```bash
php artisan migrate:fresh --seed
```

5. **Create Storage Link**
```bash
php artisan storage:link
```

6. **Build Assets**
```bash
npm run build
```

7. **Start Development Server**
```bash
php artisan serve
```

## Default Credentials

**Admin Login:**
- Email: `admin@nirbachon.com`
- Password: `password`

## Usage Guide

### For Administrators

1. **Login** at `/login` with admin credentials
2. **Create Ashon** (Election Event)
3. **Create Centars** (Voting Centers):
   - Manual: One by one through the form
   - Bulk Import: Upload CSV/Excel file
   
   CSV Format:
   ```
   Ashon ID,Centar Title,Address
   1,Dhaka Center 1,123 Main Street
   1,Dhaka Center 2,456 Park Avenue
   ```

4. **Create Markas** (Political Parties):
   - Upload party symbol image (auto-resized to 200x200px)

5. **Create Agents**:
   - Assign centar and marka to agents
   - Agents will use these credentials to upload results

### For Agents

1. **Login** at `/login` with agent credentials
2. **Upload Results**:
   - Select Ashon and Centar
   - Enter total votes
   - Upload supporting images (optional)
3. **Manage Results**: Edit previously submitted results

### Public Access

Visit the homepage to view live voting results:
- Results automatically update every 30 seconds
- Filter by specific Ashon (election)
- View vote counts and percentages

## Technologies Used

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS
- **Database**: MySQL
- **File Handling**: 
  - Laravel Excel (CSV/Excel import)
  - Intervention Image (image resizing)

## File Structure

```
app/
├── Http/Controllers/
│   ├── Auth/          # Authentication
│   ├── Admin/         # Admin panel controllers
│   └── Agent/         # Agent panel controllers
├── Models/            # Eloquent models
├── Enums/             # Role enums
└── Imports/           # Excel import classes

resources/views/
├── layouts/           # Layout templates
├── auth/              # Login views
├── admin/             # Admin panel views
├── agent/             # Agent panel views
└── home.blade.php     # Public results page

routes/
└── web.php            # Application routes
```

## Security

- Password hashing using bcrypt
- CSRF protection on all forms
- Role-based access control (admin/agent)
- File upload validation
- SQL injection protection via Eloquent ORM

Built with ❤️ using Laravel & Tailwind CSS

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
