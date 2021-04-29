<template>
    <v-app-bar dense>
        <v-app-bar-title>
            <a href="/">{{ title }}</a>
        </v-app-bar-title>

        <!--v-text-field
            prepend-inner-icon="mdi-magnify"
            v-model="searchText"
            dense flat
            clearable
            single-line
            outlined
        /-->

        <v-spacer></v-spacer>

        <v-btn href="login" rounded small class="mr-2">
            Login
            <v-icon right small>mdi-heart</v-icon>
        </v-btn>

        <v-btn href="register" rounded small>
            Registro
            <v-icon right small>mdi-magnify</v-icon>
        </v-btn>

        <li v-if="user != ''" class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                {{ user.name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="logout"
                   @click="event.preventDefault();
                   document.getElementById('logout-form').submit();">
                    Salir
                </a>

                <form id="logout-form" action="logout" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </v-app-bar>
</template>

<script>
export default {
    props: ['title', 'user'],
    data() {
        return {
            searchText: '',
        };
    },
    mounted() {
        console.log('user', this.user);
        console.log('AppBar mounted.')
    }
}
</script>

