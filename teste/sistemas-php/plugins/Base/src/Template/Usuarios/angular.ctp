 <input type="text" ng-model="nome">
 
 <p>Olá, Tableless! Meu nome é: {{ nome }}</p>
 
 <script>
 function ListaComprasController($scope) {
	    $scope.itens = [
	        {produto: 'Leite', quantidade: 2, comprado: false},
	        {produto: 'Cerveja', quantidade: 12, comprado: false}
	    ];

	    $scope.adicionaItem = function () {
	        $scope.itens.push({produto: $scope.item.produto,
	                           quantidade: $scope.item.quantidade,
	                           comprado: false});
// 	        $scope.item.produto = $scope.item.quantidade = '';
	    };

	    $scope.getAll = function () {
	        $scope.itens.push({produto: $scope.item.produto,
	                           quantidade: $scope.item.quantidade,
	                           comprado: false});
// 	        $scope.item.produto = $scope.item.quantidade = '';
	    };
	}

	

 </script>
 
 <div ng-app  ng-controller="ListaComprasController">
    <table>
      <thead>
        <tr>
          <th>Produto</th>
          <th>Quantidade</th>
        </tr>
      </thead>
      <tbody >
        <tr ng-repeat="item in itens">
          <td><strong>{{ item.produto }}</strong></td>
          <td>{{ item.quantidade }}</td>
        </tr>
      </tbody>
    </table>
    
    <form class="form-inline" name="formItem">
  <input type="text" ng-model="item.produto">
  <input type="number" ng-model="item.quantidade">
  <button ng-click="adicionaItem()">adicionar ítem</button>
</form>
</div>

<form name="myForm">
<span ng-show="myForm.$invalid">
Found erros in the form!
</span>
<input type="text" ng-model="name" name="Name" value="Your Name" required/>
<button ng-disabled="myForm.$invalid"/>Save</button>
</form>
