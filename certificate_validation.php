<?php
// Certificate Validation System - Database Integration
require_once 'config.php';

$certificates = [];
$error_message = '';
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    $certManager = new CertificateManager();
    $certificates = $certManager->searchCertificates($search_query);
    
} catch (Exception $e) {
    $error_message = "Database connection failed. Please ensure the database is set up correctly.";
    // Fallback to sample data for demonstration
    $certificates = [
        ['certificate_id' => 'CERT001', 'student_name' => 'John Doe', 'course_name' => 'Web Development', 'issue_date' => '2024-01-15'],
        ['certificate_id' => 'CERT002', 'student_name' => 'Jane Smith', 'course_name' => 'Data Science', 'issue_date' => '2024-02-20'],
        ['certificate_id' => 'CERT003', 'student_name' => 'Mike Johnson', 'course_name' => 'Digital Marketing', 'issue_date' => '2024-03-10'],
        ['certificate_id' => 'CERT004', 'student_name' => 'Sarah Wilson', 'course_name' => 'Cybersecurity', 'issue_date' => '2024-04-05'],
        ['certificate_id' => 'CERT005', 'student_name' => 'David Brown', 'course_name' => 'Cloud Computing', 'issue_date' => '2024-05-12']
    ];
    
    if (!empty($search_query)) {
        $certificates = array_filter($certificates, function($cert) use ($search_query) {
            return stripos($cert['certificate_id'], $search_query) !== false ||
                   stripos($cert['student_name'], $search_query) !== false ||
                   stripos($cert['course_name'], $search_query) !== false;
        });
    }
}

