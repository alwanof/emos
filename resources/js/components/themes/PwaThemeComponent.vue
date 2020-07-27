<template>
  <div>
    <div id="preloader">
      <div class="spinner-border color-highlight" role="status"></div>
    </div>

    <div id="page">
      <!-- sidebar left -->
      <div id="menu-sidebar-left-1" class="bg-white menu menu-box-left" data-menu-width="320">
        <div class="d-flex">
          <a
            href="#"
            class="flex-fill icon icon-m text-center color-facebook border-bottom border-right"
          >
            <i class="fab font-12 fa-facebook-f"></i>
          </a>
          <a
            href="#"
            class="flex-fill icon icon-m text-center color-twitter border-bottom border-right"
          >
            <i class="fab font-12 fa-twitter"></i>
          </a>
          <a
            href="#"
            class="flex-fill icon icon-m text-center color-instagram border-bottom border-right"
          >
            <i class="fab font-12 fa-instagram"></i>
          </a>
          <a
            href="#"
            class="flex-fill icon icon-m text-center color-whatsapp border-bottom border-right"
          >
            <i class="fab font-12 fa-whatsapp"></i>
          </a>
          <a
            href="#"
            class="flex-fill icon icon-m text-center color-linkedin border-bottom border-right"
          >
            <i class="fab font-12 fa-linkedin-in"></i>
          </a>
          <a
            href="#"
            class="close-menu flex-fill icon icon-m text-center color-red2-dark border-bottom"
          >
            <i class="fa font-12 fa-times"></i>
          </a>
        </div>
        <div class="pl-3 pr-3 pt-3 mt-4 mb-2">
          <div class="d-flex">
            <div class="mr-3">
              <img :src="rest.avatar" width="43" />
            </div>
            <div class="flex-grow-1">
              <h1 class="font-22 font-700 mb-0">{{rest.name}}</h1>
              <p class="mt-n2 font-10 font-400">
                <a :href="'mailto:'+rest.email">{{rest.email}}</a>
              </p>
            </div>
          </div>
        </div>

        <div class="mr-3 ml-3">
          <span class="text-uppercase font-900 font-11 opacity-30">Kategoriler</span>
          <div class="list-group list-custom-small list-icon-0">
            <a href="#" @click.prevent="loadSection(0)">
              <i class="fa font-14 fa-list-alt color-blue2-dark"></i>
              <span>Hepsi</span>
              <span class="badge bg-red2-dark">All</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a
              href="#"
              @click.prevent="loadSection(cat.id)"
              v-for="(cat,index) in cats"
              :key="cat.id"
            >
              <i class="fa font-14 fa-list-alt color-blue2-dark"></i>
              <span>{{ cat.name }}</span>
              <span class="badge bg-red2-dark">{{ cat.itemsSize }}</span>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- / sidebae left-->

      <!-- header and footer bar go here-->
      <div class="header header-fixed header-logo-center">
        <a href="#" class="header-title">
          <img :src="rest.avatar" width="100px" class="mt-1" />
        </a>
        <a href="#" data-menu="menu-settings" class="back-button1 header-icon header-icon-1">
          <i class="fas fa-globe-americas" style="font-size:1.5em"></i>
        </a>
        <a href="#" class="back-button header-icon header-icon-2">
          <i class="fas fa-cog fa-spin color-highlight" v-show="loading"></i>
        </a>

        <a href="#" data-toggle-theme class="header-icon header-icon-4">
          <i class="fas fa-lightbulb" style="font-size:1.5em"></i>
        </a>
      </div>

      <div id="footer-bar" class="footer-bar-1">
        <a href="#" class="active-nav">
          <i class="fa fa-home"></i>
          <span>Ana Sayfa</span>
        </a>
        <a href="#" data-menu="menu-sidebar-left-1">
          <i class="fa fa-list-alt"></i>
          <span>Kategoriler</span>
        </a>
        <a href="#" data-menu="menu-basket">
          <i class="fas fa-shopping-cart"></i>
          <i class="badge badge-danger notranslate" v-show="pasket.length>0">{{pasket.length}}</i>

          <span>
            <i
              class="spinner-grow color-highlight notranslate"
              style="width:1rem;height:1rem"
              v-show="pasket.length>0"
            ></i>Sepetim
          </span>
        </a>
        <a href="#">
          <i class="fas fa-university"></i>
          <span>Hakkında</span>
        </a>
        <a href="#">
          <i class="far fa-envelope"></i>
          <span>İletişim</span>
        </a>
      </div>

      <!--start of page content, add your stuff here-->
      <div class="page-content header-clear-medium mt-5">
        <section id="home">
          <!-- Search form -->
          <div class="search-box search-header bg-theme card-style mr-3 ml-3">
            <i class="fa fa-search"></i>
            <input
              type="text"
              id="searchInput"
              class="border-0"
              placeholder="What are you looking for? "
            />
            <a href="#" class="disabled">
              <i class="fa fa-times-circle color-red2-dark"></i>
            </a>
          </div>
          <!-- search result -->
          <div id="searchCard" style="display:none">
            <div id="searchResult" class="m-2 pt-3 border border-warning">
              <div v-for="(feed,i) in feeds" :key="feed.id">
                <div class="card card-style mb-1">
                  <div class="card-header text-center">
                    <span class="h4 color-highlight">{{ feed.name }}</span>
                  </div>
                </div>
                <div
                  class="card card-style"
                  v-for="(item,k) in feed.items"
                  :key="item.id"
                  v-if="item.available"
                >
                  <div class="content mb-0">
                    <div>
                      <div class="d-flex mb-4">
                        <span>
                          <img :src="item.avatar" class="rounded-m shadow-xl" width="130" />
                        </span>
                        <div class="ml-3">
                          <h4 class="font-600">{{item.title}}</h4>
                          <p class="m-0">
                            <span class="exerpt efade" @click="showMore">
                              {{item.description.substring(0, 50)}}
                              <span>{{item.description.substring(50, 320)}}</span>
                            </span>
                          </p>
                          <h1 class="pt-3">
                            {{rest.currency}}{{item.price}}
                            <span class="h6 float-right">
                              <button
                                type="button"
                                class="btn btn-danger"
                                :disabled="basketAmount(item.id)==0"
                                @click="offFromPasket(i,k)"
                                style="padding: 2px 5px !important;"
                              >
                                <i class="fas fa-minus"></i>
                              </button>
                              <span class="lead font-weight-bold">{{basketAmount(item.id)}}</span>
                              <button
                                type="button"
                                class="btn btn-danger"
                                @click="addToPasket(i,k)"
                                style="padding: 2px 5px !important;"
                              >
                                <i class="fas fa-plus"></i>
                              </button>
                            </span>
                          </h1>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Fav section -->
          <div v-for="(feed,i) in feeds" :key="feed.id" v-if="feed.fav">
            <div class="card card-style mb-1">
              <div class="card-header text-center">
                <span class="h4 color-highlight">{{ feed.name }}</span>
              </div>
            </div>
            <div
              class="card card-style"
              v-for="(item,k) in feed.items"
              :key="item.id"
              v-show="item.available"
            >
              <div class="content mb-0">
                <div>
                  <div class="d-flex mb-4">
                    <div>
                      <img :src="item.avatar" class="rounded-m shadow-xl" width="130" />
                    </div>
                    <div class="ml-3">
                      <h4 class="font-600">{{item.title}}</h4>
                      <p class="m-0">
                        <span class="exerpt efade" @click="showMore">
                          {{item.description.substring(0, 50)}}
                          <span>{{item.description.substring(50, 320)}}</span>
                        </span>
                      </p>
                      <h1 class="pt-3">
                        {{rest.currency}}{{item.price}}
                        <span class="h6 float-right">
                          <button
                            type="button"
                            class="btn btn-danger"
                            :disabled="basketAmount(item.id)==0"
                            @click="offFromPasket(i,k)"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                          <span class="lead font-weight-bold">{{basketAmount(item.id)}}</span>
                          <button
                            type="button"
                            class="btn btn-danger"
                            @click="addToPasket(i,k)"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-plus"></i>
                          </button>
                        </span>
                      </h1>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- fav off -->
          <div v-for="(feed,i) in feeds" :key="feed.id" v-if="!feed.fav">
            <div class="card card-style mb-1">
              <div class="card-header text-center">
                <span class="h4 color-highlight">{{ feed.name }}</span>
              </div>
            </div>
            <div
              class="card card-style"
              v-for="(item,k) in feed.items"
              :key="item.id"
              v-show="item.available"
            >
              <div class="content mb-0">
                <div>
                  <div class="d-flex mb-4">
                    <div>
                      <img :src="item.avatar" class="rounded-m shadow-xl" width="130" />
                    </div>
                    <div class="ml-3">
                      <h4 class="font-600">{{item.title}}</h4>
                      <p class="m-0">
                        <span class="exerpt efade" @click="showMore">
                          {{item.description.substring(0, 50)}}
                          <span>{{item.description.substring(50, 320)}}</span>
                        </span>
                      </p>
                      <h1 class="pt-3">
                        {{rest.currency}}{{item.price}}
                        <span class="h6 float-right">
                          <button
                            type="button"
                            class="btn btn-danger"
                            :disabled="basketAmount(item.id)==0"
                            @click="offFromPasket(i,k)"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                          <span class="lead font-weight-bold">{{basketAmount(item.id)}}</span>
                          <button
                            type="button"
                            class="btn btn-danger"
                            @click="addToPasket(i,k)"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-plus"></i>
                          </button>
                        </span>
                      </h1>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- go2top icon -->
        <div class="content mt-5">
          <div class="row">
            <div class="col-4"></div>
            <div class="col-4">
              <a
                href="#"
                class="back-to-top-icon rounded-xs back-to-top-icon-circle bg-highlight shadow-m"
              >
                <i class="fa fa-angle-up"></i>
              </a>
            </div>
            <div class="col-4"></div>
          </div>
        </div>
      </div>

      <!-- ###################################################33 -->
      <!--end of page content, off canvas elements here-->

      <!-- All Menus, Action Sheets, Modals, Notifications, Toasts get Placed outside the <div class="page-content"> -->
      <!-- Setting -->
      <div
        id="menu-settings"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="300"
      >
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <div id="myLang" class="list-group list-custom-small list-icon-0">
            <a @click.prevent="doGTranslate(rest.language+'|tr')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-tr font-14 color-blue2-dark"></i>
              <span>Türkiye</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|en')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-us font-14 color-blue2-dark"></i>
              <span>English</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|ar')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-sa font-14 color-blue2-dark"></i>
              <span>عربي</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|fr')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-fr font-14 color-blue2-dark"></i>
              <span>FRANÇAIS</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|ru')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-ru font-14 color-blue2-dark"></i>
              <span>русский</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|sv')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-se font-14 color-blue2-dark"></i>
              <span>Svenska</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|am')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-et font-14 color-blue2-dark"></i>
              <span>አማርኛ</span>
            </a>
            <a @click.prevent="doGTranslate(rest.language+'|zh-CN')" href="#" class="notranslate">
              <i class="flag-icon flag-icon-cn font-14 color-blue2-dark"></i>
              <span>中文</span>
            </a>
          </div>
        </div>
      </div>

      <!-- basket -->
      <div
        id="menu-basket"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="300"
      >
        <div class="menu-title">
          <h1>
            <i class="fas fa-shopping-cart"></i>
            Sepetim
            <i
              class="badge badge-danger notranslate"
              v-show="pasket.length>0"
            >{{pasket.length}}</i>
          </h1>
          <p class="color-highlight">Preveiew & Confirm</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <div class="row">
            <div class="col-sm-12 col-">
              <h4>
                <span class="badge badge-pill badge-dark float-right">{{total()}} {{rest.currency}}</span>
              </h4>
            </div>
            <div class="col-sm-12">
              <div class="card border-dark mt-2">
                <div class="card-body p-1 m-0">
                  <table class="table table-striped my-2" v-show="pasket.length>0">
                    <tr v-for="(item,index) in pasket" :key="item.id">
                      <td width="70%">{{item.title}}</td>
                      <td>
                        <input
                          type="number"
                          @keypress="onlyNumberKey($event)"
                          min="1"
                          v-model="pasket[index].amount"
                          class="form-control"
                          value="1"
                        />
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div class="form-group">
                          <textarea
                            v-model="note"
                            class="form-control"
                            rows="3"
                            placeholder="Your Note .."
                          ></textarea>
                        </div>
                      </td>
                    </tr>
                  </table>

                  <hr />
                  <div class="alert alert-danger" role="alert" v-show="pasket.length==0">Sepet boş!</div>
                  <button
                    type="button"
                    class="btn btn-dark btn-lg btn-block"
                    @click="sendOrder"
                    v-show="pasket.length>0"
                  >
                    <i class="fas fa-paper-plane"></i> SEND!
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Be sure this is on your main visiting page, for example, the index.html page-->
      <!-- Install Prompt for Android -->
      <div
        id="menu-install-pwa-android"
        class="menu menu-box-bottom menu-box-detached rounded-l"
        data-menu-height="350"
        data-menu-effect="menu-parallax"
      >
        <div class="boxed-text-l mt-4">
          <img class="rounded-l mb-3" src="app/icons/icon-128x128.png" alt="img" width="90" />
          <h4 class="mt-3">Add Sticky on your Home Screen</h4>
          <p>Install Sticky on your home screen, and access it just like a regular app. It really is that simple!</p>
          <a
            href="#"
            class="pwa-install btn btn-s rounded-s shadow-l text-uppercase font-900 bg-highlight mb-2"
          >Add to Home Screen</a>
          <br />
          <a
            href="#"
            class="pwa-dismiss close-menu color-gray2-light text-uppercase font-900 opacity-60 font-10"
          >Maybe later</a>
          <div class="clear"></div>
        </div>
      </div>

      <!-- Install instructions for iOS -->
      <div
        id="menu-install-pwa-ios"
        class="menu menu-box-bottom menu-box-detached rounded-l"
        data-menu-height="320"
        data-menu-effect="menu-parallax"
      >
        <div class="boxed-text-xl mt-4">
          <img class="rounded-l mb-3" src="app/icons/icon-128x128.png" alt="img" width="90" />
          <h4 class="mt-3">Add Sticky on your Home Screen</h4>
          <p
            class="mb-0 pb-0"
          >Install Sticky on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".</p>
          <div class="clear"></div>
          <a
            href="#"
            class="pwa-dismiss close-menu color-highlight uppercase ultrabold opacity-80 top-25"
          >Maybe later</a>
          <i class="fa-ios-arrow fa fa-caret-down font-40"></i>
        </div>
      </div>

      <!--end of div id page-->
    </div>
  </div>
