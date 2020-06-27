<template>
    <div>
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{feeds}}</h3>

                <p>{{ local[lang+".info"]["tables"] }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-chess-board"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "Table-Component",
        props: ["auth", "lang"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                feeds:0,

                errors: []
            };
        },
        created() {
            this.loading = true;
            axios
                .get(
                    CONFIG.API_URL +
                    "sta/tables?api_token="+this.auth.api_token
                )
                .then(res => {
                    this.feeds = res.data;
                    this.loading = false;
                });

        },

        methods: {

        }
    };
</script>

<style scoped>
</style>
