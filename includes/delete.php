<?php
// require 'connect.php'; // or wherever your database connection is

include_once('connect.php');
// Delete Election
if (isset($_POST['delete_election_id'])) {
    $id = intval($_POST['delete_election_id']);

    // Optional: Delete related positions, candidates, votes if you want cascading delete
    // $conn->query("DELETE FROM votes WHERE election_id = $id");
    // $conn->query("DELETE FROM candidates WHERE election_id = $id");
    // $conn->query("DELETE FROM positions WHERE election_id = $id");

    $stmt = $conn->prepare("DELETE FROM elections WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}

// Delete Position
if (isset($_POST['delete_position_id'])) {
    $id = intval($_POST['delete_position_id']);
    // $conn->query("DELETE FROM votes WHERE position_id = $id");
    // $conn->query("DELETE FROM candidates WHERE position_id = $id");

    $stmt = $conn->prepare("DELETE FROM positions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}

// Delete Candidate
if (isset($_POST['delete_candidate_id'])) {
    $id = intval($_POST['delete_candidate_id']);
    // $conn->query("DELETE FROM votes WHERE candidate_id = $id");

    $stmt = $conn->prepare("DELETE FROM candidates WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: ../admin/elections.php");
    exit;
}
?>
