<?php
require_once 'db.php'; // kobler til databasen
?>

<!DOCTYPE html>
<html lang="no">
<head>
  <meta charset="UTF-8">
  <title>Slett student</title>
  <style>
    body {
      font-family: system-ui, Arial;
      margin: 0;
      background: #f5f6fa;
      color: #222;
      padding: 30px;
    }
    .form {
      max-width: 420px;
      margin: auto;
      background: #fff;
      border: 1px solid #e6e8ec;
      border-radius: 10px;
      padding: 24px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, .08);
    }
    h2 { text-align: center; margin-bottom: 16px; }
    label { display: block; margin-bottom: 8px; font-weight: 600; }
    select, button {
      width: 100%;
      padding: 10px;
      font-size: 15px;
      border-radius: 8px;
    }
    select {
      border: 1px solid #ccc;
      margin-bottom: 14px;
    }
    button {
      background: #111;
      color: white;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background: #333;
    }
    .msg {
      margin-bottom: 14px;
      padding: 10px;
      border-radius: 6px;
      text-align: center;
    }
    .ok { background: #e8f5e9; color: #2e7d32; }
    .err { background: #fdecea; color: #c62828; }
    .warn { background: #fff3cd; color: #856404; }
    p.link { text-align: center; margin-top: 10px; }
    a { color: #2563eb; text-decoration: none; }
  </style>
</head>
<body>
<div class="form">
  <h2>Slett student</h2>

  <?php
  // Hvis skjemaet er sendt inn
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $student_id = $_POST["student_id"] ?? "";

      if ($student_id === "") {
          echo "<div class='msg err'>Du må velge en student.</div>";
      } else {
          // Slett studenten
          $stmt = $conn->prepare("DELETE FROM student WHERE student_id = ?");
          $stmt->bind_param("i", $student_id);
          $stmt->execute();

          if ($stmt->affected_rows > 0) {
              echo "<div class='msg ok'>Studenten ble slettet!</div>";
          } else {
              echo "<div class='msg warn'>Fant ingen student med den ID-en.</div>";
          }

          $stmt->close();
      }
  }
  ?>

  <form method="post" onsubmit="return confirm('Er du sikker på at du vil slette denne studenten?');">
    <label for="student_id">Velg student</label>
    <select name="student_id" id="student_id" required>
      <option value="">Velg student</option>
      <?php
      // Henter alle studenter fra databasen
      $result = $conn->query("SELECT student_id, fornavn, etternavn FROM student ORDER BY etternavn");

      if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              $id = htmlspecialchars($row['student_id']);
              $navn = htmlspecialchars($row['fornavn'] . " " . $row['etternavn']);
              echo "<option value='$id'>$navn</option>";
          }
      } else {
          echo "<option disabled>Ingen studenter funnet</option>";
      }
      ?>
    </select>

    <button type="submit">Slett student</button>
  </form>

  <p class="link"><a href="index.php">← Tilbake</a></p>
</div>
</body>
</html>