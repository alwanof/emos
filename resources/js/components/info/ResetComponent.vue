<template>
    <div>
        <h3>Reset Done</h3>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "Reset-Component",
        props: ["auth","lang","rest"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                errors: []
            };
        },
        created() {

            CONFIG.DB.collection('orders')
            .where('user.email','==',this.rest.email).get()
            .then(snap=>{
                snap.forEach(doc=>{
                    CONFIG.DB.collection('orders').doc(doc.data().orderID).delete()
                    .then(()=>{
                        console.log('delete',doc.data().orderID);
                    });
                });
            });

        },

    };
</script>

<style scoped>
</style>
