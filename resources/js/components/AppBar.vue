<template>
    <v-app-bar dense>
        <v-app-bar-title>
            <a href="/">{{ title }}</a>
        </v-app-bar-title>

        <v-spacer></v-spacer>

        <div v-if="user === undefined">
            <v-btn href="/login" rounded small class="mr-2">
                Login
                <v-icon right small>mdi-account</v-icon>
            </v-btn>

            <v-btn href="/register" rounded small>
                Registro
                <v-icon right small>mdi-login</v-icon>
            </v-btn>
        </div>

        <div v-else>
            <span class="mr-8">{{ user.name }}</span>

            <v-btn icon @click="logout">
                Salir
                <v-icon right class="mx-1">mdi-logout</v-icon>
                <form id="logout-form" action="logout" method="POST" class="d-none">
                    @csrf
                </form>
            </v-btn>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            </div>
        </div>
    </v-app-bar>
</template>

<script>
export default {
    props: ['title', 'user'],
    data: () => ({
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    }),
    methods: {
        logout() {
            axios.post('/logout', {_token: this.csrf})
                .then(function (response) {
                    window.location.reload();
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
}
</script>

