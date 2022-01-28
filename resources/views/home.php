<!DOCTYPE html>
<html ng-app="usersApp">

<head>
    <title>Usuários</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>



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
                        swal.fire('Ocorreu um erro!')
                    })
                }

                container.update = () => {
                    $http.put(`${base_url}/user/update/${container.form.id}`, container.form).then(function(response) {
                        container.reload()
                        container.form = {}
                    }, function(response) {
                        swal.fire('Ocorreu um erro!')
                    })
                }


                container.destroy = (userId) => {
                    $http.delete(`${base_url}/user/delete/${userId}`).then(function(response) {
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


    <style>
        body {
            background-color: #dcdcdc;
        }

        div.container {
            max-width: 900px;
        }
    </style>
</head>

<body ng-controller="userController as app" class="d-flex flex-column align-items-center justify-content-center">

    <div class="container mt-5">
        <form ng-submit="app.save()">
            <input type="hidden" ng-model="app.form.id">

            <div class="row">
                <div class="col-6">
                    <input required class="form-control" type="text" ng-model="app.form.email" placeholder="mail@example.com">
                </div>
                <div class="col-6">
                    <input class="form-control" type="password" ng-model="app.form.password" placeholder="Senha">
                </div>
            </div>

            <div class="form-group mt-1">
                <button class="btn btn-primary form-control">Salvar</button>
            </div>
        </form>
    </div>

    <div id="userList" class="container">
        <div class="d-flex justify-content-end">
            <button class="btn btn-secondary btn-sm" ng-click="app.reload()"><i class="fas fa-sync-alt"></i></button>
        </div>
        <ul class="list-group w-100 mt-1">
            <li ng-repeat="user in app.list" class="list-group-item d-flex justify-content-between">
                <span class="content d-flex flex-column">
                    <span class="user"><b>Id:</b> </i> {{ user.id }}</span>
                    <span class="email"><b>E-mail:</b> {{ user.email }}</span>
                    <span class="created"><b>Data de criação:</b> {{ user.created_at }}</span>
                    <span class="updated"><b>Data de alteração:</b> {{ user.updated_at }}</span>
                </span>
                <span class="buttons">
                    <button class="btn btn-outline-secondary btn-sm" ng-click="app.destroy(user.id)"><i class="fas fa-trash"></i></button>
                    <button class="btn btn-outline-secondary btn-sm" ng-click="app.toForm(user)"><i class="fas fa-pen"></i></button>
                </span>
            </li>
        </ul>
    </div>
</body>

</html>
