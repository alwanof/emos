<template>
    <div>
        <div id="sound"></div>
        <nav class="icon-bar fixed-bottom bg-warning">
            <a href="#" v-on:click.prevent="navigate(1)" :class="(page==1)?'select':''"><i class="fa fa-home"></i></a>
            <a href="#" v-on:click.prevent="navigate(2)" :class="(page==2)?'select':''">
                <i class="fas fa-shopping-cart" v-show="pasket.length==0"></i>
                <div class="spinner-grow text-danger" role="status" v-show="pasket.length>0">
                    <span style="font-size: 70%" class="badge badge-danger text-light">{{pasket.length}}</span>
                </div>
            </a>
            <a href="#" v-on:click.prevent="navigate(3)" :class="(page==3)?'select':''"><i class="fas fa-history"></i></i></a>
            <a href="#" v-on:click.prevent="navigate(4)" :class="(page==4)?'select':''"><i class="far fa-envelope"></i></a>
            <a href="#" :class="(bell)?'isDisabled':''" v-on:click.prevent="notify"><i :class="(bell)?'fas fa-bell text-danger':'far fa-bell text-secondary'"></i></a>
        </nav>
        <div><i class="fas fa-cog fa-spin fa-2x px-2 text-primary" v-show="loading"></i></div>
        <transition name="bounce">
        <div v-show="page==1">
            <div v-for="(feed,index1) in feeds" :key="feed.id" v-if="feed.fav==1">
                <div class="border-bottom border-danger mt-5">
                    <h3 class="text-white m-0">
                        <span class="bg-danger p-1 rounded-top" :id="'cat-'+feed.id">{{feed.name}}</span>
                    </h3>
                </div>
                <div class="row" v-for="(item,index2) in feed.items" :key="item.id">
                    <div class="col-12">
                        <div class="card border-dark my-2">
                            <div class="card-body p-1 m-0">

                                <div>
                                    <a class="thumbnail" href="#" @click.prevent="showMedia(item)">
                                        <div class="imgx">

                                            <i v-show="item.youtube" class="far fa-play-circle fa-3x text-white"></i>
                                            <img :src="item.avatar" width="150px" class="img-thumbnail rounded-circle" alt="">

                                        </div>
                                    </a>


                                </div>
                                <div >
                                    <h5 class="card-title text-danger">{{item.title}} </h5>
                                    <p class="card-text">{{item.description}}</p>
                                    <button v-show="addToPasketActive(item.id)" @click="addToPasket(index1,index2)" class="btn btn-warning btn-lg btn-block" :disabled="(item.available==0)?true:false">
                                        <i class="fas fa-cart-plus"></i> | {{item.price}} <i class="fas fa-lira-sign"></i>
                                    </button>
                                    <button v-show="!addToPasketActive(item.id)" @click="removeFromPasket(item.id)" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-check"></i> | {{item.price}} <i class="fas fa-lira-sign"></i>
                                    </button>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div v-for="(feed,index1) in feeds" :key="feed.id" v-if="feed.fav==0">
                <div class="border-bottom border-danger mt-5">
                    <h3 class="text-white m-0">
                        <span class="bg-danger p-1 rounded-top" :id="'cat-'+feed.id">{{feed.name}}</span>
                    </h3>
                </div>
                <table class="table table-striped">
                    <tbody v-for="(item,index2) in feed.items" :key="item.id">
                    <tr>
                        <td width="25%">
                            <a class="thumbnail" href="#" @click.prevent="showMedia(item)">
                                <div class="imgx">

                                    <i v-show="item.youtube" class="far fa-play-circle fa-2x text-white"></i>
                                    <img :src="item.avatar" width="75px" class="img-thumbnail rounded-circle" alt="">

                                </div>
                            </a>

                        </td>
                        <td>
                            <div class="text-danger">{{item.title}}</div>
                            <div><span class="badge badge-danger">{{item.price}} <i class="fas fa-lira-sign"></i></span></div>
                        </td>
                        <td>
                            <button v-show="addToPasketActive(item.id)" @click="addToPasket(index1,index2)" class="btn btn-warning btn-sm" :disabled="(item.available==0)?true:false">
                            <i class="fas fa-cart-plus"></i>
                            </button>
                            <button v-show="!addToPasketActive(item.id)" @click="removeFromPasket(item.id)" class="btn btn-success btn-sm">
                            <i class="fas fa-check"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <small>{{item.description}}</small>
                            <hr>
                        </td>
                    </tr>
                    </tbody>

                </table>
            </div>
        </div>
        </transition>

        <transition name="bounce">
        <div v-show="page==2">
            <div class="row"  >
                <div class="col-sm-12">
                    <h4><span class="badge badge-pill badge-dark float-right">{{total()}} <i class="fas fa-lira-sign"></i></span></h4>
                </div>
                <div class="col-sm-12">
                    <div class="card border-dark mt-2">
                        <div class="card-body p-1 m-0">

                            <table class="table table-striped my-2" >
                                <tr v-for="(item,index) in pasket" :key="item.id">
                                    <td width="70%">{{item.title}}</td>
                                    <td><input type="number" @keypress="onlyNumberKey($event)" min="1" v-model="pasket[index].amount" class="form-control"  value="1"></td>
                                </tr>

                            </table>

                            <hr>
                            <div class="alert alert-danger" role="alert" v-show="pasket.length==0">
                                Sepet boş!
                            </div>
                            <button type="button" class="btn btn-dark btn-lg btn-block" @click="sendOrder" v-show="pasket.length>0">
                                <i class="fas fa-paper-plane"></i> SEND!
                            </button>


                        </div>
                    </div>
                </div>

            </div>
            <hr>
            <div class="row mb-2">
                <div class="col-sm-12" v-for="(order,index) in orders" :key="order.orderID">
                    <div :class="'card border-'+colorOrder(order.status.value)">
                        <div :class="'card-header text-white h3 bg-'+colorOrder(order.status.value)">
                            <span class="badge badge-dark float-left">#{{order.orderID.substring(0, 4)}}</span>
                            <span class="badge badge-light float-right">{{status(order.status.value)}}</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li v-for="(item,innerIndex) in order.items" :key="item.id" class="list-group-item d-flex justify-content-between align-items-center">
                                    {{item.title}}
                                    <span class="badge badge-warning badge-pill">{{item.subTotal}} <i class="fas fa-lira-sign"></i></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between text-danger align-items-center list-group-item-secondary">
                                    Toplam vergi ve hizmeti içermez, bu yüzden yaklaşık
                                    <span class="badge badge-dark float-right">{{order.total}} <i class="fas fa-lira-sign"></i></span>

                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>



        </div>
        </transition>

        <transition name="bounce">
        <div v-show="page==3">
            <h2>page3</h2>
        </div>
        </transition>

        <transition name="bounce">
        <div v-show="page==4">
            <h2>page4</h2>
        </div>
        </transition>

        <!-- Modal -->
        <div class="modal fade" id="mediaModal" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ön izleme</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div v-if="selectedItem">
                            <img v-show="!selectedItem.youtube" class="img-thumbnail" :src="selectedItem.avatar">
                            <iframe v-show="selectedItem.youtube" width="100%" height="315"
                                    :src="'https://www.youtube.com/embed/'+selectedItem.youtube"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>

                            </iframe>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import CONFIG from "../app";
    export default {
        name: "MenuComponent",
        props: ["rest","tbl",'sess','telegram'],
        data() {
            return {
                path: CONFIG.PATH,
                fullPath:CONFIG.FULL_PATH,
                loading: false,
                page:1,
                feeds: [],
                orders:[],
                bell:false,
                selectedItem: null,
                pasket:[],

            };
        },
        created() {
            this.getResults();
            this.getOrders();

            console.log('get it');

        },
        methods: {
            getResults() {
                this.loading = true;
                axios
                    .get(
                        CONFIG.API_URL +
                        "menu/show/"+this.rest.id
                    )
                    .then(res => {
                        this.feeds = res.data;
                        this.loading = false;
                    });
            },
            notify(){
                if(this.bell){
                    return false;
                }
                this.bell=true;

                const msg=':bell: '+this.tbl.name+' :wave:';
                console.log(msg);
                axios.get('https://api.telegram.org/bot1035645137:AAHWzg_1YzGUYD_XMZrz28tsMyzZSqq0a9Y/sendMessage?chat_id=@'+this.telegram+'&text='+msg);
                setTimeout(this.activate,60000);

            },

            activate() {
                this.bell=false;
            },
            navigate(page){
               this.page=page;

            },
            addToPasket(cat,index){
                let isExist=this.pasket.indexOf(this.feeds[cat].items[index]);
                if(isExist==-1){
                    let item={}
                    item.id=this.feeds[cat].items[index].id;
                    item.catID=cat,
                    item.avatar=this.feeds[cat].items[index].avatar;
                    item.slug=this.feeds[cat].items[index].slug;
                    item.price=this.feeds[cat].items[index].price;
                    item.title=this.feeds[cat].items[index].title;
                    item.amount=1;
                    this.pasket.push(item);
                    axios.get(CONFIG.API_URL + "menu/love/" + this.feeds[cat].items[index].id)
                        .then(res => {
                            this.loading = false;
                        })
                        .catch(error => {
                            console.log(error);
                            this.loading = false;
                        });
                }
            },
            getOrders(){
                this.loading = true;
                CONFIG.DB.collection('orders').where('session','==',this.sess).limit(10)
                    .onSnapshot(snap=> {

                        if (snap.size == 0) {
                            this.loading = false;
                            return 0;
                        }
                        snap.forEach(doc=>{

                            let isExist = this.orders.find(o => o.orderID === doc.data().orderID);
                            if(!isExist){
                                //this.playSound('http://2urkey.com/sounds/bing');
                                this.orders.push(doc.data());
                            }else{
                                this.playSound('https://2urkey.com/sounds/bing');
                                const index=this.orders.indexOf(isExist);
                                this.orders.splice(index, 1);
                                this.orders.push(doc.data());

                            }

                        });
                        this.loading = false;

                    });


            },
            removeFromPasket(id){
                let isExist=this.findWithAttr(this.pasket,'id',id);

                this.pasket.splice(isExist,1);
            },
            addToPasketActive(id){
                let isExist=this.findWithAttr(this.pasket,'id',id);
                if(isExist==-1){
                    return true
                }
                return false;
            },
            total(){
                let total=0;
                this.pasket.forEach(item=>{
                  total=total+item.price*item.amount;
                });
                return total;
            },
            sendOrder(){
                if(this.total()==0){
                    alert('Error!!');
                    return false;
                }
                this.loading=true;
                let order={}
                let items=[];
                this.pasket.forEach(item=>{
                    items.push({
                        amount:item.amount,
                        catID:item.catID,
                        slug:item.slug,
                        id:item.id,
                        price:item.price,
                        subTotal:item.price*item.amount,
                        title:item.title

                    });
                });
                order.items=items;
                order.session=this.sess;
                order.orderID=this.makeid(28);
                order.status={
                    timestamp:new Date(),
                    value:0
                };
                order.timestamp=new Date();
                order.total=this.total();
                order.table={
                    id:this.tbl.id,
                    name:this.tbl.name,
                    slug:this.tbl.slug
                }
                order.user={
                    id:this.rest.id,
                    name:this.rest.name,
                    email:this.rest.email
                }

                CONFIG.DB.collection('orders')
                    .doc(order.orderID)
                    .set(order)
                .then(()=>{
                    this.loading = false;
                    this.resetPasket();
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error);
                });


            },
            findWithAttr(array, attr, value) {
                for(var i = 0; i < array.length; i += 1) {
                    if(array[i][attr] === value) {
                        return i;
                    }
                }
                return -1;
            },
            resetPasket(){
                this.pasket=[];
            },
            showMedia(item){
                this.selectedItem=item;
                $("#mediaModal").modal("show");
            },
            playSound(filename){
                var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
                var oggSource = '<source src="' + filename + '.ogg" type="audio/ogg">';
                var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3">';
                document.getElementById("sound").innerHTML='<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
            },
            makeid(length) {
                var result= '';
                var characters='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < length; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
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
                        result="warning";
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
            },
            onlyNumberKey(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                    evt.preventDefault();;
                } else {
                    return true;
                }
            }

        }
    };
</script>

<style scoped>
</style>