</template>
<script>
import CONFIG from "../../app";
export default {
  name: "PwaThemeComponent",
  props: ["rest", "tbl", "sess", "cats", "colors"],
  data() {
    return {
      path: CONFIG.PATH,
      fullPath: CONFIG.FULL_PATH,
      loading: false,
      page: 0,
      sec: 0,
      ds: [],
      feeds: [],
      orders: [],
      bell: false,
      selectedItem: null,
      pasket: [],
      note: null,
    };
    P;
  },
  created() {
    this.getResults();
  },

  methods: {
    getResults() {
      this.loading = true;
      axios.get(CONFIG.API_URL + "menu/show/" + this.rest.id).then((res) => {
        this.ds = res.data;
        this.feeds = res.data;
        this.loading = false;
      });
    },
    showMore(event) {
      event.target.classList.toggle("efade");
    },
    loadSection(p) {
      $("#menu-sidebar-left-1").hideMenu();
      this.feeds = [];
      if (p == 0) {
        this.feeds = this.ds;
      } else {
        this.ds.forEach((e) => {
          if (e.id == p) {
            this.feeds.push(e);
          }
        });
      }
    },
    addToPasket(cat, index) {
      console.log("cat:", cat);
      console.log("index:", index);
      const isExist = this.pasket.findIndex(
        (x) => x.id == this.feeds[cat].items[index].id
      );
      if (isExist == -1) {
        let item = {};
        item.id = this.feeds[cat].items[index].id;
        item.catID = this.feeds[cat].items[index].category_id;
        item.avatar = this.feeds[cat].items[index].avatar;
        item.slug = this.feeds[cat].items[index].slug;
        item.price = this.feeds[cat].items[index].price;
        item.title = this.feeds[cat].items[index].title;
        item.amount = 1;
        this.pasket.push(item);
      } else {
        this.pasket[isExist].amount++;
      }
    },
    offFromPasket(cat, index) {
      const isExist = this.pasket.findIndex(
        (x) => x.id == this.feeds[cat].items[index].id
      );
      if (isExist != -1) {
        if (this.pasket[isExist].amount > 1) {
          this.pasket[isExist].amount--;
        } else {
          this.pasket.splice(isExist, 1);
        }
      }
    },
    basketAmount(id) {
      const index = this.pasket.findIndex((x) => x.id == id);
      if (index == -1) {
        return 0;
      }

      return this.pasket[index].amount;
    },
    total() {
      let total = 0;
      this.pasket.forEach((item) => {
        total = total + item.price * item.amount;
      });
      return total.toFixed(2);
    },
    sendOrder() {},
    doGTranslate(param) {
      doGTranslate(param);
      $("#menu-settings").hideMenu();
    },
  },
};
</script>
