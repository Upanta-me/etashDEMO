<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}

// Database config (replace with your actual credentials)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'etash';
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed.');
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: admin_login.php');
    exit;
}

$sql = 'SELECT * FROM applications ORDER BY created_at DESC';
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Etash Deliveries</title>
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link rel="shortcut icon" href="assets/img/etashlogo2.png">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #e9ecef 0%, #f8f9fa 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        .panel {
            max-width: 1200px;
            margin: 48px auto 48px auto;
            background: #fff;
            padding: 48px 36px 36px 36px;
            border-radius: 22px;
            box-shadow: 0 8px 40px 0 rgba(40,167,69,0.13), 0 2px 16px #0001;
            position: relative;
        }
        .panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
        }
        .panel-logo {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .panel-logo img {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(40,167,69,0.10);
            background: #fff;
            object-fit: contain;
        }
        .panel-logo h2 {
            margin: 0;
            color: #28a745;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .logout-btn {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 12px 28px;
            font-size: 1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(40,167,69,0.10);
            transition: background 0.2s, transform 0.2s;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        .logout-btn:hover {
            background: linear-gradient(135deg, #218838, #1abc9c);
            transform: translateY(-2px);
            color: #fff;
            text-decoration: none;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 10px;
            background: #fff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(40,167,69,0.05);
        }
        th, td {
            border: none;
            padding: 14px 14px;
            text-align: left;
            font-size: 1rem;
        }
        th {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: #fff;
            font-weight: 700;
            font-size: 1.05rem;
            letter-spacing: 0.5px;
        }
        tr {
            transition: background 0.2s;
        }
        tr:nth-child(even) {
            background: #f7faf9;
        }
        tr:hover {
            background: #e6f7ee;
        }
        .download-link {
            color: #20c997;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }
        .download-link:hover {
            color: #218838;
        }
        @media (max-width: 900px) {
            .panel {
                padding: 24px 4vw 18px 4vw;
            }
            .panel-header h2 {
                font-size: 1.2rem;
            }
            th, td {
                font-size: 0.98rem;
                padding: 10px 8px;
            }
        }
        @media (max-width: 600px) {
            .panel {
                padding: 10px 2vw 10px 2vw;
            }
            .panel-logo img {
                width: 36px;
                height: 36px;
            }
            .panel-logo h2 {
                font-size: 1rem;
            }
            th, td {
                font-size: 0.92rem;
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="panel">
        <div class="panel-header">
            <div class="panel-logo">
                <img src="assets/img/etashlogo2.png" alt="Etash Deliveries Logo">
                <h2>Career Applications - Admin Panel</h2>
            </div>
            <a href="?logout=1" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div class="table-responsive">
        <table>
            <tr>
                <th>Candidate Name</th>
                <th>Educational Qualification</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Alternate Phone Number</th>
                <th>CV/Resume</th>
                <th>Location</th>
                <th>Submitted At</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['candidate_name']) ?></td>
                        <td><?= htmlspecialchars($row['educational_qualification']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone_number']) ?></td>
                        <td><?= htmlspecialchars($row['alternate_phone_number']) ?></td>
                        <td><a class="download-link" href="download_cv.php?id=<?= $row['id'] ?>" target="_blank">Download</a></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td><?= htmlspecialchars($row['created_at']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8">No applications found.</td></tr>
            <?php endif; ?>
        </table>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?> 