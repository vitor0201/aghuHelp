<script>
var app = angular.module('myApp',[]);
app.controller('productsCtrl', function($scope, $http) {
    // more angular JS codes will be here
    
    $scope.users = [];

    
   
    
	$scope.showCreateForm = function(){
	    // clear form
	    $scope.clearForm();
	     
	    // change modal title
	    $('#modal-product-title').text("Create New Product");
	     
	    // hide update product button
	    $('#btn-update-product').hide();
	     
	    // show create product button
	    $('#btn-create-product').show();
	     
	}

	// clear variable / form values
	$scope.clearForm = function(){
	    $scope.id = "";
	    $scope.name = "";
	    $scope.description = "";
	    $scope.price = "";
	}


	// create new product 
	$scope.createProduct = function(){
	         
	    // fields in key-value pairs
	    $http.post('create_product.php', {
	            'name' : $scope.name, 
	            'description' : $scope.description, 
	            'price' : $scope.price
	        }
	    ).success(function (data, status, headers, config) {
	        console.log(data);
	        // tell the user new product was created
	        Materialize.toast(data, 4000);
	         
	        // close modal
	        $('#modal-product-form').closeModal();
	         
	        // clear modal content
	        $scope.clearForm();
	         
	        // refresh the list
	        $scope.getAll();
	    });
	}

	// read products
	$scope.getAll = function(){
	    $http.get("index.json").success(function(response){
	    	 console.log(response);
	        $scope.users = response.usuarios;
	    });
	}

	// retrieve record to fill out the form
	$scope.readOne = function(id){
	     
	    // change modal title
	    $('#modal-product-title').text("Edit Product");
	     
	    // show udpate product button
	    $('#btn-update-product').show();
	     
	    // show create product button
	    $('#btn-create-product').hide();
	     
	    // post id of product to be edited
	    $http.post('view.json', {
	        'id' : id 
	    })
	    .success(function(data, status, headers, config){

	    	 console.log(data.usuario); 
	        // put the values in form
	        $scope.id = data.usuario["id"];
	        $scope.name = data.usuario["nome"];
	        $scope.description = data.usuario["login"];
	        $scope.price = data.usuario["ativo"];
	         
	        // show modal
	        $('#modal-product-form').openModal();
	    })
	    .error(function(data, status, headers, config){
	        Materialize.toast('Unable to retrieve record.', 4000);
	    });
	}

	// update product record / save changes
	$scope.updateProduct = function(){
	    $http.post('update_product.php', {
	        'id' : $scope.id,
	        'name' : $scope.name, 
	        'description' : $scope.description, 
	        'price' : $scope.price
	    })
	    .success(function (data, status, headers, config){             
	        // tell the user product record was updated
	        Materialize.toast(data, 4000);
	         
	        // close modal
	        $('#modal-product-form').closeModal();
	         
	        // clear modal content
	        $scope.clearForm();
	         
	        // refresh the product list
	        $scope.getAll();
	    });
	}
	
});

$(document).ready(function(){
    // initialize modal
    $('.modal-trigger').leanModal();
});
</script>

<div class="container" ng-app="myApp" ng-controller="productsCtrl">

	<div class="row">
		<div class="col s12">
			<h4>Users</h4>

			<!-- used for searching the current list -->
			<input type="text" ng-model="search" class="form-control"
				placeholder="Search user..." />

			
			
			<!-- table that shows product record list -->
			<table class="hoverable bordered">

				<thead>
					<tr>
						<th class="text-align-center">ID</th>
						<th class="width-30-pct">Name</th>
						<th class="width-30-pct">Login</th>
						<th class="text-align-center">Ativo</th>
						<th class="text-align-center">Action</th>
					</tr>
				</thead>

				<tbody ng-init="getAll()">
					<tr ng-repeat="d in users | filter:search">
						<td class="text-align-center">{{ d.id }}</td>
						<td>{{ d.nome }}</td>
						<td>{{ d.login }}</td>
						<td class="text-align-center">{{ d.ativo }}</td>
						<td><a ng-click="readOne(d.id)"
							class="waves-effect waves-light btn margin-bottom-1em"><i
								class="material-icons left">edit</i>Edit</a> <a
							ng-click="deleteProduct(d.id)"
							class="waves-effect waves-light btn margin-bottom-1em"><i
								class="material-icons left">delete</i>Delete</a></td>
					</tr>
				</tbody>
			</table>

			<!-- modal for for creating new product -->
			<div id="modal-product-form" class="modal">
				<div class="modal-content">
					<h4 id="modal-product-title">Create New User</h4>
					<div class="row">
						<div class="input-field col s12">
							<input ng-model="name" type="text" class="validate"
								id="form-name" placeholder="Type name here..." /> <label
								for="name">Name</label>
						</div>

						<div class="input-field col s12">
							<textarea ng-model="description" type="text"
								class="validate materialize-textarea"
								placeholder="Type description here..."></textarea>
							<label for="description">Login</label>
						</div>

						<div class="input-field col s12">
							<input ng-model="price" type="text" class="validate"
								id="form-price" placeholder="Type price here..." /> <label
								for="price">Status</label>
						</div>

						<div class="input-field col s12">
							<a id="btn-create-product"
								class="waves-effect waves-light btn margin-bottom-1em"
								ng-click="createProduct()"><i class="material-icons left">add</i>Create</a>

							<a id="btn-update-product"
								class="waves-effect waves-light btn margin-bottom-1em"
								ng-click="updateProduct()"><i class="material-icons left">edit</i>Save
								Changes</a> <a
								class="modal-action modal-close waves-effect waves-light btn margin-bottom-1em"><i
								class="material-icons left">close</i>Close</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end col s12 -->
	</div>
	<!-- floating button for creating product -->
	<div class="fixed-action-btn" style="bottom: 45px; right: 24px;">
		<a
			class="waves-effect waves-light btn modal-trigger btn-floating btn-large red"
			href="#modal-product-form" ng-click="showCreateForm()"><i
			class="large material-icons">add</i></a>
	</div>
	<!-- end row -->
</div>
<!-- end container -->