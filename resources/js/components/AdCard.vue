<template>
    <v-card class="mt-4" :height="expanded ? 650 : 550" :href="'/details/' + ad.id">
        <v-img
            v-if="ad.image!=null"
            height="250"
            :src="ad.image"
        ></v-img>

        <v-card-title class="d-inline-block" :class="!expanded ? 'text-truncate' : ''" style="width: 100%;">
            {{ ad.title }}
        </v-card-title>

        <v-card-text>
            <div v-if="ad.price!=null" class="subtitle-1">
                Precio: {{ ad.price }} €
            </div>

            <div v-if="ad.price != null" class="subtitle-1">
                Ubicación: {{ ad.location }}
            </div>

            <span v-if="!expanded">
                {{ ad.description.substring(0, 140)}}...
            </span>

            <span v-else>
                {{ ad.description }}
            </span>

            <v-chip-group>
                <v-chip v-for="tag in ad.tags" key="tag">{{ tag }}</v-chip>
            </v-chip-group>
        </v-card-text>

        <v-card-actions v-if="!expanded">
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
    props: ['ad', 'expand'],
    data() {
        return {
            expanded: this.expand !== undefined && this.expand
        };
    },
    created() {
        this.ad.tags = JSON.parse(this.ad.tags);
    },
    methods: {},
}
</script>
