<template>
    <v-card class="mt-4" height="550">
        <v-img
            height="250"
            :src="ad.image"
        ></v-img>

        <v-card-title>{{ ad.title }}</v-card-title>

        <v-card-text>
            <div class="my-4 subtitle-1">
                {{ ad.price }} € - {{ ad.location }}
            </div>

            <span style="text-overflow: ellipsis">{{ ad.description }}</span>

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
