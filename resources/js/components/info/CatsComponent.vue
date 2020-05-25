<template>
    <div>
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{cats.all}}</h3>

                <p>{{ local[lang+".info"]["categories"] }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-code-branch"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "Cats-Component",
        props: ["auth", "lang","cats"],
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
