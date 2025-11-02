1  <?php
2  include 'db.php'; // kobler til databasen – endre hvis filen din heter noe annet
3  
4  $msg = '';
5  $err = '';
6  $antStudenter = 0;
7  
8  // Hent alle klasser til nedtrekkslista
9  $sql = "SELECT klassekode, klassenavn FROM klasse ORDER BY klassekode";
10 $result = $conn->query($sql);
11 $klasser = [];
12 if ($result && $result->num_rows > 0) {
13     while ($row = $result->fetch_assoc()) {
14         $klasser[] = $row;
15     }
16 }
17 
18 // Når bruker trykker "Slett"
19 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
20     $klassekode = $_POST['klassekode'] ?? '';
21 
22     if (!empty($klassekode)) {
23         // sjekk om klassen har studenter
24         $sjekk = $conn->prepare("SELECT COUNT(*) AS antall FROM student WHERE klassekode = ?");
25         $sjekk->bind_param("s", $klassekode);
26         $sjekk->execute();
27         $result = $sjekk->get_result()->fetch_assoc();
28         $antStudenter = $result['antall'];
29 
30         if ($antStudenter > 0) {
31             $err = "Kan ikke slette klassen fordi den har registrerte studenter ($antStudenter).";
32         } else {
33             // slett klassen
34             $stmt = $conn->prepare("DELETE FROM klasse WHERE klassekode = ?");
35             $stmt->bind_param("s", $klassekode);
36             if ($stmt->execute()) {
37                 $msg = "Klassen '$klassekode' ble slettet.";
38             } else {
39                 $err = "Noe gikk galt under sletting.";
40             }
41         }
42     } else {
43         $err = "Du må velge en klasse først.";
44     }
45 }
46 ?>
47 <!doctype html>
48 <html lang="no">
49 <head>
50 <meta charset="utf-8">
...
