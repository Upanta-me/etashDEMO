<?php
// Database config (replace with your actual credentials)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'etash';

// Connect to MySQL
global $conn;
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    show_response('Database connection failed.', false);
    exit;
}

// Helper: sanitize input
function clean($str) {
    return htmlspecialchars(trim($str), ENT_QUOTES, 'UTF-8');
}

// Helper: show styled response page
function show_response($message, $success = true) {
    $icon = $success
        ? '<div class="success-icon" style="width:100px;height:100px;margin:0 auto 30px;background:#28a745;border-radius:50%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-check-circle" style="font-size:48px;color:white;"></i></div>'
        : '<div class="success-icon" style="width:100px;height:100px;margin:0 auto 30px;background:#dc3545;border-radius:50%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-times-circle" style="font-size:48px;color:white;"></i></div>';
    $title = $success ? 'Application Submitted Successfully!' : 'Submission Failed';
    $desc = $success
        ? 'Thank you for your interest in joining Etash Deliveries. Our HR team will review your application and get back to you within 48 hours.'
        : $message;
    $btn = $success
        ? '<a href="index.html" style="display:inline-block;margin-top:30px;padding:15px 35px;background:linear-gradient(135deg,#28a745,#20c997);color:#fff;border-radius:50px;text-decoration:none;font-weight:600;letter-spacing:0.5px;transition:all 0.3s;">Back to Home</a>'
        : '<a href="career.html" style="display:inline-block;margin-top:30px;padding:15px 35px;background:linear-gradient(135deg,#dc3545,#ff7675);color:#fff;border-radius:50px;text-decoration:none;font-weight:600;letter-spacing:0.5px;transition:all 0.3s;">Try Again</a>';
    echo "<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Thank You - Etash Deliveries</title>
    <link rel=\"stylesheet\" href=\"assets/css/bootstrap.min.css\">
    <link rel=\"stylesheet\" href=\"assets/css/all.min.css\">
    <link rel=\"shortcut icon\" href=\"assets/img/etashlogo2.png\">
    <style>
        body { background: linear-gradient(135deg,#f8f9fa 0%,#ffffff 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .thankyou-container { background: #fff; border-radius: 25px; box-shadow: 0 20px 60px rgba(0,0,0,0.1); padding: 60px 40px; max-width: 450px; width: 100%; text-align: center; }
        .thankyou-container h1 { font-size: 2rem; font-weight: 700; color: #333; margin-bottom: 15px; }
        .thankyou-container p { color: #155724; font-size: 1rem; margin-bottom: 0; }
        .thankyou-container .success-icon { animation: successPulse 1.5s ease-in-out infinite; }
        @keyframes successPulse { 0%,100%{transform:scale(1);} 50%{transform:scale(1.1);} }
        .thankyou-container a:hover { opacity: 0.85; transform: translateY(-2px); }
    </style>
    <script src=\"assets/js/all.min.js\"></script>
</head>
<body>
    <div class=\"thankyou-container\">
        $icon
        <h1>$title</h1>
        <p>$desc</p>
        $btn
    </div>
</body>
</html>";
    exit;
}

// Validate and collect inputs
$candidate_name = isset($_POST['candidate_name']) ? clean($_POST['candidate_name']) : '';
$educational_qualification = isset($_POST['educational_qualification']) ? clean($_POST['educational_qualification']) : '';
$email = isset($_POST['email']) ? clean($_POST['email']) : '';
$phone_number = isset($_POST['phone_number']) ? clean($_POST['phone_number']) : '';
$alternate_phone_number = isset($_POST['alternate_phone_number']) ? clean($_POST['alternate_phone_number']) : '';
$location = isset($_POST['location']) ? clean($_POST['location']) : '';
$created_at = date('Y-m-d H:i:s');

// Validate required fields
if (!$candidate_name || !$educational_qualification || !$email || !$phone_number || !$location || !isset($_FILES['cv_resume_path'])) {
    show_response('All fields are required.', false);
}

// Validate file
$allowed_ext = ['pdf', 'doc', 'docx'];
$max_size = 5 * 1024 * 1024; // 5MB
$cv = $_FILES['cv_resume_path'];
$cv_name = $cv['name'];
$cv_tmp = $cv['tmp_name'];
$cv_size = $cv['size'];
$cv_ext = strtolower(pathinfo($cv_name, PATHINFO_EXTENSION));
$cv_mime = $cv['type'];

if (!in_array($cv_ext, $allowed_ext)) {
    show_response('Invalid file type. Only PDF, DOC, DOCX allowed.', false);
}
if ($cv_size > $max_size) {
    show_response('File too large. Max 5MB allowed.', false);
}

$cv_blob = file_get_contents($cv_tmp);

// Insert into DB
$stmt = $conn->prepare("INSERT INTO applications (candidate_name, educational_qualification, email, phone_number, alternate_phone_number, cv_resume_path, cv_resume_filename, cv_resume_mimetype, location, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssbssss', $candidate_name, $educational_qualification, $email, $phone_number, $alternate_phone_number, $null, $cv_name, $cv_mime, $location, $created_at);
$stmt->send_long_data(5, $cv_blob);
if ($stmt->execute()) {
    show_response('Thank you for your interest in joining Etash Deliveries. Our HR team will review your application and get back to you within 48 hours.', true);
} else {
    show_response('Failed to submit application. Please try again later.', false);
}
$stmt->close();
$conn->close();
?> 