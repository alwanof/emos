<template>
    <div>
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ordersSize}}</h3>

                <p>{{ local[lang+".info"]["orders"] }}<i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i></p>
            </div>
            <div class="icon">
                <i class="fas fa-concierge-bell"></i>
            </div>
        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "OrdersCardComponent",
        props: ["auth", "lang"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                ordersSize:0,
                errors: []
            };
        },
        created() {
            this.loading = true;

            const today= new Date();
            today.setDate(today.getDate() - 1);
            //const today = new Date(1555653600000);*/

            CONFIG.DB.collection('orders')
                .where('user.email','==',this.auth.email)
                .where('timestamp','>',today).onSnapshot(snapshot => {
                //snapshot.forEach(doc=>{});

                this.ordersSize=snapshot.size;
                this.loading = false;
            });

        },

        methods: {

        }
    };
</script>

<style scoped>
</style>
