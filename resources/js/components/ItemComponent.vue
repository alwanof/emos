<template>
    <div>
        <div class="row">
            <div class="card card-primary card-outline col-12">
                <div class="card-header">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addFeed">
                        <i class="fas fa-plus"></i>
                    </button>
                    <i class="fas fa-cog fa-spin px-2 text-primary" v-show="loading"></i>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <input
                                type="text"
                                name="table_search"
                                v-model="keywords"
                                class="form-control float-right"
                                :placeholder=" local[lang+'.users']['search'] "
                            />

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover table-head-fixed">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{ local[lang+".menu"]["item_title"] }}</th>
                            <th>{{ local[lang+".menu"]["description"] }}</th>
                            <th>{{ local[lang+".menu"]["youtube"] }}</th>
                            <th>{{ local[lang+".menu"]["price"] }}</th>
                            <th>{{ local[lang+".menu"]["available"] }}</th>
                            <th>{{ local[lang+".menu"]["category"] }}</th>
                            <th>{{ local[lang+".menu"]["relevance"] }}</th>
                            <th>
                                <span class="badge badge-info">{{items.total}}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(sitem,index) in items.data" :key="index">
                            <td width="10%">
                                <a :href="path+'/admin/item/profile/'+sitem.id" >
                                    <img :src="sitem.avatar+'?r='+Math.random()" class="img-fluid rounded-circle mx-1" />
                                </a>
                            </td>
                            <td width="20%">
                                <a :href="path+'/admin/item/profile/'+sitem.id" >
                                    {{ sitem.title }}
                                </a>
                            </td >
                            <td width="30%">{{sitem.description}}</td>
                            <td>
                                <a v-show="sitem.youtube" :href="'https://www.youtube.com/watch?v='+sitem.youtube" target="_blank">
                                    <i  class="fab fa-youtube"></i>
                                </a>
                            </td>
                            <td>{{sitem.price}}₺</td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" v-model="sitem.available" class="custom-control-input" disabled :id="'favSwitch-'+sitem.id">
                                    <label class="custom-control-label" :for="'favSwitch-'+sitem.id"></label>
                                </div>
                            </td>
                            <td>{{sitem.category.name}}</td>
                            <td>{{sitem.view}}</td>
                            <td width="15%">
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info text-white"
                                    @click="editItem(sitem)"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" @click="removeItem(sitem)">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="p-2">
                        <pagination :data="Object.assign({},items)" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div class="modal fade" id="addFeed" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold" v-show="item.id==null">
                            {{ local[lang+".menu"]["create-item"] }}
                        </h4>
                        <h4 class="modal-title w-100 font-weight-bold" v-show="item.id!=null">
                            {{ local[lang+".menu"]["edit-item"] }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addEditItem">
                        <div class="modal-body mx-3">
                            <div class="input-group mb-2"">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-align-justify"></i>
                                    </span>
                                </div>
                                <input type="text" v-model="item.title" class="form-control"
                                       :placeholder="local[lang+'.menu']['item_title']"
                                       required/>
                            </div>
                            <div v-if="errors && errors.title" class="text-danger">{{ errors.title[0] }}</div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-align-justify"></i>
                                    </span>
                                </div>

                                <textarea v-model="item.description" class="form-control"
                                          :placeholder="local[lang+'.menu']['description']"
                                          required cols="30" rows="5">

                                </textarea>
                            </div>
                            <div v-if="errors && errors.description" class="text-danger">{{ errors.description[0] }}</div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fab fa-youtube"></i>
                                    </span>
                            </div>

                            <input type="text" v-model="item.youtube" class="form-control"
                                   :placeholder="local[lang+'.menu']['youtube']" />

                        </div>
                        <div v-if="errors && errors.youtube" class="text-danger">{{ errors.youtube[0] }}</div>

                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                            </div>

                            <input type="text" v-model="item.price" class="form-control"
                                   :placeholder="local[lang+'.menu']['price']" required/>

                        </div>
                        <div v-if="errors && errors.price" class="text-danger">{{ errors.price[0] }}</div>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="far fa-folder"></i>
                                    </span>
                            </div>
                            <select v-model="item.category_id" class="form-control">
                                <option value="0" selected disabled>{{local[lang+'.menu']['category']}}</option>
                                <option v-for="element in categories" :key="element.id" :value="element.id">{{element.name}}</option>
                            </select>

                        </div>
                        <div v-if="errors && errors.category_id" class="text-danger">{{ errors.category_id[0] }}</div>

                        <div class="input-group mb-2">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" v-model="item.available" class="custom-control-input"  id="availableSwitch">
                                <label class="custom-control-label" for="availableSwitch">{{ local[lang+".menu"]["available"] }}</label>
                            </div>

                        </div>
                        <div v-if="errors && errors.available" class="text-danger">{{ errors.available[0] }}</div>

                        </div>



                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-cog fa-spin" v-show="loading"></i>
                                <i class="fas fa-cog" v-show="!loading"></i>
                                <span class="px-1">{{ local[lang+".menu"]["save"] }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    import CONFIG from "../app";

    export default {
        name: "ItemComponent",
        props: ["auth", "lang", "acl","categories"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                items: [],
                local: CONFIG.LANG,
                item: {
                    id: null,
                    title: null,
                    description: null,
                    price: null,
                    available: 1,
                    category_id: 0,
                },
                keywords: null,
                errors: []
            };
        },
        created() {
            this.getResults();

        },
        watch: {
            keywords(after, before) {
                if (this.keywords.length > 2 || this.keywords.length === 0) {
                    this.search();
                }
            }
        },
        methods: {
            getResults(page = 1) {
                this.loading = true;
                if (typeof page === "undefined") {
                    page = 1;
                }
                axios
                    .get(
                        CONFIG.API_URL +
                        "items?page=" +
                        page +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.items = res.data;
                        this.loading = false;
                    });
            },
            search(page) {
                this.loading = true;
                if (typeof page === "undefined") {
                    page = 1;
                }
                axios
                    .get(
                        CONFIG.API_URL +
                        "search/items?page=" +
                        page +
                        "&keywords=" +
                        this.keywords +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.items = res.data;
                        this.loading = false;
                    });
            },
            changeItemAvatar(item){
                console.log(item);
            },
            addEditItem(item = null) {
                this.loading = true;
                this.item.youtube=(this.item.youtube)?this.youtube_parser(this.item.youtube):null;

                if (this.item.id) {
                    axios
                        .put(
                            CONFIG.API_URL +
                            "items/" +
                            this.item.id +
                            "?api_token=" +
                            this.auth.api_token,
                            this.item
                        )
                        .then(res => {
                            this.loading = false;
                            $("#addFeed").modal("hide");
                            toastr["success"](
                                this.local[this.lang + ".alerts"]["updated"],
                                this.local[this.lang + ".alerts"]["ok"]
                            );
                            this.clearFields();
                            this.getResults(1);

                        })
                        .catch(error => {
                            this.loading = false;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            } else {
                                $("#addFeed").modal("hide");
                                toastr["error"](
                                    this.local[this.lang + ".alerts"]["error"],
                                    this.local[this.lang + ".alerts"]["err"]
                                );
                                this.clearFields();
                            }
                        });
                } else {
                    axios
                        .post(
                            CONFIG.API_URL + "items" + "?api_token=" + this.auth.api_token,
                            this.item
                        )
                        .then(res => {
                            this.loading = false;

                            $("#addFeed").modal("hide");
                            toastr["success"](
                                this.local[this.lang + ".alerts"]["added"],
                                this.local[this.lang + ".alerts"]["ok"]
                            );
                            this.clearFields();
                            this.getResults(1);

                        })
                        .catch(error => {
                            console.log(error);
                            this.loading = false;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            } else {
                                $("#addFeed").modal("hide");
                                toastr["error"](
                                    this.local[this.lang + ".alerts"]["error"],
                                    this.local[this.lang + ".alerts"]["err"]
                                );
                                this.clearFields();
                            }
                        });
                }
            },
            editItem(item) {

                this.item.id = item.id;
                this.item.title = item.title;
                this.item.description = item.description;
                this.item.youtube =(item.youtube)? 'https://www.youtube.com/watch?v='+item.youtube:null;
                this.item.price = item.price;
                this.item.available = item.available;
                this.item.category_id = item.category_id;
                $("#addFeed").modal("show");
            },
            removeItem(item) {
                var conf = confirm(this.local[this.lang + ".alerts"]["confirm-delete"]);
                if (conf) {
                    this.loading = false;
                    axios
                        .delete(
                            CONFIG.API_URL +
                            "items/" +
                            item.id +
                            "?api_token=" +
                            this.auth.api_token
                        )
                        .then(res => {
                            this.loading = false;
                            toastr["success"](
                                this.local[this.lang + ".alerts"]["removed"],
                                this.local[this.lang + ".alerts"]["ok"]
                            );
                            this.getResults(1);
                        })
                        .catch(error => {
                            this.loading = false;
                            if (error.response.status === 422) {
                                this.errors = error.response.data.errors || {};
                            } else {
                                toastr["error"](
                                    this.local[this.lang + ".alerts"]["error"],
                                    this.local[this.lang + ".alerts"]["err"]
                                );
                            }
                        });
                }

            },
            youtube_parser(url){
                var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
                var match = url.match(regExp);
                return (match&&match[7].length==11)? match[7] : false;
            },

            clearFields() {
                this.item.title=this.item.id = this.item.description = this.item.youtube=this.item.price= null;
                this.item.category_id=0;
                this.item.available=1;

            }
        }
    };
</script>

<style scoped>
</style>
