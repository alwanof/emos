<template>
    <div>
        <div class="row">
            <div class="col-lg-3" v-if="acl.access_agent_statistic">
                <div class="small-box bg-info">
                    <div class="inner">
                        Agent<h3><i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i>{{afeedsSize}}</h3>
                        <p >{{ local[lang+".info"]["orders"] }} | {{aordersSize}}</p>
                    </div>
                    <div class="icon">
                        <i class="fab fa-magento"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3" v-if="acl.access_grand_statistic">
                <div class="small-box bg-warning">
                    <div class="inner">
                        Grand<h3><i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i>{{gfeedsSize}}</h3>
                        <p >{{ local[lang+".info"]["orders"] }} | {{gordersSize}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-universal-access"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3" v-if="acl.access_rest_statistic">
                <div class="small-box bg-danger">
                    <div class="inner">
                        Restaurant<h3><i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i>{{rfeedsSize}}</h3>
                        <p >{{ local[lang+".info"]["orders"] }} | {{rordersSize}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-concierge-bell"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="small-box bg-success">
                    <div class="inner">
                        All<h3><i class="fas fa-cog fa-spin px-2 text-white" v-show="loading"></i>{{afeedsSize+gfeedsSize+rfeedsSize}}</h3>
                        <p >{{ local[lang+".info"]["orders"] }} | {{aordersSize+gordersSize+rordersSize}}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-check-double"></i>
                    </div>
                </div>
            </div>


        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "StatisticComponent",
        props: ["auth", "lang","acl"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                afeedsSize:0,
                gfeedsSize:0,
                rfeedsSize:0,
                aordersSize:0,
                gordersSize:0,
                rordersSize:0,
                errors: []
            };
        },
        created() {
            this.getfeedSize('a');
            this.getfeedSize('g');
            this.getfeedSize('r');
            this.getordersSize('a');
            this.getordersSize('g');
            this.getordersSize('r');


        },

        methods: {
            getfeedSize(type){
                this.loading = true;
                axios.get(
                    CONFIG.API_URL +
                    "statistic/"+type+"?api_token=" +
                    this.auth.api_token
                )
                    .then(res => {
                        const p=type+'feedsSize';
                        this[p] = res.data;
                        this.loading = false;
                    });
            },
            getordersSize(type){
                this.loading = true;
                switch (type) {
                    case 'a':
                        if(this.auth.level==0){
                            CONFIG.DB.collection('orders')
                                .where('sup','>',0)
                                .get().then(snapshot => {
                                    this.aordersSize=snapshot.size;
                                    this.loading = false;
                                });
                            return 0;
                        }
                        break;
                    case 'g':
                        if(this.auth.level==0){
                            CONFIG.DB.collection('orders')
                                .where('grand','>',0)
                                .where('sup','==',0)
                                .get().then(snapshot => {
                                this.gordersSize=snapshot.size;
                                this.loading = false;
                            });
                            return 0;
                        }
                        CONFIG.DB.collection('orders')
                            .where('grand','>',0)
                            .where('sup','==',this.auth.id)
                            .get().then(snapshot => {
                            this.gordersSize=snapshot.size;
                            this.loading = false;
                        });
                        break;
                    case 'r':
                        if(this.auth.level==0){
                            CONFIG.DB.collection('orders')
                                .where('grand','==',0)
                                .where('sup','==',0)
                                .get().then(snapshot => {
                                this.rordersSize=snapshot.size;
                                this.loading = false;
                            });
                            return 0;
                        }
                        if(this.auth.level==1){
                            CONFIG.DB.collection('orders')
                                .where('sup','==',this.auth.id)
                                .get().then(snapshot => {
                                this.rordersSize=snapshot.size;
                                this.loading = false;
                            });
                            return 0;
                        }
                        if(this.auth.level==2){
                            CONFIG.DB.collection('orders')
                                .where('grand','==',this.auth.id)
                                .get().then(snapshot => {
                                this.rordersSize=snapshot.size;
                                this.loading = false;
                            });
                            return 0;
                        }

                        break;

                }


            }
        }
    };
</script>

<style scoped>
</style>
