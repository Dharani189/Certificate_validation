# Certificate Validation System

A modern, responsive web application for validating and searching certificates issued by YCore Technologies. Built with PHP and MySQL, featuring a sleek dark theme interface with real-time search capabilities.

## Features

- **Certificate Search**: Search by Certificate ID, student name, or course name
- **Real-time Validation**: Instant certificate verification with detailed information
- **Responsive Design**: Modern dark theme with glassmorphism effects
- **Database Integration**: MySQL backend with fallback to sample data
- **Secure**: PDO-based database connections with prepared statements
- **User-friendly**: Auto-focus search, clear buttons, and smooth animations

## Tech Stack

- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frontend**: HTML5, CSS3 (Grid/Flexbox), Vanilla JavaScript
- **Server**: Apache (XAMPP)
- **Styling**: Custom CSS with Inter font family

## Prerequisites

- XAMPP (or similar LAMP/WAMP stack)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web browser (Chrome, Firefox, Safari, Edge)

## Installation

### 1. Clone/Download Project
```bash
# Place the project files in your XAMPP htdocs directory
# Default path: C:\xampp\htdocs\ycoretechnologies\
```

### 2. Database Setup
1. Start XAMPP and ensure Apache and MySQL services are running
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Import the database schema:
   ```sql
   # Run the contents of setup_database.sql
   # This will create the 'ycore_certificates' database and sample data
   ```

### 3. Configuration
1. Open `config.php`
2. Update database credentials if needed:
   ```php
   const HOST = 'localhost';        // Database host
   const DBNAME = 'ycore_certificates';  // Database name
   const USERNAME = 'root';         // Database username
   const PASSWORD = '';             // Database password (empty for XAMPP default)
   ```

### 4. Access Application
- Open your web browser
- Navigate to: `http://localhost/ycoretechnologies/certificate_validation.php`

## Project Structure

```
ycoretechnologies/
├── certificate_validation.php    # Main application file (UI + Logic)
├── config.php                   # Database configuration and classes
├── setup_database.sql           # Database schema and sample data
└── README.md                    # Project documentation
```

## Database Schema

### Certificates Table
| Field | Type | Description |
|-------|------|-------------|
| `id` | INT (Primary Key) | Auto-increment ID |
| `certificate_id` | VARCHAR(20) | Unique certificate identifier |
| `student_name` | VARCHAR(100) | Student's full name |
| `course_name` | VARCHAR(100) | Course/program name |
| `issue_date` | DATE | Certificate issue date |
| `created_at` | TIMESTAMP | Record creation timestamp |
| `updated_at` | TIMESTAMP | Record update timestamp |

## Usage

### Search Certificates
1. Enter search terms in the search box:
   - Certificate ID (e.g., "CERT001")
   - Student name (e.g., "John Doe")
   - Course name (e.g., "Web Development")
2. Press Enter or click the search button
3. View results in the grid layout below

### Sample Certificates
The system includes 10 sample certificates for testing:
- CERT001 - John Doe - Web Development
- CERT002 - Jane Smith - Data Science
- CERT003 - Mike Johnson - Digital Marketing
- CERT004 - Sarah Wilson - Cybersecurity
- CERT005 - David Brown - Cloud Computing
- And 5 more...

## API Classes

### DatabaseConfig
Handles database connection and configuration.

**Methods:**
- `getConnection()`: Returns PDO connection instance

### CertificateManager
Manages certificate operations and database queries.

**Methods:**
- `searchCertificates($searchQuery)`: Search certificates by query
- `getCertificateById($certificateId)`: Get specific certificate
- `validateCertificate($certificateId)`: Validate certificate existence

## Features in Detail

### Search Functionality
- **Multi-field search**: Searches across certificate ID, student name, and course name
- **Case-insensitive**: Search terms are not case-sensitive
- **Partial matching**: Supports partial string matching
- **Real-time feedback**: Shows search results count

### UI/UX Features
- **Dark theme**: Modern black background with glassmorphism effects
- **Responsive design**: Works on desktop, tablet, and mobile devices
- **Smooth animations**: CSS transitions and keyframe animations
- **Interactive elements**: Hover effects and button states
- **Clear search**: Easy-to-use clear button for search input

### Error Handling
- **Database fallback**: Uses sample data if database connection fails
- **User-friendly messages**: Clear error notifications
- **Graceful degradation**: Application works even without database

## Customization

### Styling
- Modify CSS variables in `certificate_validation.php` (lines 42-479)
- Change color scheme by updating gradient values
- Adjust responsive breakpoints for different screen sizes

### Database
- Add more certificate records via phpMyAdmin or SQL scripts
- Modify table schema in `setup_database.sql` for additional fields
- Update search logic in `CertificateManager` class

### Branding
- Update company name and branding in header section
- Modify logo/favicon references
- Change application title and descriptions

## Troubleshooting

### Common Issues

**Database Connection Failed**
- Ensure XAMPP MySQL service is running
- Check database credentials in `config.php`
- Verify database exists by running `setup_database.sql`

**Search Not Working**
- Check PHP error logs in XAMPP
- Ensure proper file permissions
- Verify database table has data

**Styling Issues**
- Clear browser cache
- Check for CSS syntax errors
- Ensure proper file paths

### Development Mode
For debugging, add this to the top of `certificate_validation.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## Security Considerations

- Uses PDO prepared statements to prevent SQL injection
- Input sanitization with `htmlspecialchars()`
- No sensitive data exposed in client-side code
- Database credentials stored in separate config file

## Browser Support

- Chrome 80+
- Firefox 75+
- Safari 13+
- Edge 80+

## Future Enhancements

- [ ] Certificate PDF generation
- [ ] Admin panel for certificate management
- [ ] Email verification system
- [ ] API endpoints for external integrations
- [ ] Advanced filtering options
- [ ] Certificate expiration tracking

## License

This project is developed for YCore Technologies. All rights reserved.

## Support

For technical support or questions:
- Check the troubleshooting section above
- Review PHP error logs in XAMPP
- Ensure all prerequisites are met

---

**YCore Technologies** - Certificate Validation System v1.0
