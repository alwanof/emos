<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ local[lang+".info"]["table_status"] }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="progress" style="height:60px">
                    <div class="progress-bar bg-warning" role="progressbar" :style="'width: '+percentage(0).per+'%'" >
                        {{ local[lang+".info"]["waiting"] }}({{percentage(0).value}})
                    </div>
                    <div class="progress-bar bg-danger" role="progressbar" :style="'width: '+percentage(1).per+'%'" >
                        {{ local[lang+".info"]["seen"] }}({{percentage(1).value}})
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "TablesPieComponent",
        props: ["auth", "lang",'tables'],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                tablesData:[],
                errors: []
            };
        },
        created() {
            this.initTables();
            this.loading = true;
            CONFIG.DB.collection('orders')
                .where('user.email','==',this.auth.email)
                .where('remote','==',false)
                .onSnapshot(snapshot => {
                this.initTables();

                snapshot.forEach(doc=>{

                    if(doc.data().status.value==0){
                        let index = this.tablesData.findIndex(o => o.slug === doc.data().table.slug);
                        if(index!=-1){
                            this.tablesData[index].value=0;

                        }
                    }
                    if(doc.data().status.value==1){
                        let index = this.tablesData.findIndex(o => o.slug === doc.data().table.slug);

                        if(index!=-1){
                            this.tablesData[index].value=1;

                        }
                    }
                    /*if(doc.data().status.value==2){
                        let index = this.tablesData.findIndex(o => o.slug === doc.data().table.slug);

                        if(index!=-1){
                            this.tablesData[index].value=-1;
                            //console.log('2')
                        }
                    }*/
                });


                this.loading = false;
            });
        },


        methods: {
            initTables(){
                this.tablesData=[];
                this.tables.data.forEach(item=>{
                    this.tablesData.push({
                        slug:item.slug,
                        value:-1
                    });
                });

            },
            percentage(value){
                let v=0;
                this.tablesData.forEach(item=>{
                    if (item.value==value){v++}
                });
                let result=100*(v/this.tablesData.length);
                return {
                    per:Math.round(result),
                    value:v
                }

            }

        }
    };
</script>

<style scoped>
</style>
