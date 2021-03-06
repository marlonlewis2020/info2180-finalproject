<?php
require_once 'includes/dbconnect.php';

$error_msg = "";
do {
    if (!isset($_SESSION['id'])) {
        $error_msg = "NOT-LOGGED-IN::";
        include 'includes/login.php';
        break;
    }

    if (isset($update_error)) {
        $error_msg = $update_error;
        break;
    }

    $issueid = filter_input(INPUT_GET, 'issueid', FILTER_SANITIZE_STRING);
    if (empty($issueid)) {
        $error_msg = "Critical Error:: Unknown Issue ID ...";
        break;
    } else {
        $issueid = htmlspecialchars($issueid);
    }

    if (!$conn) {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        if (!$conn) {
            $error_msg = "Critical Error:: Unable to access Database ...";
            break;
        }
    }

    $stmt = $conn->query("SELECT * FROM issues join " .
            "(select id as cid, firstname as cfn, lastname as cln FROM users) AS cby on " .
            "cby.cid=issues.created_by " .
            "join (select id as aid, firstname as afn, lastname as aln FROM users) as ato " .
            " on ato.aid=issues.assigned_to WHERE issues.id=" . $issueid . ";");

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $updated = new DateTime($row['updated'], new DateTimeZone('-0400'));
    $created = new DateTime($row['created'], new DateTimeZone('-0400'));

    if ($stmt->rowCount() === 0) {
        $error_msg = "Critical Error:: Issue ID not found in Database ...";
        break;
    }
} while (false);
?>    

<?php if ($error_msg !== "NOT-LOGGED-IN::"): ?>
    <?php if (!empty($error_msg)): ?>
        <div class="queryerror"><?= $error_msg ?></div>
    <?php endif; ?>
    <div class = "container-k">
        <h1 class = "issuename"><?= $row['title'] ?></h1>
        <h3 class = "issueno">Issue #<?= (empty($row['id']) ? $issueid : $row['id']) ?></h3>
        <div class = "issue">
            <p class = "pg"><?= $row['description'] ?></p>
            <ul class = "liststyle"> 
                <li><span class="material-icons">chevron_right</span>Issue created on 
                    <?= $created->format("F j, Y");?>&nbsp;at&nbsp;<?=$created->format("g:iA") ; ?>
                    by <?= ucfirst($row['cfn']) ?>&nbsp;<?= ucfirst($row['cln']) ?>.</li>
                <li><span class="material-icons">chevron_right</span>Last Updated on 
                    <?= $updated->format("F j, Y");?>&nbsp;at&nbsp;<?=$created->format("g:iA") ; ?></li>
            </ul>
        </div>
        <div class = "issueinfo">
            <aside>
                <div>
                    <span class = "heading detail">Assigned To:</span>
                    <span class = "detail"><?= ucfirst($row['afn']) ?>&nbsp;<?= ucfirst($row['aln']) ?></span>
                </div>
                <div>
                    <span class = "heading detail">Type:</span>
                    <span class = "detail"><?= $row['type'] ?></span>
                </div>
                <div>
                    <span class = "heading detail">Priority:</span>
                    <span class = "detail"><?= $row['priority'] ?></span>
                </div>
                <div>
                    <span class = "heading detail">Status:</span>
                    <span class = "detail"><?= $row['status'] ?></span>
                </div>
            </aside>
            <button class = "btn-closed btn-k" data-issueid="<?= $row['id'] ?>">Mark as Closed</button>
            <button class = "btn-progress btn-k-2" data-issueid="<?= $row['id'] ?>">Mark In Progress</button>
        </div>
    </div>
    <?php
endif;
$conn = null;
?>
