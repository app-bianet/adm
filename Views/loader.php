<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= libs()?>/css/loader.css">
  <title>Cargando</title>
</head>
<body onload="myFunction()">
<div class='container'>
  <div class='loader'>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--text'></div>
    <div class='container'></div>
  </div>
  <div class='loader'>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--dot'></div>
    <div class='loader--text'></div>
  </div>
</div>
<script>
          let myVar;
          const url_baseL="<?= base_URL()?>";

          function myFunction(){     
            myVar = setTimeout(showPage, 3000);
          }

          function showPage(){
            window.location=url_baseL+'Escritorio';
          }
        </script>
        <script src="<?= libs()?>/js/jquery.min.js">></script>
</body>
</html>