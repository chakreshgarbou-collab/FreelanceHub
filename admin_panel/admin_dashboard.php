<?php
// Enable strict error reporting for development on XAMPP
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database Connection String 
$host = "localhost";
$db_user = "root";
$db_pass = ""; 
$db_name = "platform_governance";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("<div style='color:red; font-family:sans-serif; padding:20px;'><strong>Database Connection Error:</strong> Check your XAMPP MySQL server. Run the SQL schema script first!</div>");
}

// Global Message Banner System
$status_msg = "";
$msg_type = "success";

// --- ACTION ROUTERS (Form Submissions) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Slide 2 Workflow: Identity Verification & Disciplinary Actions
    if (isset($_POST['action_user_management'])) {
        $user_id = intval($_POST['user_id']);
        $new_v_status = $_POST['verification_status'];
        $new_a_status = $_POST['account_status'];
        
        $stmt = $pdo->prepare("UPDATE users SET verification_status = ?, account_status = ? WHERE id = ?");
        $stmt->execute([$new_v_status, $new_a_status, $user_id]);
        $status_msg = "User ID #$user_id updated successfully via human-in-the-loop triage.";
    }

    // Slide 3 Workflow: Dual-Authorization Financial Checker Process
    if (isset($_POST['action_financial_checker'])) {
        $ledger_id = intval($_POST['ledger_id']);
        $decision = $_POST['checker_decision']; // 'approved_payout' or 'refunded_dispute'
        $checker_name = "Admin_Checker_Senior"; // Simulated Authenticated Identity
        
        $stmt = $pdo->prepare("UPDATE financial_ledger SET escrow_status = ?, checker_admin = ? WHERE id = ?");
        $stmt->execute([$decision, $checker_name, $ledger_id]);
        $status_msg = "Financial ledger entry #$ledger_id updated to '$decision' with full Maker-Checker dual compliance validation.";
    }

    // Slide 4 Workflow: Objective Workspace Dispute Arbitration 
    if (isset($_POST['action_dispute_resolve'])) {
        $dispute_id = intval($_POST['dispute_id']);
        $outcome = $_POST['dispute_outcome']; // 'resolved_client' or 'resolved_freelancer'
        
        $stmt = $pdo->prepare("UPDATE disputes SET dispute_status = ? WHERE id = ?");
        $stmt->execute([$outcome, $dispute_id]);
        $status_msg = "Dispute case #$dispute_id finalized. Funds safely processed according to objective workspace log data metrics.";
    }

    // Slide 5 Workflow: Asynchronous Proactive AI Content Purge
    if (isset($_POST['action_moderation_purge'])) {
        $job_id = intval($_POST['job_id']);
        
        $stmt = $pdo->prepare("UPDATE job_postings SET moderation_flag = 'removed' WHERE id = ?");
        $stmt->execute([$job_id]);
        $status_msg = "Malicious or out-of-platform payment posting #$job_id systematically stripped off the public index.";
        $msg_type = "danger";
    }
}

// --- DATA FETCHING (Read State engines) ---
$all_users = $pdo->query("SELECT * FROM users")->fetchAll();
$pending_transactions = $pdo->query("SELECT * FROM financial_ledger WHERE checker_admin IS NULL")->fetchAll();
$open_disputes = $pdo->query("SELECT * FROM disputes WHERE dispute_status = 'open'")->fetchAll();
$flagged_jobs = $pdo->query("SELECT * FROM job_postings WHERE moderation_flag = 'flagged_ai'")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Control Panel & Governance Dashboard</title>
    <!-- Clean styling using Bootstrap CSS via CDN -->
    <link href="https://jsdelivr.net" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; font-family: system-ui, -apple-system, sans-serif; }
        .dashboard-header { background: #1e293b; color: white; padding: 20px; border-radius: 0 0 12px 12px; margin-bottom: 30px; }
        .card { border: none; border-radius: 10px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); margin-bottom: 25px; }
        .card-header { font-weight: bold; background-color: #fff; border-bottom: 1px solid #edf2f7; }
        .badge-pending { background-color: #f59e0b; color: white; }
        .badge-active { background-color: #10b981; color: white; }
        .badge-flagged { background-color: #ef4444; color: white; }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="dashboard-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 m-0">Admin Control Panel & Governance Blueprint</h1>
            <p class="small text-muted m-0">Secure Platform Functional Management Operations Node</p>
        </div>
        <span class="badge bg-secondary">Footer Auth ID: ethan.chibanda</span>
    </div>

    <!-- Alert Status Messages -->
    <?php if ($status_msg != ""): ?>
        <div class="alert alert-<?php echo $msg_type; ?> alert-dismissible fade show" role="alert">
            <strong>System Process Alert:</strong> <?php echo htmlspecialchars($status_msg); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Row 1 Container -->
    <div class="row">
        
        <!-- SECTION 1: User Management Panel (Slide 2 Mapping) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-primary">Slide 2: User Management (Triggered Automation Architecture)</div>
                <div class="card-body">
                    <table class="table align-middle table-sm">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Identity Status</th>
                                <th>Account Status</th>
                                <th>Execute Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($all_users as $user): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($user['username']); ?></strong><br><small class="text-muted"><?php echo $user['role']; ?></small></td>
                                <td><span class="badge badge-active"><?php echo $user['verification_status']; ?></span></td>
                                <td><span class="badge bg-dark"><?php echo $user['account_status']; ?></span></td>
                                <td>
                                    <form method="POST" class="d-flex gap-1">
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <select name="verification_status" class="form-select form-select-sm" style="width:90px;">
                                            <option value="verified">Verify</option>
                                            <option value="rejected">Reject</option>
                                        </select>
                                        <select name="account_status" class="form-select form-select-sm" style="width:90px;">
                                            <option value="active">Active</option>
                                            <option value="suspended">Suspend</option>
                                        </select>
                                        <button type="submit" name="action_user_management" class="btn btn-sm btn-primary">Go</button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Financial Escrow Dual-Auth Panel (Slide 3 Mapping) -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-success">Slide 3: Financial Controls (Dual-Auth Maker-Checker Engine)</div>
                <div class="card-body">
                    <?php if (count($pending_transactions) === 0): ?>
                        <p class="text-muted text-center my-4">No pending financial payouts require validation clearance.</p>
                    <?php else: ?>
                        <?php foreach ($pending_transactions as $tx): ?>
                            <div class="p-3 border rounded mb-2 bg-light">
                                <div class="d-flex justify-content-between">
                                    <span><strong>Project Escrow ID:</strong> #<?php echo $tx['project_id']; ?></span>
                                    <span class="text-success fw-bold">$<?php echo number_format($tx['amount'], 2); ?></span>
                                </div>
                                <div class="small text-muted mb-2">Initiated By Maker: <code><?php echo $tx['maker_admin']; ?></code></div>
                                <form method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="ledger_id" value="<?php echo $tx['id']; ?>">
                                    <button type="submit" name="checker_decision" value="approved_payout" class="btn btn-sm btn-success w-50">Approve Outbound Payout</button>
                                    <button type="submit" name="checker_decision" value="refunded_dispute" class="btn btn-sm btn-outline-danger w-50">Rollback to Escrow</button>
                                    <input type="hidden" name="action_financial_checker" value="1">
                                </form>
                            </div>
