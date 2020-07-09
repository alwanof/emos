<template>
    <div>
        <div class="row">
            <div class="card card-primary card-outline col-lg-12">
                <div class="card-header">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addFeed">
                        <i class="fas fa-plus"></i>
                    </button>
                    <i class="fas fa-cog fa-spin px-2 text-primary" v-show="loading"></i>

                </div>
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped table-hover table-head-fixed">
                        <thead>
                        <tr>
                            <th>{{ local[lang+".hooks"]["category"] }}</th>
                            <th>{{ local[lang+".hooks"]["operator"] }}</th>
                            <th>
                                <span class="badge badge-info">{{hooks.total}}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(hook,index) in hooks.data" :key="hook.id">
                            <td>
                                {{ hook.cat }}
                            </td>
                            <td>{{ hook.operator }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-danger" @click="removeHook(hook)">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="p-2">
                        <pagination :data="Object.assign({},hooks)" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>

            </div>

        </div>

        <!-- The Modal -->
        <div
            class="modal fade"
            id="addFeed"
            role="dialog"
            aria-labelledby="myModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">{{ local[lang+".hooks"]["create_hook"] }}</h4>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addHook">
                        <div class="modal-body mx-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                  </span>
                                </div>
                                <select class="form-control" v-model="hook.category_id" required>
                                    <option value="0" selected disabled>{{local[lang+".hooks"]["select_category"]}}</option>
                                    <option v-for="(element,index) in categories" :key="index" :value="element.id" >{{element.name}}</option>
                                </select>

                            </div>
                            <div v-if="errors && errors.category_id" class="text-danger">{{ errors.category_id[0] }}</div>

                            <div class="input-group mt-3">
                                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-user"></i>
                  </span>
                                </div>
                                <select class="form-control" v-model="hook.user_id" required>
                                    <option value="0" selected disabled>{{local[lang+".hooks"]["select_operator"]}}</option>
                                    <option v-for="(element,index) in operators" :key="index" :value="element.id" >{{element.name}}</option>
                                </select>

                            </div>
                            <div v-if="errors && errors.user_id" class="text-danger">{{ errors.user_id[0] }}</div>


                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-cog fa-spin" v-show="loading"></i>
                                <i class="fas fa-cog" v-show="!loading"></i>
                                <span class="px-1">{{ local[lang+".users"]["save"] }}</span>
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
        name: "HookComponent.vue",
        props: ["auth", "lang","operators","categories"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                local: CONFIG.LANG,
                hooks:[],
                hook: {
                    category_id: 0,
                    user_id: 0,
                },
                errors: []
            };
        },
        created() {
            this.getResults();
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
                        "hooks?page=" +
                        page +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.hooks = res.data;
                        this.loading = false;
                    });

            },
            addHook() {
                this.loading = true;
                    axios
                        .post(
                            CONFIG.API_URL + "hooks" + "?api_token=" + this.auth.api_token,
                            this.hook
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

            },
            removeHook(hook) {
                var conf = confirm(this.local[this.lang + ".alerts"]["confirm-delete"]);
                if (conf) {
                    this.loading = false;
                    axios
                        .delete(
                            CONFIG.API_URL +
                            "hooks/" +
                            hook.id +
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
                this.hook.category_id =this.hook.user_id= 0;
            }
        }
    }
</script>

<style scoped>
</style>
