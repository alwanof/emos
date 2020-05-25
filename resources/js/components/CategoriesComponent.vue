<template>
    <div>
        <a :href="'#cat-'+feed.id" v-for="(feed,index) in feeds" :key="feed.id" onclick="closeNav()">
            {{feed.name}}
        </a>
    </div>
</template>
<script>
    import CONFIG from "../app";
    export default {
        name: "CategoriesComponent",
        props: ["rest"],
        data() {
            return {
                path: CONFIG.PATH,
                fullPath:CONFIG.FULL_PATH,
                loading: false,
                feeds: [],
            };
        },
        created() {
            this.getResults();
        },
        methods: {
            getResults() {
                this.loading = true;
                axios
                    .get(
                        CONFIG.API_URL +
                        "menu/cats/"+this.rest
                    )
                    .then(res => {
                        this.feeds = res.data;
                        this.loading = false;
                    });
            },

        }
    };
</script>

<style scoped>
</style>
