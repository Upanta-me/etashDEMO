<?php
// download_cv.php: Serve CV/Resume BLOB from database for download
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'etash';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed.');
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Invalid request.');
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT cv_resume_path, cv_resume_filename, cv_resume_mimetype FROM applications WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    $stmt->close();
    $conn->close();
    die('File not found.');
}
$stmt->bind_result($blob, $filename, $mimetype);
$stmt->fetch();
$stmt->close();
$conn->close();

header('Content-Description: File Transfer');
header('Content-Type: ' . $mimetype);
header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
header('Content-Length: ' . strlen($blob));
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Expires: 0');
echo $blob;
exit; 