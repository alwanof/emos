<template>
    <div class="container">

        <div class="text-center h4">
            <i class="fas fa-cog fa-spin px-2 text-primary" v-show="loading"></i>
        </div>
        <div class="row">
           <div class="col-lg-6">
               <div class="card direct-chat direct-chat-primary">
                   <div class="card-header ui-sortable-handle bg-danger" style="cursor: move;">
                       <h3 class="card-title">Feeds</h3>
                       <div class="card-tools">
                           <span data-toggle="tooltip" title="3 New Messages" class="badge badge-primary"></span>
                           <button type="button" class="btn btn-tool" data-card-widget="collapse">
                               <i class="fas fa-minus"></i>
                           </button>

                           <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                           </button>
                       </div>
                   </div>
                   <div class="card-body p-0" >
                       <ul class="products-list product-list-in-card pl-2 pr-2">
                           <li class="item" v-for="(feed,index) in feeds" :key="index">
                               <div class="product-img">
                                   <img alt="Product Image" class="img-size-50" :src="fullPath+'/storage/items/'+feed.id+'.jpg'">
                               </div>
                               <div class="product-info">
                            <span class="product-title text-danger" >
                                <h4>#{{feed.order.substring(0, 4)}}@{{feed.title}} <span class="badge badge-danger">{{feed.amount}}</span>
                                <button type="button" class="btn btm-lg float-right btn-success"  @click="checkout(feed.order,feed.index)">
                                    <i class="far fa-check-circle"></i>
                                </button>
                                    </h4>
                            </span>

                               </div>
                           </li>
                       </ul>
                   </div>
               </div>
           </div>
        </div>


    </div>
</template>
<script>
    import CONFIG from "../app";
    import Timer from "../../../public/assets/dist/js/lib/timer/easytimer.min";

    export default {
        name: "StackComponent",
        props: ["acl","lang","auth","hook","rest"],
        data() {
            return {
                path: CONFIG.PATH,
                fullPath:CONFIG.FULL_PATH,
                local: CONFIG.LANG,
                loading: false,
                feeds:[],
                orders:[]

            };
        },
        created() {
            this.getData();
        },
        methods: {
            getData(){
                this.loading = true;
                let docs=[];
                CONFIG.DB.collection('orders')
                    .where('user.email','==',this.rest.email)
                    .where('status.value','==',1)
                    .orderBy('timestamp',"asc")
                    .onSnapshot(snap=> {
                        if (snap.size == 0) {
                            this.loading = false;
                            return 0;
                        }
                        docs=[];
                        this.orders=[];

                        snap.forEach(doc=>{
                            let i={};
                            doc.data().items.forEach((e,index)=>{
                                i.title=e.title;
                                i.amount=e.amount;
                                i.order=doc.data().orderID;
                                i.index=index;
                                i.out=e.out;
                                i.id=e.id;

                                if(this.hook.includes(e.catID) && e.out==0){
                                    docs.push(i);
                                    this.orders.push(doc.data());
                                }

                            });
                        });
                        this.feeds=docs;

                        this.loading = false;

                    });
            },
            checkout(orderID,index){
                this.loading = true;
                const i=this.orders.findIndex(x => x.orderID == orderID);
                this.orders[i].items[index].out=1;
                CONFIG.DB.collection('orders')
                    .doc(orderID)
                    .update({
                        'items': this.orders[i].items

                    })
                    .then(() => {
                        this.loading = false;


                    })
                    .catch((error) => {
                        this.loading = false;
                        console.log(error);
                    });
            }
        }
    };
</script>

<style scoped>
</style>
