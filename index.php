<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<title>Tennis Competition</title>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">&nbsp;</div>
		</div>
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-10">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h4>
							Tennis Competition
							<a class="btn btn-primary btn-xs" href="javascript:execComp();" role="button">Execute Competition</a>
							<a class="btn btn-primary btn-xs" href="javascript:clearResults();" role="button">Clear Results</a>
						</h4>
					</div>
					<div class="panel-body" id="results">
						<p class="text-center"><strong>Results will be displayed here.</strong></p>
					</div>
				</div>
			</div>
			<div class="col-md-1"></div>
		</div>
	</div>

	
	<script>
		function execComp() {
			$.ajax({ url: 'service/tennis.php',
				type: 'get',
				dataType: "json",
				success: function(data) {
					$('#results').html('<div style="overflow:scroll; height:100%;"><ul id="feedback" style="list-style: none;"></ul></div>');
					$.each(data, function(i, item) {
						$('#feedback').append('<li>'+item+'</li>');
					});
				}
			});
		}

		function clearResults() {
			$('#results').html('<p class="text-center"><strong>Results will be displayed here.</strong></p>');
		}
	</script>
</body>
</html>


