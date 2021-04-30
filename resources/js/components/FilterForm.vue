<template>
    <v-row>
        <v-col cols="12">
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
            >
                <v-row>
                    <v-col cols="6" md="4">
                        <v-text-field
                            v-model="search"
                            :rules="searchRules"
                            label="Busqueda"
                            required
                        ></v-text-field>
                    </v-col>

                    <v-col cols="6" md="4">
                        <v-select
                            v-model="selectedCategory"
                            :items="categories"
                            item-text="name"
                            item-value="id"
                            label="Todas las categorias"
                            required
                        ></v-select>
                    </v-col>

                    <v-col cols="4" offset="2" offset-md="0" md="2">
                        <v-checkbox
                            v-model="freeShipping"
                            label="Envio gratis"
                            required
                        ></v-checkbox>
                    </v-col>

                    <v-col cols="4" md="2" align-self="center">
                        <v-btn
                            :disabled="!valid"
                            color="success"
                            @click="submit"
                        >
                            Buscar
                        </v-btn>
                    </v-col>
                </v-row>
            </v-form>
        </v-col>
        <v-col cols="4" sm="3" v-for="(category, key) in categories" :key="category.id">
            <v-avatar @click="searchCategory(category.id)">
                <img
                    :src="category.icon"
                    :alt="category.name"
                >
            </v-avatar>
            <br>
            <span>{{ category.name }}</span>
        </v-col>
    </v-row>

</template>

<script>
export default {
    props: ['categories', 'currentSearch'],
    data: () => ({
        valid: true,
        search: '',
        searchRules: [
            v => !!v && v.trim() !== '' || 'Busqueda requerida',
        ],
        selectedCategory: 'all',
        freeShipping: false,
    }),
    created() {
        console.log(this.currentSearch);
        if (this.currentSearch !== undefined) {
            this.search = this.currentSearch.text;
            this.selectedCategory = this.currentSearch.category;
            this.freeShipping = this.currentSearch.freeShipping;
        }
    },
    methods: {
        submit() {
            if (this.$refs.form.validate()) {
                window.location = `/search?text=${this.search}&category=${this.selectedCategory}&freeShipping=${this.freeShipping}`;
            }
        },
        searchCategory(categoryId) {
            window.location = `/search?category=${categoryId}`;
        }
    },
}
</script>
