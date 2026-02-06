# Quick Start Guide - Nirbachon

## Server is Running!
Visit: http://127.0.0.1:8000

## Default Login Credentials

### Admin Panel
- **URL**: http://127.0.0.1:8000/login
- **Email**: admin@nirbachon.com
- **Password**: password

## Quick Setup Checklist

1. ✅ Migrations run successfully
2. ✅ Default admin user created
3. ✅ Storage linked
4. ✅ Assets built
5. ✅ Server running

## Next Steps

### 1. Login as Admin
Navigate to http://127.0.0.1:8000/login and login with admin credentials

### 2. Create Election (Ashon)
- Go to Admin Panel → Ashons → Add New Ashon
- Example: "General Election 2026"

### 3. Add Voting Centers (Centars)
Option A - Manual:
- Admin Panel → Centars → Add New Centar
- Fill in Ashon, Title, and Address

Option B - Bulk Import:
- Admin Panel → Centars → Import CSV/Excel
- Upload file with format: Ashon ID, Title, Address

### 4. Create Political Parties (Markas)
- Admin Panel → Markas → Add New Marka
- Enter party name and upload symbol (200x200px)

### 5. Create Agent Accounts
- Admin Panel → Agents → Add New Agent
- Fill in details and assign Centar and Marka
- Agents will use these credentials to login

### 6. Agent Uploads Results
- Login as agent: http://127.0.0.1:8000/login
- Agent Panel → Upload Result
- Enter votes and upload images

### 7. View Live Results
- Public URL: http://127.0.0.1:8000
- No login required
- Auto-refreshes every 30 seconds

## Features Overview

### Admin Can:
- ✅ Create and manage Ashons (Elections)
- ✅ Create and manage Centars (Voting Centers)
- ✅ Import Centars via CSV/Excel
- ✅ Create and manage Markas (Political Parties)
- ✅ Upload party symbols (auto-resized to 200x200)
- ✅ Create and manage Agents
- ✅ Assign Centars and Markas to Agents
- ✅ View dashboard statistics

### Agent Can:
- ✅ Upload voting results
- ✅ Attach multiple images to results
- ✅ Edit their own results
- ✅ Delete uploaded images
- ✅ View their submission history

### Public Can:
- ✅ View live voting results
- ✅ Filter by Ashon (Election)
- ✅ See vote counts and percentages
- ✅ Auto-refresh results

## CSV Import Format for Centars

Create a CSV/Excel file with these columns:

```csv
Ashon ID,Centar Title,Address
1,Dhaka Center 1,123 Main Street, Dhaka
1,Dhaka Center 2,456 Park Avenue, Dhaka
1,Chittagong Center 1,789 Beach Road, Chittagong
```

**Important**: 
- First row is header (will be skipped)
- Ashon ID must exist in database
- All three columns are required

## Troubleshooting

### If images don't display:
```bash
php artisan storage:link
```

### If styles are missing:
```bash
npm run build
```

### To reset database:
```bash
php artisan migrate:fresh --seed
```
⚠️ Warning: This will delete all data!

## File Upload Limits

- **Marka Images**: Max 2MB, auto-resized to 200x200px
- **Result Images**: Max 5MB per image, multiple allowed
- **CSV Import**: Max 10MB

## Security Notes

- Change default admin password after first login
- Use strong passwords for agent accounts
- Keep .env file secure
- Don't commit .env to version control
- Regularly backup database

## Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Tailwind CSS (v4)
- **Database**: MySQL
- **Image Processing**: Intervention Image
- **Excel Import**: Laravel Excel

## Support

For issues or questions:
1. Check the main README.md
2. Review Laravel logs: `storage/logs/laravel.log`
3. Check browser console for JavaScript errors

---

## Useful Commands

```bash
# Start server
php artisan serve

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Create new admin
php artisan tinker
>>> \App\Models\User::create(['name' => 'Admin', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'role' => \App\Enums\Roles::ADMIN]);

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Build assets for production
npm run build
```

## Project Structure

```
Nirbachon/
├── app/
│   ├── Http/Controllers/
│   │   ├── Auth/         # LoginController
│   │   ├── Admin/        # Admin panel controllers
│   │   └── Agent/        # Agent panel controllers
│   ├── Models/           # Database models
│   ├── Enums/            # Roles enum
│   └── Imports/          # Excel import classes
├── resources/
│   ├── views/
│   │   ├── layouts/      # App, Admin, Agent layouts
│   │   ├── auth/         # Login page
│   │   ├── admin/        # Admin views
│   │   ├── agent/        # Agent views
│   │   └── home.blade.php # Public results
│   └── css/              # Tailwind CSS
├── routes/
│   └── web.php           # All routes
└── database/
    ├── migrations/       # Database schema
    └── seeders/          # Default data
```

## Happy Coding! 🚀
