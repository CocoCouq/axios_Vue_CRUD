let app = new Vue({
    el: '#app',
    data: {
        // Edit mode, list of players, error message, new and update player default values
        edit: false,
        list: [],
        newPlayer: {nameAdd: '', scoreAdd: 0},
        editPlayer: {idPlayer: 0, nameEdit: '', scoreEdit: 0},
        message: ''
    },
    mounted: function () {
        // When the app start
        this.getList()
    },
    methods: {
        // Fetch all players
        getList: function () {
            axios.get('api.php?action=read')
                .then(function (response) {
                    if (response.data.error != false) {
                        // Delete error boolean
                        delete response.data.error

                        // Return player in variable list
                        app.list = response.data
                        app.message = ''
                    }
                    else {
                        app.message = 'Problème de connexion au tableau des scores'
                    }

                })
        },
        // Select player for edit form
        selectPlayer: function (player) {
            // Push player value in player edit inputs for v-model
            app.editPlayer.nameEdit = player.name
            app.editPlayer.scoreEdit = player.score
            app.editPlayer.idPlayer = player.id
        },
        // Add new player
        savePlayer: function () {
            // Create the form for new user
            let formData = app.toFormData(app.newPlayer)

            // Inject form in the controller with post method
            axios.post('api.php?action=create', formData)
                .then(function (response) {
                    if (response.data.error != false) {
                        delete response.data.error

                        app.message = `${app.newPlayer.nameAdd} bien ajouté. Chapeau !!`
                        // Reinitialize new user v-model
                        app.newPlayer = {nameAdd: '', scoreAdd: 0}
                        // Return the new list
                        app.list = response.data
                    }
                    else {
                        app.message = 'Renseigne au moins un pseudo'
                    }
                })
        },
        // Edit player
        updatePlayer: function (player) {
            // Edit form
            let formData = app.toFormData(player)

            axios.post('api.php?action=edit', formData)
                .then(function (response) {
                    if (response.data.error != false) {
                        delete response.data.error

                        app.list = response.data
                        app.edit = false
                        app.message = 'Modifications enregistrées'
                    }
                    else {
                        app.message = 'Modification refusée'
                    }
                })
        },
        // Delete player
        deletePlayer: function (player) {
            if (confirm(`Voulez-vous supprimer ${player.name} ?`)) {
                let formData = app.toFormData(player)

                axios.post('api.php?action=delete', formData)
                    .then(function (response) {
                        if (response.data.error != false) {
                            delete response.data.error

                            app.list = response.data
                            app.message = `Vous avez bien supprimé ${player.name}`
                        }
                        else {
                            app.message = 'On ne supprimera pas ce joueur, HORS DE QUESTION !'
                        }
                    })
            }
        },
        // Create the forms with the player object
        toFormData: function (object) {
            // Use FormData object
            let form_data = new FormData()

            for (let key in object) {
                // Reference all objects in form
                form_data.append(key, object[key])
            }

            return form_data
        }
    }
})
