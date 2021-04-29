<template>
    <v-card class="mt-4" height="550" :href="'/details/' + ad.id">
        <v-img
            v-if="ad.image!=null"
            height="250"
            :src="ad.image"
        ></v-img>

        <v-card-title class="d-inline-block text-truncate" style="max-width: 90%;">
            {{ ad.title }}
        </v-card-title>

        <v-card-text>
            <div v-if="ad.price!=null" class="subtitle-1">
                Precio: {{ ad.price }} €
            </div>

            <div v-if="ad.price!=null" class="subtitle-1">
                Ubicación: {{ ad.location }}
            </div>

            <span>
                {{ ad.description.substring(0, 144)}}...
            </span>

            <v-chip-group>
                <v-chip v-for="tag in ad.tags" key="tag">{{ tag }}</v-chip>
            </v-chip-group>
        </v-card-text>

        <v-card-actions>
            <v-btn
                color="deep-purple lighten-2"
                text
                href="details/"
            >
                Detalles
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
export default {
    props: ['ad'],
    data() {
        return {};
    },
    created() {
        this.ad.tags = JSON.parse(this.ad.tags);
    },
    methods: {},
}
</script>
