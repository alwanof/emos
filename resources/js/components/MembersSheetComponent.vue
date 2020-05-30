<template>
    <div>
        <div class="row">
            <div class="card card-primary card-outline col-12">
                <div class="card-header">
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
                            <th>{{ local[lang+".members"]["name"] }}</th>
                            <th>{{ local[lang+".members"]["email"] }}</th>
                            <th>
                                <span class="badge badge-info">{{members.total}}</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(member,index) in members.data" :key="member.id">
                            <td>
                                <img :src="member.avatar+'?r='+Math.random()" class="rounded-circle mx-1" width="24px"/>
                                {{ member.name }}
                            </td>
                            <td>{{member.email}}</td>
                            <td>

                                <button type="button" class="btn btn-sm btn-danger" @click="removeMember(member)">
                                    <i class="fa fa-trash"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <hr/>
                    <div class="p-2">
                        <pagination :data="Object.assign({},members)" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import CONFIG from "../app";

    export default {
        name: "MemberSheetComponent",
        props: ["auth", "lang", "acl"],
        data() {
            return {
                path: CONFIG.PATH,
                loading: false,
                members: [],
                local: CONFIG.LANG,
                member: {
                    id: null,
                    name: null,
                    email: null,
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
                        "members?page=" +
                        page +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.members = res.data;
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
                        "search/members?page=" +
                        page +
                        "&keywords=" +
                        this.keywords +
                        "&api_token=" +
                        this.auth.api_token
                    )
                    .then(res => {
                        this.members = res.data;
                        this.loading = false;
                    });
            },
            removeMember(member) {
                var conf = confirm(this.local[this.lang + ".alerts"]["confirm-delete"]);
                if (conf) {
                    this.loading = false;
                    axios
                        .delete(
                            CONFIG.API_URL +
                            "members/" +
                            member.id +
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
                this.member.name = this.member.email = null;
            }
        }
    };
</script>

<style scoped>
</style>
