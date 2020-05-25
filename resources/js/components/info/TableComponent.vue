<template>
    <div>
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{tables.all}}</h3>

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
        props: ["auth", "lang","tables"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,

                errors: []
            };
        },
        created() {

        },

        methods: {

        }
    };
</script>

<style scoped>
</style>
