<template>
    <div class="container">
        <div id="sound"></div>
        <div class="text-center h4">
            <i class="fas fa-cog fa-spin px-2 text-primary" v-show="loading"></i>
        </div>
        <div class="row">
            <div class="card-columns" >

                <div class="card card-widget" v-for="(order,index) in orders" :key="index" >
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div :class="'widget-user-header p-3 bg-'+colorOrder(order.status.value)">

                        <!-- /.widget-user-image -->
                        <h4 class="widget-user-username">
                            <span class="badge badge-dark float-left m-1">#{{order.orderID.substring(0, 4)}}</span>
                            <span class="badge badge-dark m-1 float-right"> {{order.total+' ₺'}}</span>

                        </h4>
                        <h5 v-show="acl.isAdmin" class="widget-user-desc">{{order.user.name}}</h5>
                        <h5 class="widget-user-desc">{{order.table.name}}</h5>

                    </div>
                    <div class="card-body p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item p-2" v-for="(item,indexItem) in order.items" :key="item.id">
                                    {{item.title}} <span class="float-right badge bg-primary">{{item.amount}}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <span v-show="acl.order_pickitup">
                           <button type="button" @click="pickUp(order.orderID)" v-show="order.status.value==0" class="btn btn-danger">{{local[lang+".orders"]["pick_up"]}}</button>
                        </span>
                        <span v-show="acl.order_handover">
                           <button type="button" @click="handOver(order.orderID)" v-show="order.status.value==1" class="btn btn-success">{{local[lang+".orders"]["hand_over"]}}</button>
                        </span>
                    </div>
                </div>

            </div>
        </div>


    </div>
</template>
<script>
    import CONFIG from "../app";
    export default {
        name: "OrderComponent",
        props: ["acl","lang","auth"],
        data() {
            return {
                path: CONFIG.PATH,
                fullPath:CONFIG.FULL_PATH,
                local: CONFIG.LANG,
                loading: false,
                orders: [],
            };
        },
        created() {
            this.getResults();
        },
        methods: {
            getResults() {
                this.loading = true;
                let query;
                if(this.acl.isAdmin){
                    query=CONFIG.DB.collection('orders');
                }else{
                    query=CONFIG.DB.collection('orders').where('user.email','==',this.auth.email);
                }
                query.where('status.value','<=',2)
                    .orderBy('status.value')
                    .orderBy('status.timestamp',"desc")
                    .limit(50)
                    .onSnapshot(snap=> {


                        if (snap.size == 0) {
                            this.loading = false;
                            return 0;
                        }
                        snap.forEach(doc=>{

                            let isExist = this.orders.find(o => o.orderID === doc.data().orderID);
                            if(!isExist){
                                this.orders.push(doc.data());
                                this.playSound('https://2urkey.com/sounds/bing');
                            }else{

                                const index=this.orders.indexOf(isExist);
                                this.orders.splice(index, 1);
                                this.orders.push(doc.data());

                            }

                        });
                        this.loading = false;

                    });
            },
            pickUp(orderID){
                this.loading = true;
                CONFIG.DB.collection('orders')
                    .doc(orderID)
                    .update({
                        'status.value':1,
                        'status.timestamp':new Date()
                    })
                    .then(() => {
                        this.loading = false;
                    })
                    .catch((error) => {
                        this.loading = false;
                        console.log(error);
                    });

            },
            handOver(orderID){
                this.loading = true;
                CONFIG.DB.collection('orders')
                    .doc(orderID)
                    .update({
                        'status.value':2,
                        'status.timestamp':new Date()
                    })
                    .then(() => {
                        this.loading = false;
                    })
                    .catch((error) => {
                        this.loading = false;
                        console.log(error);
                    });

            },
            playSound(filename){
                var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
                var oggSource = '<source src="' + filename + '.ogg" type="audio/ogg">';
                var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3">';
                document.getElementById("sound").innerHTML='<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
            },
            status(status){
                let result='';
                switch (status) {
                    case 0:
                        result="Alınan";
                        break;
                    case 1:
                        result="Görüldü";
                        break;
                    case 2:
                        result="Teslim etti";
                        break;
                    default:
                        result="";
                        break;
                }
                return result;
            },
            colorOrder(status){
                let result='';
                switch (status) {
                    case 0:
                        result="danger";
                        break;
                    case 1:
                        result="success";
                        break;
                    case 2:
                        result="secondary";
                        break;
                    default:
                        result="";
                        break;
                }
                return result;
            }

        }
    };
</script>

<style scoped>
</style>
