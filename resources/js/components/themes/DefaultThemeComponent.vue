<template>
    <div>
        <div id="mySidebar" class="sidebar">
            <a href="#" v-scroll-to="'#cat-'+cat.id" v-for="(cat,index) in cats" :key="cat.id" onclick="openNav();return false">
                {{cat.name}}
            </a>
        </div>
        <div id="myLang" class="sidebar">
            <a @click="doGTranslate(rest.language+'|tr')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-tr m-1"></i> Türkiye
            </a>
            <a @click="doGTranslate(rest.language+'|en')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-us m-1"></i> English
            </a>
            <a @click="doGTranslate(rest.language+'|ar')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-sa m-1"></i> عربي
            </a>
            <a @click="doGTranslate(rest.language+'|fr')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-fr m-1"></i> FRANÇAIS
            </a>
            <a @click="doGTranslate(rest.language+'|ru')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-ru m-1"></i> русский
            </a>
            <a @click="doGTranslate(rest.language+'|sv')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-se m-1"></i> svenska
            </a>
            <a @click="doGTranslate(rest.language+'|fa')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-ir m-1"></i> فارسی
            </a>
            <a @click="doGTranslate(rest.language+'|am')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-et m-1"></i> አማርኛ
            </a>
            <a @click="doGTranslate(rest.language+'|zh-CN')" href="#" onclick="return false;" class="notranslate">
                <i class="flag-icon flag-icon-cn m-1"></i> 中文
            </a>

        </div>
        <div id="main">
            <div id="sound"></div>

            <nav class="navbar navbar-inverse fixed-top navbar-embossed  rounded-0">
                <a class="navbar-brand" href="#">
                    <img :src="rest.avatar" class="img-thumbnail" style="max-width:150px;max-height:75px"  alt="">
                </a>
                <button onclick="openNav()" class="btn mr-auto" type="button" :disabled="page!=1">
                    <i class="fas fa-align-justify fa-2x text-light" ></i>
                </button>
                <i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i>
                <button :class="(pasket.length>0)?'btn btn-sm btn-danger':'btn btn-sm btn-secondary'" v-on:click.prevent="navigate(2)">
                    <span class="spinner-grow spinner-grow-sm" v-show="pasket.length>0"></span>
                    <i class="fas fa-shopping-cart" v-show="pasket.length==0"> </i>
                    <span class="badge badge-light notranslate">{{pasket.length}}</span>
                    Sepetim

                </button>
            </nav>
            <nav class="navbar navbar-inverse fixed-bottom navbar-embossed navbar-expand-sm p-0 rounded-0" style="margin-bottom: 0">
                <div class="container p-0">
                    <a class="nav-link" v-on:click.prevent="navigate(1)" :style="(page==1)?'background-color:#1abc9c':''" href="#"><i class="fas fa-home fa-2x text-light"></i></a>
                    <a class="nav-link"  onclick="openLang();return false;"  href="#"><i class="fas fa-globe fa-2x text-light"></i></a>
                    <a class="nav-link" v-on:click.prevent="navigate(4)" :style="(page==4)?'background-color:#1abc9c':''" href="#"><i class="far fa-envelope fa-2x text-light"></i></a>
                    <a class="nav-link" v-on:click.prevent="notify"  href="#">
                        <i :class="(bell)?'fas fa-2x fa-bell text-danger':'far fa-2x fa-bell text-white'"></i>
                    </a>
                </div>
            </nav>
            <transition name="bounce">
                <div v-show="page==1">
                    <div class="container-fluid" v-for="(feed,index1) in feeds" :key="feed.id" v-if="feed.fav==1">
                        <h5 class="my-4 text-center text-danger" :id="'cat-'+feed.id">{{feed.name}}</h5>
                        <div class="row" v-for="(item,index2) in feed.items" :key="item.id" v-show="item.available">
                            <div class="col-5 p-1">
                                <a href="#" @click.prevent="showMedia(item)">
                                    <div class="imgx">

                                        <i v-show="item.youtube" class="far fa-play-circle fa-3x text-white"></i>
                                        <img :src="item.avatar" >

                                    </div>
                                </a>

                            </div>
                            <div class="col-7 p-1">
                                <p class="lead font-weight-bold m-1" style="font-size: 20px;">
                                    {{item.title}}
                                    <br>
                                    <small class="text-muted" style="font-size: 70%;">
                                        {{item.description}}
                                    </small>
                                </p>
                                <div class="h6 notranslate">
                                    {{item.price}} {{rest.currency}}
                                    <span class="float-right">
                                        <button type="button" :disabled="basketAmount(item.id)==0" class="btn btn-sm btn-xs btn-danger" @click="offFromPasket(index1,index2)">

                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span>{{basketAmount(item.id)}}</span>
                                            <button type="button" :disabled="basketAmount(item.id)>25" class="btn btn-sm btn-xs btn-danger" @click="addToPasket(index1,index2)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                    </span>

                                </div>
                            </div>
                            <div class="col">
                                <hr>
                            </div>
                        </div>

                    </div>
                    <div class="container-fluid" v-for="(feed,index1) in feeds" :key="feed.id" v-if="feed.fav==0">
                        <h5 class="my-4 text-center" :id="'cat-'+feed.id">{{feed.name}} </h5>
                        <div class="row">
                            <div class="col-6" v-for="(item,index2) in feed.items" :key="item.id">
                                <div class="row">
                                    <div class="col-12 p-1">
                                        <a href="#" @click.prevent="showMedia(item)">
                                            <div class="imgx">

                                                <i v-show="item.youtube" class="far fa-play-circle fa-2x text-white"></i>
                                                <img :src="item.avatar" >

                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-12 p-1">
                                        <p class="lead font-weight-bold m-1" style="font-size: 20px;">
                                            {{item.title}}
                                        </p>
                                        <p class="text-muted" style="font-size: 60%;line-height: 1.5">
                                            {{item.description}}
                                        </p>
                                    </div>
                                    <div class="col-12 h6 text-center notranslate">
                                        <span style="font-size: 70%"> {{item.price}} {{rest.currency}}</span>
                                        <span class="float-right">
                                        <button type="button" :disabled="basketAmount(item.id)==0" class="btn btn-sm btn-xs btn-danger" @click="offFromPasket(index1,index2)">

                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <span>{{basketAmount(item.id)}}</span>
                                            <button type="button" :disabled="basketAmount(item.id)>25" class="btn btn-sm btn-xs btn-danger" @click="addToPasket(index1,index2)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </span>
                                        <hr>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
            <transition name="bounce">
                <div v-show="page==2">
                    <div v-show="page==2">
                        <div class="row"  >
                            <div class="col-sm-12">
                                <h4><span class="badge badge-pill badge-dark float-right">{{total()}} {{rest.currency}}</span></h4>
                            </div>
                            <div class="col-sm-12">
                                <div class="card border-dark mt-2">
                                    <div class="card-body p-1 m-0">

                                        <table class="table table-striped my-2" v-show="pasket.length>0">
                                            <tr v-for="(item,index) in pasket" :key="item.id">
                                                <td width="70%">{{item.title}}</td>
                                                <td><input type="number" @keypress="onlyNumberKey($event)" min="1" v-model="pasket[index].amount" class="form-control"  value="1"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="form-group">
                                                        <textarea v-model="note" class="form-control" rows="3" placeholder="Your Note .."></textarea>
                                                    </div>

                                                </td>
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
                                                <span class="badge badge-warning badge-pill">{{item.subTotal}} {{rest.currency}}</span>
                                            </li>

                                            <li class="list-group-item d-flex justify-content-between text-danger align-items-center list-group-item-secondary">
                                                Toplam vergi ve hizmeti içermez, bu yüzden yaklaşık
                                                <span class="badge badge-dark float-right">{{order.total}} {{rest.currency}}</span>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </transition>
        </div>
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
    import CONFIG from "../../app";

    export default {

        name: "DefaultThemeComponent",
        props: ["rest","tbl",'sess','cats'],
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
                note:null,


            };
        },

        created() {

            this.getResults();
            this.getOrders();
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

                const msg='👋'+this.tbl.name+'🔔';
                console.log(msg);
                axios.get('https://api.telegram.org/bot1035645137:AAHWzg_1YzGUYD_XMZrz28tsMyzZSqq0a9Y/sendMessage?chat_id=@'+this.rest.telegram+'&text='+msg);
                setTimeout(this.activate,60000);

            },
            activate() {
                this.bell=false;
            },
            navigate(page){
                this.page=page;

            },
            addToPasket(cat,index){

                const isExist=this.pasket.findIndex(x=>x.id==this.feeds[cat].items[index].id);
                if(isExist==-1){
                    let item={}
                    item.id=this.feeds[cat].items[index].id;
                    item.catID=cat;
                    item.avatar=this.feeds[cat].items[index].avatar;
                    item.slug=this.feeds[cat].items[index].slug;
                    item.price=this.feeds[cat].items[index].price;
                    item.title=this.feeds[cat].items[index].title;
                    item.amount=1;
                    this.pasket.push(item);
                }else{
                    this.pasket[isExist].amount++;
                }

            },
            offFromPasket(cat,index){
                const isExist=this.pasket.findIndex(x=>x.id==this.feeds[cat].items[index].id);
                if(isExist!=-1){
                    if(this.pasket[isExist].amount>1){
                        this.pasket[isExist].amount--;
                    }else{
                        this.pasket.splice(isExist,1);
                    }
                }

            },
            basketAmount(id){

                const index=this.pasket.findIndex(x=>x.id==id);
                if(index==-1){
                    return 0;
                }

                return this.pasket[index].amount;
            },
            getOrders(){
                this.loading = true;
                CONFIG.DB.collection('orders')
                    .where('user.email','==',this.rest.email)
                    .where('session','==',this.sess)
                    .limit(10)
                    .onSnapshot(snap=> {

                        if (snap.size == 0) {
                            this.loading = false;
                            return 0;
                        }
                        snap.forEach(doc=>{

                            let isExist = this.orders.find(o => o.orderID === doc.data().orderID);
                            if(!isExist){

                                this.orders.push(doc.data());
                            }else{

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
            total(){
                let total=0;
                this.pasket.forEach(item=>{
                    total=total+item.price*item.amount;
                });
                return total.toFixed(2);
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
                CONFIG.DB.collection('orders')
                    .where('status.value','==',0)
                    .where('table.id','==',this.tbl.id)
                    .get()
                    .then((snap)=>{
                        let data;

                        let exist=(snap.size>0)?true:false;
                        if(exist){
                            snap.forEach(doc=>{
                                data=doc.data();
                            });
                            console.log(data.orderID);
                            let note=data.note;
                            let allItems=data.items;
                            this.pasket.forEach(item=>{
                                allItems.push({
                                    amount:item.amount,
                                    catID:item.catID,
                                    slug:item.slug,
                                    id:item.id,
                                    price:item.price,
                                    subTotal:item.price*item.amount,
                                    title:item.title

                                });
                            });
                            CONFIG.DB.collection('orders').doc(data.orderID)
                                .update({
                                    items:allItems,
                                    note:note+'-'+((this.note)?this.note:''),
                                    hash:Math.random(),
                                    total:parseFloat(data.total)+parseFloat(this.total()),
                                    status:{
                                        timestamp:new Date(),
                                        value:0
                                    }
                                })
                                .then(()=>{
                                    this.loading = false;
                                    this.resetPasket();
                                });
                        }else{
                            order.items=items;
                            order.note=(this.note)?this.note:'';
                            order.remote=false;
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
                            order.hash=Math.random();
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
                        }

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

            /*playSound(filename){
                var mp3Source = '<source src="' + filename + '.mp3" type="audio/mpeg">';
                var oggSource = '<source src="' + filename + '.ogg" type="audio/ogg">';
                var embedSource = '<embed hidden="true" autostart="true" loop="false" src="' + filename +'.mp3">';
                document.getElementById("sound").innerHTML='<audio autoplay="autoplay">' + mp3Source + oggSource + embedSource + '</audio>';
            },*/
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
            },
            scrollMeTo(refName) {
                var element = this.$refs[refName];
                var top = element.offsetTop;

                window.scrollTo(20, top);
            },
            doGTranslate(param){
                doGTranslate(param);
                openLang();

            }

        }
    };
</script>

<style scoped>
</style>
