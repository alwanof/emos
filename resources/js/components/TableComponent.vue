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

            </div>
        </div>
        <div class="row">
            <div class="col-lg-2" v-for="(item,index) in boards.data" :key="item.id">
                <div class="card">
                    <div class="card-header card-danger h5">
                        <a :href="item.qrlink" target="_blank">
                            {{item.name}}
                        </a>
                    </div>
                    <a :href="path+'/admin/print/qrcode/'+item.id" target="_blank">
                        <img class="card-img-top" :src="'data:image/png;base64,'+item.qrcode">
                    </a>
                    <div class="card-footer">
                        <button
                            type="button"
                            class="btn btn-sm btn-info text-white"
                            @click="editTable(item)"
                        >
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger" @click="removeTable(item)">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <div class="p-2">
            <pagination :data="Object.assign({},boards)" @pagination-change-page="getResults"></pagination>
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
                            v-show="board.id==null"
                        >{{ local[lang+".menu"]["create-table"] }}</h4>
                        <h4
                            class="modal-title w-100 font-weight-bold"
                            v-show="board.id!=null"
                        >{{ local[lang+".menu"]["edit-table"] }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="addEditTable">
                        <div class="modal-body mx-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
						<span class="input-group-text">
							<i class="fas fa-tablets"></i>
						</span>
                                </div>
                                <input
                                    type="text"
                                    v-model="board.name"
                                    class="form-control"
                                    :placeholder="local[lang+'.menu']['name']"
                                    required
                                />
                            </div>
                            <div v-if="errors && errors.name" class="text-danger">{{ errors.name[0] }}</div>

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
        name: "TableComponent",
        props: ["auth", "lang", "acl"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                boards: [],
                local: CONFIG.LANG,
                board: {
                    id: null,
                    name: null,

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
                        "boards?page=" +
                        page +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.boards = res.data;
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
                        "search/boards?page=" +
                        page +
                        "&keywords=" +
                        this.keywords +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.boards = res.data;
                        this.loading = false;
                    });
            },
            addEditTable(board = null) {
                this.loading = true;
                if (this.board.id) {
                    axios
                        .put(
                            CONFIG.API_URL +
                            "boards/" +
                            this.board.id +
                            "?api_token=" +
                            this.auth.api_token,
                            this.board
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
                            CONFIG.API_URL + "boards" + "?api_token=" + this.auth.api_token,
                            this.board
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
            editTable(board) {
                this.board.id = board.id;
                this.board.name = board.name;
                $("#addFeed").modal("show");
            },
            removeTable(board) {
                var conf = confirm(this.local[this.lang + ".alerts"]["confirm-delete"]);
                if (conf) {
                    this.loading = false;
                    axios
                        .delete(
                            CONFIG.API_URL +
                            "boards/" +
                            board.id +
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
                this.board.name  =this.board.id= null;
            }
        }
    };
</script>

<style scoped>
</style>
