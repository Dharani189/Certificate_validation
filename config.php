<?php
// Database Configuration File
// Modify these settings according to your database setup

class DatabaseConfig {
    const HOST = 'localhost';
    const DBNAME = 'ycore_certificates';
    const USERNAME = 'root';
    const PASSWORD = '';
    const CHARSET = 'utf8mb4';
    
    public static function getConnection() {
        try {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DBNAME . ";charset=" . self::CHARSET;
            $pdo = new PDO($dsn, self::USERNAME, self::PASSWORD);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
}

class CertificateManager {
    private $pdo;
    
    public function __construct() {
        $this->pdo = DatabaseConfig::getConnection();
    }
    
    public function searchCertificates($searchQuery = '') {
        if (empty($searchQuery)) {
            $sql = "SELECT * FROM certificates ORDER BY issue_date DESC";
            $stmt = $this->pdo->prepare($sql);
        } else {
            $sql = "SELECT * FROM certificates WHERE 
                    certificate_id LIKE :search OR 
                    student_name LIKE :search OR 
                    course_name LIKE :search 
                    ORDER BY issue_date DESC";
            $stmt = $this->pdo->prepare($sql);
            $searchParam = '%' . $searchQuery . '%';
            $stmt->bindParam(':search', $searchParam);
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getCertificateById($certificateId) {
        $sql = "SELECT * FROM certificates WHERE certificate_id = :cert_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cert_id', $certificateId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function validateCertificate($certificateId) {
        $cert = $this->getCertificateById($certificateId);
        if (!$cert) {
            return ['valid' => false, 'message' => 'Certificate not found'];
        }
        
        return ['valid' => true, 'message' => 'Certificate is valid', 'data' => $cert];
    }
}
?>
