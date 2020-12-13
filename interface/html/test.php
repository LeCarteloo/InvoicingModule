<html>
<head>
</head>
<body>
<div id="id01"></div>
<?php
$json = file_get_contents("http://localhost/Project/api/contractor/readContractor.php");
$data = json_decode($json);

print "<PRE>";
print_r($data);


 ?>
</body>
</html>
