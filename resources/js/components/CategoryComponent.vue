<template>
    <div>
        <div class="row">

            <div class="card card-primary card-outline col-12">
                <div class="card-header">

                    <button v-show="acl.edit_categories" type="button" class="btn btn-success" data-toggle="modal" data-target="#addFeed">
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
                            <th>{{ local[lang+".menu"]["name"] }}</th>
                            <th>{{ local[lang+".menu"]["favorite"] }}</th>
                            <th>
                                <span class="badge badge-info">{{categories.total}}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item,index) in categories.data" :key="item.id">
                            <td>
                                {{ item.name }}
                            </td>
                            <td>
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" v-model="item.fav" class="custom-control-input" disabled :id="'favSwitch-'+item.id">
                                    <label class="custom-control-label" :for="'favSwitch-'+item.id"></label>
                                </div>

                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-info text-white"
                                    @click="editCategory(item)"
                                    v-show="acl.edit_categories"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button v-show="acl.delete_categories" type="button" class="btn btn-sm btn-danger" @click="removeCategory(item)">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="p-2">
                        <pagination :data="Object.assign({},categories)"
                                    @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal -->
        <div
            class="modal fade"
            id="addFeed"
            tabindex="-1"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4
                            class="modal-title w-100 font-weight-bold"
                            v-show="category.id==null"
                        >{{ local[lang+".menu"]["create-category"] }}</h4>
                        <h4
                            class="modal-title w-100 font-weight-bold"
                            v-show="category.id!=null"
                        >{{ local[lang+".menu"]["edit-category"] }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addEditCategory">
                        <div class="modal-body mx-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
						<span class="input-group-text">
							<i class="fas fa-envelope"></i>
						</span>
                                </div>
                                <input
                                    type="text"
                                    v-model="category.name"
                                    class="form-control"
                                    :placeholder="local[lang+'.menu']['name']"
                                    required
                                />
                            </div>
                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>
                            <div class="modal-body mx-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" v-model="category.fav" class="custom-control-input"  id="favSwitch">
                                    <label class="custom-control-label" for="favSwitch">{{ local[lang+".menu"]["favorite"] }}</label>
                                </div>
                            </div>
                            <div v-if="errors && errors.fav" class="text-danger">{{ errors.fav[0] }}</div>

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
        name: "Category",
        props: ["auth", "lang", "acl"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                categories: [],
                local: CONFIG.LANG,
                category: {
                    id: null,
                    name:null,
                    fav:0,

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
                        "categories?page=" +
                        page +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.categories = res.data;
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
                        "search/categories?page=" +
                        page +
                        "&keywords=" +
                        this.keywords +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.categories = res.data;
                        this.loading = false;
                    });
            },
            addEditCategory(category = null) {
                this.loading = true;
                if (this.category.id) {
                    axios
                        .put(
                            CONFIG.API_URL +
                            "categories/" +
                            this.category.id +
                            "?api_token=" +
                            this.auth.api_token,
                            this.category
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
                            CONFIG.API_URL + "categories" + "?api_token=" + this.auth.api_token,
                            this.category
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
            editCategory(category) {
                this.category.id = category.id;
                this.category.name = category.name;
                this.category.fav = category.fav;

                $("#addFeed").modal("show");
            },
            removeCategory(category) {
                var conf = confirm(this.local[this.lang + ".alerts"]["confirm-delete"]);
                if (conf) {
                    this.loading = false;
                    axios
                        .delete(
                            CONFIG.API_URL +
                            "categories/" +
                            category.id +
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

            clearFields() {
                this.category.name =this.category.id= null;
                this.category.fav = 0;
            }
        }
    };
</script>

<style scoped>
</style>
