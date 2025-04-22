<?php include("config.php"); ?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HKHK spordipäev 2025</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <h1>HKHK SPORDIPÄEV 2025</h1>

    <form action="index.php" method="get">
        Nimi: <input type="text" name="fullname"><br>
        Email: <input type="text" name="email"><br>
        Vanus: <input type="number" name="age" min="16" max="88" step="1"><br>
        Sugu: <input type="text" name="gender" maxlength="20"><br>
        Spordiala: <input type="text" name="category" maxlength="20"><br>
        <input type="submit" value="Salvesta" class="btn btn-primary"><br>
    </form>

    <?php
    if (isset($_GET["fullname"]) && !empty($_GET["fullname"])) {
        $fullname = $_GET["fullname"];
        $email = $_GET["email"];
        $age = $_GET["age"];
        $gender = $_GET["gender"];
        $category = $_GET["category"];

        $lisa_paring = "INSERT INTO sport2025 (id, fullname, email, age, gender, category, reg_time) 
                        VALUES (NULL, '$fullname', '$email', '$age', '$gender', '$category', current_timestamp())";

        $saada_paring = mysqli_query($yhendus, $lisa_paring);

        $tulemus = mysqli_affected_rows($yhendus);
        if ($tulemus == 1) {
            echo "Kirje edukalt lisatud";
        } else {
            echo "Kirjet ei lisatud";
        }
    }
    ?>

    <form action="index.php" method="get" class="py-4">
      <input type="text" name="otsi">
      <select name="cat">
        <option value="fullname">Nimi</option>
        <option value="category">Spordiala</option>
      </select>
      <input type="submit" value="Otsi">
    </form>
    <br>

    <table class="table table-striped">
      <tr>
        <th>id</th>
        <th>fullname</th>
        <th>email</th>
        <th>age</th>
        <th>gender</th>
        <th>category</th>
        <th>reg_time</th>
        <th>muuda</th>
        <th>kustuta</th>
      </tr>

      <?php
        if (isset($_GET["otsi"]) && !empty($_GET["otsi"])) {
            $s = $_GET["otsi"];
            $cat = $_GET["cat"];
            echo "Otsing: " . htmlspecialchars($s);
            $paring = "SELECT * FROM sport2025 WHERE $cat LIKE '%$s%'";
        } else {
            $paring = "SELECT * FROM sport2025 LIMIT 50";
        }

        $saada_paring = mysqli_query($yhendus, $paring);

        while ($rida = mysqli_fetch_assoc($saada_paring)) {
            echo "<tr>";
            echo "<td>" . $rida['id'] . "</td>";
            echo "<td>" . $rida['fullname'] . "</td>";
            echo "<td>" . $rida['email'] . "</td>";
            echo "<td>" . $rida['age'] . "</td>";
            echo "<td>" . $rida['gender'] . "</td>";
            echo "<td>" . $rida['category'] . "</td>";
            echo "<td>" . $rida['reg_time'] . "</td>";
            echo "<td><a class='btn btn-success' href='#'>Muuda</a></td>";
            echo "<td><a class='btn btn-danger' href='#'>Kustuta</a></td>";
            echo "</tr>";
        }
      ?>
    </table>
  </div>
  </body>
</html>
