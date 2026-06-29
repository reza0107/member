<?php

/** @var string|null $grup */
$grup = $grup ?? '';
?>

<html>

<head>
   <title>Rekap Absen <?= esc($grup) ?></title>
   <style>
      body {
         font-family: Arial, Helvetica, sans-serif;
      }

      table {
         border-collapse: collapse;
      }
   </style>
</head>


<body>

   <?= $this->renderSection('content') ?>

</body>

</html>