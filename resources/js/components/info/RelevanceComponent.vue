<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ local[lang+".info"]["relevence"] }}</h3>

                <div class="card-tools">
                    <button class="btn btn-tool" data-card-widget="collapse" type="button">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button class="btn btn-tool" data-card-widget="remove" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-2 pr-2">
                    <li class="item" v-for="(element,index) in items.data" :key="index">
                        <div class="product-img">
                            <img alt="Product Image" class="img-size-50" :src="element.avatar">
                        </div>
                        <div class="product-info">
                            <span class="product-title text-danger" >{{element.title}}
                                <i :class="getRlevance(element.view,items.max)+' fa-2x float-right'"></i>
                            </span>
                            <span class="product-description">
                                {{element.description.substr(0,25)}}..
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- /.card-body -->

        </div>
    </div>
</template>

<script>
    import CONFIG from "../../app";

    export default {
        name: "RelevanceComponent",
        props: ["auth", "lang", "items"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                ordersSize: 0,
                errors: []
            };
        },
        created() {


        },

        methods: {
            getRlevance(value,max){
                let result=value/max;
                if(result >0.7){
                    return 'fas fa-chart-line text-danger'
                }

                if(result >0.4){
                    return 'fas fa-heart text-danger'
                }
                return 'far fa-thumbs-up text-info'

            }
        }
    };
</script>

<style scoped>
</style>
