<template>
    <div>
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{items.all}}</h3>

                <p>{{ local[lang+".info"]["items"] }}</p>
            </div>
            <div class="icon">
                <i class="fas fa-cart-arrow-down"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "Items-Component",
        props: ["auth", "lang","items"],
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
