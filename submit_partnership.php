<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$user = "root";
$pass = ""; // your MySQL password
$db = "etash";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Sanitize and collect POST data
function get($key) {
    return isset($_POST[$key]) ? htmlspecialchars(trim($_POST[$key])) : null;
}

$fields = [
    'business_name', 'business_type', 'registration_number', 'gst_number', 'business_address', 'city', 'state', 'pincode', 'years_operation',
    'contact_person', 'designation', 'email', 'phone', 'alternate_phone', 'website', 'service_areas', 'services_offered', 'fleet_size',
    'vehicle_types', 'daily_capacity', 'certifications', 'preferred_partnership', 'expected_volume', 'business_description', 'additional_info'
];

$data = [];
foreach ($fields as $f) $data[$f] = get($f);

// Prepare and execute insert
$stmt = $conn->prepare("INSERT INTO partnership_applications
    (business_name, business_type, registration_number, gst_number, business_address, city, state, pincode, years_operation,
    contact_person, designation, email, phone, alternate_phone, website, service_areas, services_offered, fleet_size,
    vehicle_types, daily_capacity, certifications, preferred_partnership, expected_volume, business_description, additional_info)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "ssssssssissssssissssssss",
    $data['business_name'], $data['business_type'], $data['registration_number'], $data['gst_number'], $data['business_address'],
    $data['city'], $data['state'], $data['pincode'], $data['years_operation'], $data['contact_person'], $data['designation'],
    $data['email'], $data['phone'], $data['alternate_phone'], $data['website'], $data['service_areas'], $data['services_offered'],
    $data['fleet_size'], $data['vehicle_types'], $data['daily_capacity'], $data['certifications'], $data['preferred_partnership'],
    $data['expected_volume'], $data['business_description'], $data['additional_info']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Application submitted successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Submission failed.']);
}
$stmt->close();
$conn->close();
?>