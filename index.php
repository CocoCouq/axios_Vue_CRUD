<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <title>Vue CRUD</title>
</head>
<body>

<main>

    <div id="app">
        <section class="">
            <div class="row valign-wrapper grey z-depth-3">
                <h1 class="center-align col s8">Scores</h1>
                <article class="col s3">

    <!--                /// ADD PLAYER ///              -->

                    <!-- Modal Trigger -->
                    <a class="btn-large modal-trigger white black-text" href="#modalAdd">Ajouter</a>

                    <!-- Modal Structure -->
                    <div id="modalAdd" class="modal">
                        <div class="modal-content">
                            <h4 class="center-align">Ajouter un joueur</h4>
                            <section class="row">
                                <div class="input-field col s6">
                                    <input id="nameAdd" name="nameAdd" type="text" v-model="newPlayer.nameAdd" class="validate">
                                    <label for="nameAdd">Nom</label>
                                </div>
                                <div class="input-field col s6">
                                    <input id="scoreAdd" name="scoreAdd" type="number" v-model="newPlayer.scoreAdd" class="validate">
                                    <label for="scoreAdd">Score</label>
                                </div>
                            </section>
                        </div>
                        <div class="modal-footer">
                            <button class="btn-flat modal-close" @click="savePlayer">Ajouter</button>
                            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Annuler</a>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        <section class="divider section"></section>

        <section class="container section" id="listPlayer">

<!--                /// EDIT PLAYER ///              -->

            <div class="row" v-if="edit">
                <label class="col s6" for="nameEdit">
                    <input id="nameEdit" name="nameEdit" type="text" class="validate" v-model="editPlayer.nameEdit">
                </label>

                <label class="col s6" for="scoreEdit">
                    <input id="scoreEdit" name="scoreEdit" type="number" class="validate" v-model="editPlayer.scoreEdit">
                </label>
                <input type="hidden" name="idPlayer" v-model="editPlayer.idPlayer">
                <div class="center-align">
                    <button class="waves-effect waves-light btn modal-trigger blue" @click="updatePlayer(editPlayer)">Valider</button>
                </div>
            </div>

<!--                ERROR MESSAGE              -->
            <p class="card-panel center-align" v-if="message">{{message}}</p>

<!--                /// LIST PLAYERS ///              -->

            <table class="responsive-table centered striped blue-grey lighten-4">
                <thead>
                <tr>
                    <th></th>
                    <th class="flow-text">Nom</th>
                    <th class="flow-text">Score</th>
                    <th></th>
                </tr>
                </thead>

                <tbody class="blue-grey darken-4 white-text">
                <tr v-for="player in list">
                    <td>
                        <button class="btn red" @click="deletePlayer(player)">
                            Supprimer
                        </button>
                    </td>
                    <td>{{player.name}}</td>
                    <td>{{player.score}}</td>
                    <td>
                        <button class="waves-effect waves-light btn modal-trigger blue" @click="selectPlayer(player);edit=true">modifier</button>
                    </td>
                </tr>
                </tbody>
            </table>

        </section>
    </div>

</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/js/index.js"></script>

</body>
</html>
