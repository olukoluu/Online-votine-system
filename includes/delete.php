<?php

include_once('connect.php');
// Delete Election
if (isset($_POST['delete_election_id'])) {
    $id = intval($_POST['delete_election_id']);
    $stmt = $conn->prepare("DELETE FROM elections WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}

// Delete Position
if (isset($_POST['delete_position_id'])) {
    $id = intval($_POST['delete_position_id']);
    $stmt = $conn->prepare("DELETE FROM positions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}

// Delete Candidate
if (isset($_POST['delete_candidate_id'])) {
    $id = intval($_POST['delete_candidate_id']);
    $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}
?>