$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Validation - YCore Technologies</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #000000;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 32px 64px rgba(0,0,0,0.3), 0 0 0 1px rgba(255,255,255,0.05);
            overflow: hidden;
            animation: slideUp 0.8s ease-out;
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: #000000;
            color: white;
            padding: 50px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.15"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.15"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.15"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }

        .header h1 {
            font-size: 3.2rem;
            margin-bottom: 16px;
            font-weight: 700;
            background: linear-gradient(135deg, #ffffff 0%, #f0f8ff 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }

        .header p {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }

        .search-section {
            padding: 40px 40px 60px;
            background: #000000;
            position: relative;
            min-height: 30vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }


        .search-container {
            position: relative;
            max-width: 600px;
            margin: 0 auto;
            z-index: 1;
        }

        .search-box {
            width: 100%;
            padding: 18px 70px 18px 24px;
            font-size: 1.05rem;
            border: 2px solid rgba(255,255,255,0.1);
            border-radius: 50px;
            outline: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(15px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.1);
            font-weight: 400;
            font-family: inherit;
            color: white;
        }

        .search-box:focus {
            border-color: rgba(102, 126, 234, 0.5);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1), 0 15px 35px rgba(0,0,0,0.3);
            transform: translateY(-1px);
            background: rgba(255,255,255,0.08);
        }

        .search-box::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-weight: 400;
        }

        .search-btn {
            position: absolute;
            right: 4px;
            top: 4px;
            bottom: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 50px;
            width: 50px;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .search-btn:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%);
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
        }

        .search-btn:active {
            transform: scale(0.98);
        }

        .search-btn svg {
            width: 20px;
            height: 20px;
            fill: white;
        }

        .clear-btn {
            position: absolute;
            right: 58px;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.1);
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: none;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 16px;
            line-height: 1;
        }

        .clear-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.9);
        }

        .clear-btn.show {
            display: flex;
        }

        .results-section {
            padding: 20px 40px 40px;
            background: #000000;
        }

        .results-header {
            margin-bottom: 20px;
            text-align: center;
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        .results-header h2 {
            font-size: 2.2rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 8px;
        }

        .results-count {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            font-weight: 500;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .certificates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 24px;
            animation: fadeInUp 0.8s ease-out 0.5s both;
        }

        .certificate-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 24px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
            position: relative;
            overflow: hidden;
        }

        .certificate-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .certificate-card:hover::before {
            transform: scaleX(1);
        }

        .certificate-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .cert-id {
            font-size: 0.85rem;
            color: #667eea;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
            padding: 6px 12px;
            background: rgba(102, 126, 234, 0.2);
            border-radius: 20px;
        }

        .cert-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .cert-course {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
            font-size: 1.05rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .cert-course::before {
            content: '📚';
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .cert-details {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
        }

        .cert-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.95rem;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .cert-date::before {
            content: '📅';
            margin-right: 8px;
            font-size: 1rem;
        }

        .no-results {
            text-align: center;
            padding: 80px 20px;
            animation: fadeInUp 0.6s ease-out;
        }

        .no-results h3 {
            font-size: 1.8rem;
            margin-bottom: 16px;
            color: #ffffff;
            font-weight: 600;
        }

        .no-results p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1rem;
            margin-bottom: 24px;
        }

        .clear-search {
            display: inline-block;
            margin-top: 8px;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .clear-search:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }

        .error-message {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .certificates-grid {
                grid-template-columns: 1fr;
                gap: 24px;
            }
            
            .header h1 {
                font-size: 2.4rem;
            }
            
            .header {
                padding: 40px 20px;
            }
            
            .search-section {
                padding: 30px 20px 40px;
                min-height: 25vh;
            }
            
            .results-section {
                padding: 15px 20px 30px;
            }
            
            .certificates-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            
            .certificate-card {
                padding: 20px;
            }
            
            .search-container {
                max-width: 100%;
            }
            
            .search-box {
                padding: 16px 60px 16px 20px;
                font-size: 1rem;
            }
            
            .search-btn {
                width: 46px;
                right: 3px;
                top: 3px;
                bottom: 3px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 2rem;
            }
            
            .certificates-grid {
                grid-template-columns: 1fr;
            }
            
            .certificate-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Certificate Validation</h1>
            <p>Verify and search certificates issued by YCore Technologies</p>
        </div>

        <div class="search-section">
            <?php if (!empty($error_message)): ?>
                <div class="error-message" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
                    <strong>Notice:</strong> <?php echo htmlspecialchars($error_message); ?> Using sample data for demonstration.
                </div>
            <?php endif; ?>
            
            <form method="GET" class="search-container">
                <input 
                    type="text" 
                    name="search" 
                    class="search-box" 
                    placeholder="Search by Certificate ID, Name, or Course..." 
                    value="<?php echo htmlspecialchars($search_query); ?>"
                    autocomplete="off"
                    id="searchInput"
                >
                <button type="button" class="clear-btn" id="clearBtn">×</button>
                <button type="submit" class="search-btn">
                    <svg viewBox="0 0 24 24">
                        <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    </svg>
                </button>
            </form>
        </div>

        <?php if (!empty($search_query)): ?>
        <div class="results-section">
            <div class="results-header">
                <h2>Search Results for "<?php echo htmlspecialchars($search_query); ?>"</h2>
                <p class="results-count"><?php echo count($certificates); ?> certificate(s) found</p>
            </div>

            <?php if (empty($certificates)): ?>
                <div class="no-results">
                    <h3>No certificates found</h3>
                    <p>Try adjusting your search terms or check the certificate ID</p>
                    <a href="?" class="clear-search">Clear Search</a>
                </div>
            <?php else: ?>
                <div class="certificates-grid">
                    <?php foreach ($certificates as $cert): ?>
                        <div class="certificate-card">
                            <div class="cert-id"><?php echo htmlspecialchars($cert['certificate_id']); ?></div>
                            <div class="cert-name"><?php echo htmlspecialchars($cert['student_name']); ?></div>
                            <div class="cert-course"><?php echo htmlspecialchars($cert['course_name']); ?></div>
                            <div class="cert-details">
                                <span class="cert-date">Issued: <?php echo htmlspecialchars($cert['issue_date']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>

    <script>
        // Enhanced search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchInput');
            const clearBtn = document.getElementById('clearBtn');
            const searchForm = document.querySelector('.search-container');
            
            // Auto-focus search box
            searchBox.focus();
            
            // Show/hide clear button based on input content
            function toggleClearButton() {
                if (searchBox.value.trim().length > 0) {
                    clearBtn.classList.add('show');
                } else {
                    clearBtn.classList.remove('show');
                }
            }
            
            // Check initial state
            toggleClearButton();
            
            // Listen for input changes
            searchBox.addEventListener('input', toggleClearButton);
            searchBox.addEventListener('keyup', toggleClearButton);
            searchBox.addEventListener('paste', function() {
                setTimeout(toggleClearButton, 10);
            });
            
            // Clear button functionality
            clearBtn.addEventListener('click', function() {
                searchBox.value = '';
                toggleClearButton();
                searchBox.focus();
                // Redirect to clear search results
                window.location.href = window.location.pathname;
            });
            
            // Handle Enter key
            searchBox.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    searchForm.submit();
                }
            });
        });
    </script>
</body>
</html>