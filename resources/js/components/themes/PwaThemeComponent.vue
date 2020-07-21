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
        <a href="index.html" class="header-title">
          <img :src="rest.avatar" width="100px" class="mt-1" />
        </a>
        <a href="#" class="back-button header-icon header-icon-1">
          <i class="fas fa-globe-americas"></i>
        </a>
        <a href="#" class="back-button header-icon header-icon-2">
          <i class="fas fa-cog fa-spin color-highlight" v-show="loading"></i>
        </a>

        <a href="#" data-toggle-theme class="header-icon header-icon-4">
          <i class="fas fa-lightbulb"></i>
        </a>
      </div>

      <div id="footer-bar" class="footer-bar-1">
        <a href="index.html" class="active-nav">
          <i class="fa fa-home"></i>
          <span>Home</span>
        </a>
        <a href="#" data-menu="menu-sidebar-left-1">
          <i class="fa fa-list-alt"></i>
          <span>Kategoriler</span>
        </a>
        <a href="index-pages.html">
          <i class="fas fa-plus"></i>
          <span>Request</span>
        </a>
        <a href="index-search.html">
          <i class="fas fa-university"></i>
          <span>About</span>
        </a>
        <a href="#" data-menu="menu-settings">
          <i class="far fa-envelope"></i>
          <span>Contact</span>
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
            <div id="searchResult" class="m-2 border border-warning">
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
                  v-show="item.available"
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
                            <span class="exerpt efade">
                              {{item.description.substring(0, 50)}}
                              <span
                                style="display: none;"
                              >{{item.description.substring(50, 320)}}</span>
                            </span>
                          </p>
                          <h1 class="pt-3">
                            {{rest.currency}}{{item.price}}
                            <span class="h6 float-right">
                              <button
                                type="button"
                                class="btn btn-danger"
                                style="padding: 2px 5px !important;"
                              >
                                <i class="fas fa-minus"></i>
                              </button>
                              <span class="lead font-weight-bold">0</span>
                              <button
                                type="button"
                                class="btn btn-danger"
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

          <div v-for="(feed,i) in feeds" :key="feed.id" v-if="feed.fav==1">
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
                        <span class="exerpt efade">
                          {{item.description.substring(0, 50)}}
                          <span
                            style="display: none;"
                          >{{item.description.substring(50, 320)}}</span>
                        </span>
                      </p>
                      <h1 class="pt-3">
                        {{rest.currency}}{{item.price}}
                        <span class="h6 float-right">
                          <button
                            type="button"
                            class="btn btn-danger"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                          <span class="lead font-weight-bold">0</span>
                          <button
                            type="button"
                            class="btn btn-danger"
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
          <div v-for="(feed,i) in feeds" :key="feed.id" v-if="feed.fav==0">
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
                        <span class="exerpt efade">
                          {{item.description.substring(0, 50)}}
                          <span
                            style="display: none;"
                          >{{item.description.substring(50, 320)}}</span>
                        </span>
                      </p>
                      <h1 class="pt-3">
                        {{rest.currency}}{{item.price}}
                        <span class="h6 float-right">
                          <button
                            type="button"
                            class="btn btn-danger"
                            style="padding: 2px 5px !important;"
                          >
                            <i class="fas fa-minus"></i>
                          </button>
                          <span class="lead font-weight-bold">0</span>
                          <button
                            type="button"
                            class="btn btn-danger"
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

      <div
        id="menu-share"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="345"
        data-menu-effect="menu-over"
      >
        <div class="menu-title mt-n1">
          <h1>Share the Love</h1>
          <p class="color-highlight">Just Tap the Social Icon. We'll add the Link</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="content mb-0">
          <div class="divider mb-0"></div>
          <div class="list-group list-custom-small list-icon-0">
            <a href="#" class="shareToFacebook">
              <i class="font-18 fab fa-facebook color-facebook"></i>
              <span class="font-13">Facebook</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a href="#" class="shareToTwitter">
              <i class="font-18 fab fa-twitter-square color-twitter"></i>
              <span class="font-13">Twitter</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a href="#" class="shareToLinkedIn">
              <i class="font-18 fab fa-linkedin color-linkedin"></i>
              <span class="font-13">LinkedIn</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a href="#" class="shareToWhatsApp">
              <i class="font-18 fab fa-whatsapp-square color-whatsapp"></i>
              <span class="font-13">WhatsApp</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a href="#" class="shareToMail border-0">
              <i class="font-18 fa fa-envelope-square color-mail"></i>
              <span class="font-13">Email</span>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- All Menus, Action Sheets, Modals, Notifications, Toasts get Placed outside the <div class="page-content"> -->
      <div
        id="menu-settings"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="300"
      >
        <div class="menu-title">
          <h1>Settings</h1>
          <p class="color-highlight">Flexible and Easy to Use</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <div class="list-group list-custom-small">
            <a href="#" data-toggle-theme data-trigger-switch="switch-4" class="pb-2">
              <i class="fa font-12 fa-moon rounded-s bg-highlight color-white mr-3"></i>
              <span>Dark Mode</span>
              <div class="custom-control scale-switch ios-switch">
                <input data-toggle-theme-switch type="checkbox" class="ios-input" id="switch-4" />
                <label class="custom-control-label" for="switch-4"></label>
              </div>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          <div class="list-group list-custom-large">
            <a data-menu="menu-highlights" href="#">
              <i class="fa font-14 fa-tint bg-green1-dark rounded-s"></i>
              <span>Page Highlight</span>
              <strong>16 Colors Highlights Included</strong>
              <span class="badge bg-highlight color-white">HOT</span>
              <i class="fa fa-angle-right"></i>
            </a>
            <a data-menu="menu-backgrounds" href="#" class="border-0">
              <i class="fa font-14 fa-cog bg-blue2-dark rounded-s"></i>
              <span>Background Color</span>
              <strong>10 Page Gradients Included</strong>
              <span class="badge bg-highlight color-white">NEW</span>
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <div
        id="menu-highlights"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="380"
        data-menu-effect="menu-over"
      >
        <div class="menu-title">
          <h1>Highlights</h1>
          <p class="color-highlight">Any Element can have a Highlight Color</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <div class="highlight-changer">
            <a href="#" data-change-highlight="blue2">
              <i class="fa fa-circle color-blue2-dark"></i>
              <span class="color-blue2-light">Default</span>
            </a>
            <a href="#" data-change-highlight="red2">
              <i class="fa fa-circle color-red1-dark"></i>
              <span class="color-red2-light">Red</span>
            </a>
            <a href="#" data-change-highlight="orange">
              <i class="fa fa-circle color-orange-dark"></i>
              <span class="color-orange-light">Orange</span>
            </a>
            <a href="#" data-change-highlight="pink2">
              <i class="fa fa-circle color-pink2-dark"></i>
              <span class="color-pink2-light">Pink</span>
            </a>
            <a href="#" data-change-highlight="magenta2">
              <i class="fa fa-circle color-magenta2-dark"></i>
              <span class="color-magenta2-light">Purple</span>
            </a>
            <a href="#" data-change-highlight="aqua">
              <i class="fa fa-circle color-aqua-dark"></i>
              <span class="color-aqua-light">Aqua</span>
            </a>
            <a href="#" data-change-highlight="teal">
              <i class="fa fa-circle color-teal-dark"></i>
              <span class="color-teal-light">Teal</span>
            </a>
            <a href="#" data-change-highlight="mint">
              <i class="fa fa-circle color-mint-dark"></i>
              <span class="color-mint-light">Mint</span>
            </a>
            <a href="#" data-change-highlight="green2">
              <i class="fa fa-circle color-green2-dark"></i>
              <span class="color-green2-light">Green</span>
            </a>
            <a href="#" data-change-highlight="green1">
              <i class="fa fa-circle color-green1-dark"></i>
              <span class="color-green1-light">Grass</span>
            </a>
            <a href="#" data-change-highlight="yellow2">
              <i class="fa fa-circle color-yellow2-dark"></i>
              <span class="color-yellow2-light">Sunny</span>
            </a>
            <a href="#" data-change-highlight="yellow1">
              <i class="fa fa-circle color-yellow1-dark"></i>
              <span class="color-yellow1-light">Goldish</span>
            </a>
            <a href="#" data-change-highlight="brown1">
              <i class="fa fa-circle color-brown1-dark"></i>
              <span class="color-brown1-light">Wood</span>
            </a>
            <a href="#" data-change-highlight="dark1">
              <i class="fa fa-circle color-dark1-dark"></i>
              <span class="color-dark1-light">Night</span>
            </a>
            <a href="#" data-change-highlight="dark2">
              <i class="fa fa-circle color-dark2-dark"></i>
              <span class="color-dark2-light">Dark</span>
            </a>
            <div class="clearfix"></div>
          </div>
          <a
            href="#"
            data-menu="menu-settings"
            class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4"
          >Back to Settings</a>
        </div>
      </div>
      <!-- Menu Settings Backgrounds-->
      <div
        id="menu-backgrounds"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="310"
        data-menu-effect="menu-over"
      >
        <div class="menu-title">
          <h1>Backgrounds</h1>
          <p class="color-highlight">Change Page Color Behind Content Boxes</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <div class="background-changer">
            <a href="#" data-change-background="none">
              <i class="bg-theme"></i>
              <span>Default</span>
            </a>
            <a href="#" data-change-background="plum">
              <i class="body-plum"></i>
              <span class="color-plum-dark">Plum</span>
            </a>
            <a href="#" data-change-background="magenta3">
              <i class="body-magenta3"></i>
              <span class="color-magenta3-dark">Magenta</span>
            </a>
            <a href="#" data-change-background="dark3">
              <i class="body-dark3"></i>
              <span class="color-dark3-dark">Dark</span>
            </a>
            <a href="#" data-change-background="violet">
              <i class="body-violet"></i>
              <span class="color-violet-dark">Violet</span>
            </a>
            <a href="#" data-change-background="red3">
              <i class="body-red3"></i>
              <span class="color-red3-dark">Red</span>
            </a>
            <a href="#" data-change-background="green3">
              <i class="body-green3"></i>
              <span class="color-green3-dark">Green</span>
            </a>
            <a href="#" data-change-background="sky">
              <i class="body-sky"></i>
              <span class="color-sky-dark">Sky</span>
            </a>
            <a href="#" data-change-background="pumpkin">
              <i class="body-pumpkin"></i>
              <span class="color-pumpkin-dark">Orange</span>
            </a>
            <a href="#" data-change-background="yellow3">
              <i class="body-yellow3"></i>
              <span class="color-yellow3-dark">Yellow</span>
            </a>
            <div class="clearfix"></div>
          </div>
          <a
            href="#"
            data-menu="menu-settings"
            class="btn btn-full btn-m rounded-sm bg-highlight shadow-xl text-uppercase font-900 mt-4"
          >Back to Settings</a>
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
      note: null
    };
    P;
  },
  created() {
    this.getResults();
  },

  methods: {
    getResults() {
      this.loading = true;
      axios.get(CONFIG.API_URL + "menu/show/" + this.rest.id).then(res => {
        this.ds = res.data;
        this.feeds = res.data;
        this.loading = false;
      });
    },
    loadSection(p) {
      $("#menu-sidebar-left-1").hideMenu();
      this.feeds = [];
      if (p == 0) {
        this.feeds = this.ds;
      } else {
        this.ds.forEach(e => {
          if (e.id == p) {
            this.feeds.push(e);
          }
        });
      }
    }
  }
};
</script>
