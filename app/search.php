<!DOCTYPE html>
<html ng-app="App" ng-controller="appCtrl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
	<title>Поиск репозиториев на GitHub</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="angular.min.js"></script>
	<script>
		var appModule = angular.module("App", []);
		appModule.controller("appCtrl", ["$scope", "$http", function($scope, $http) {
			// Правила поиска
			$scope.formFilter = {};
			$scope.formFilter.fields = ["size", "forks", "stars", "followers"];
			$scope.formFilter.operators = [">", "<", "="];
			$scope.formFilter.rules = [];

			// Добавляется пустое правило
			$scope.addRule = function() {
				$scope.formFilter.rules.push({"field":"", "operator":"", "value":""});
			};

			// Удаление правила
			$scope.delRule = function(index) {
				$scope.formFilter.rules.splice(index, 1)
			};

			// Удаление всех правил
			$scope.clearRules = function() {
				$scope.formFilter.rules = [];
				$scope.addRule();
			};

			// Поиск
			$scope.searchGit = function() {
				var url = "search_git.php";
				var fd = new FormData();
				fd.append("rules", angular.toJson($scope.formFilter.rules));
				$http({
					method: "POST",
					url: url,
					data: fd,
					transformRequest: angular.identity,
					headers: {'Content-Type': undefined}
				}).then( function (response) {
					if (response.status == 200) {
						var obj = angular.fromJson(response.data);
						console.log(obj);
						$scope.items = obj.items;
						console.log($scope.items);
					}
					else {
						console.log(response);
					}
				}, function (response) {
					console.log(response);
				});
			}

			// Init
			$scope.addRule();
		}]);
	</script>
</head>
<body>
	<div class="container">

		<div class="row">
			<div class="col-12 offset-lg-1 col-lg-10">
				<h3 class="my-3">Поиск репозиториев на GitHub</h3>
				<hr>
				<div class="form-row" ng-repeat="rule in formFilter.rules">
					<div class="col-auto my-1">
						<select class="custom-select"
							ng-model="rule.field"
							ng-options="o  for o in formFilter.fields">
						</select>
					</div>
					<div class="col-auto my-1">
						<select class="custom-select"
							ng-model="rule.operator"
							ng-options="o  for o in formFilter.operators">
						</select>
					</div>
					<div class="col-auto my-1">
						<input type="text" class="form-control" ng-model="rule.value" placeholder="Value...">
					</div>
					<div class="col-auto my-1">
						<button type="button" class="btn btn-danger" ng-click="delRule($index)">Delete</button>
					</div>
				</div>
				<hr>
				<div class="form-row">
					<div class="col-12 my-1">
						<button type="button" class="btn btn-primary" ng-click="searchGit()">Apply</button>
						<button type="button" class="btn btn-warning" ng-click="clearRules()">Clear</button>
						<button type="button" class="btn btn-success float-right" ng-click="addRule()">Add Rule</button>
					</div>
				</div>
			</div>
		</div>

		<div class="row">

		<table class="table">
			<thead>
				<tr>
					<th>название</th>
					<th>размер</th>
					<th>число форков</th>
					<th>followers</th>
					<th>звезд</th>
				</tr>
			</thead>
			<tbody>
				<tr  ng-repeat="item in items">
					<td>{{item.name}}</td>
					<td>{{item.size}}</td>
					<td>{{item.forks_count}}</td>
					<td>{{item.watchers}}</td>
					<td>{{item.stargazers_count}}</td>
				</tr>
			</tbody>
		</table>

		</div>

	</div>
</body>
</html>
