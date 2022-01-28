<!DOCTYPE html>
<html ng-app="usersApp">

<head>
    <title>Usuários</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>


    <script>
        angular.module('usersApp', []).controller(
            'userController', ['$http', function($http) {
                var container = this
                let base_url = 'http://multipedidos.local'

                container.create = () => {
                    $http.post(`${base_url}/user/store`, container.form).then(function(response) {
                        container.reload()
                        container.form = {}
                    }, function(response) {
                        console.log(response.data)
                    })
                }

                container.update = () => {
                    $http.put(`${base_url}/user/update/${container.form.id}`, container.form).then(function(response) {
                        container.reload()
                        container.form = {}
                    }, function(response) {
                        console.log(response.data)
                    })
                }


                container.destroy = (userId) => {
                    $http.delete(`${base_url}/user/delete/${userId}`).then(function(response) {
                        console.log(response)
                        container.reload()
                    })
                }


                container.reload = () => {
                    $http.get(`${base_url}/user`).then(function(response) {
                        container.list = response.data.map(u => {
                            return {
                                id: u.id,
                                email: u.email,
                                created_at: new Date(u.created_at).toLocaleDateString(),
                                updated_at: new Date(u.updated_at).toLocaleDateString(),
                            }
                        })
                    })
                }


                container.toForm = (user) => {
                    container.form = user
                }


                container.save = () => {
                    if (container.form.id)
                        container.update()
                    else
                        container.create()
                }


                container.reload();

            }])
    </script>
</head>

<body ng-controller="userController as app">
    <form ng-submit="app.save()">
        <input type="hidden" ng-model="app.form.id">
        <input required type="text" ng-model="app.form.email" placeholder="mail@example.com">
        <input type="password" ng-model="app.form.password">
        <input class="btn-primary" type="submit" value="Salvar">
    </form>

    <div id="userList">
        <button ng-click="app.reaload()">recarregar</button>

        <li ng-repeat="user in app.list">
            <span class="user">{{ user.id }}</span>
            <span class="email">{{ user.email }}</span>
            <span class="created">{{ user.created_at }}</span>
            <span class="updated">{{ user.updated_at }}</span>
            <button ng-click="app.destroy(user.id)">Excluir</button>
            <button ng-click="app.toForm(user)">Alterar</button>
        </li>
    </div>
</body>

</html>
