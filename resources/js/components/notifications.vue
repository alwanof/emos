<template>

</template>

<script>
    import CONFIG from "../app";
    export default {
        name: "notifications",
        props:["actor"],
        created() {
          this.newRemoteOrders();

        },
        methods:{
            Notify(title,body){
            var notification = new Notification(title, {
                        icon: 'https://www.kindpng.com/picc/m/169-1699400_svg-png-icon-free-android-notification-icon-png.png',
                        body: body,
                    });
            $.playSound('alert.wav');
        },
            newRemoteOrders(){
                CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 0)
        .where("remote", "==", true)
        .orderBy("timestamp", "asc")
        .onSnapshot((snap) => {
            if (snap.size != 0){
                this.Notify('New Order','New Remote Order');
            }
        });
            },
            newTableOrders(){
                CONFIG.DB.collection("orders")
        .where("user.email", "==", this.actor.email)
        .where("status.value", "==", 0)
        .where("remote", "==", false)
        .orderBy("timestamp", "asc")
        .onSnapshot((snap) => {
            if(snap.size != 0){
                this.Notify('New Order','New Table Order');
            }
        });
            }

        }
    }
</script>


