<?php require $_SERVER['DOCUMENT_ROOT']."/repair-system/vendor/autoload.php";?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDO Basic</title>
	<!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body class="font-mali">
	<div class="container">
		<div class="row mt-5">
			<div class="col">
				<div class="card mb-3">
					<h4 class="card-header bg-primary text-white">PHP PDO</h4>
					<div class="card-body">
						<table class="table">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Password</th>
								</tr>
							</thead>
							<tbody>
								<?php
									use App\Model\account;

									$personObj = new account();
									$persons = $personObj->getAllPersons();
									$n=0;
									foreach($persons as $person) {
										$n++;
										echo "
											<tr>
												<td>{$n}</td>
												<td>{$person['username']}</td>
												<td>{$person['password']}</td>
											</tr>
										";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>