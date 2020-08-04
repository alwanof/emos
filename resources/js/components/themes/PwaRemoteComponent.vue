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
            :href="getSetting('facebook')"
            class="flex-fill icon icon-m text-center color-facebook border-bottom border-right"
          >
            <i class="fab font-12 fa-facebook-f"></i>
          </a>
          <a
            :href="getSetting('twitter')"
            class="flex-fill icon icon-m text-center color-twitter border-bottom border-right"
          >
            <i class="fab font-12 fa-twitter"></i>
          </a>
          <a
            :href="getSetting('instagram')"
            class="flex-fill icon icon-m text-center color-instagram border-bottom border-right"
          >
            <i class="fab font-12 fa-instagram"></i>
          </a>
          <a
            :href="getSetting('youtube')"
            class="flex-fill icon icon-m text-center color-instagram border-bottom border-right"
          >
            <i class="fab font-12 fa-youtube"></i>
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
                <a :href="'mailto:'+getSetting('contact_email')">{{getSetting('contact_email')}}</a>
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
        <a href="#" :class="(page==0)?'active-nav':''" @click.prevent="page=0">
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
        <a href="#" :class="(page==1)?'active-nav':''" @click.prevent="page=1">
          <i class="fas fa-university"></i>
          <span>Hakkında</span>
        </a>
        <a href="#" data-menu="menu-contact">
          <i class="far fa-envelope"></i>
          <span>İletişim</span>
        </a>
      </div>

      <!--start of page content, add your stuff here-->
      <div class="page-content header-clear-medium mt-5">
        <section id="home" v-show="page==0">
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

        <section id="about" v-show="page==1">
          <div
            data-card-height="240"
            class="card card-style mb-4 preload-img"
            :data-src="fullPath+'/templates/pwa/img/promo.jpg'"
            :style="'height: 240px; background-image: url('+fullPath+'/templates/pwa/img/promo.jpg);'"
          >
            <div class="card-center text-center p-2">
              <img
                :src="rest.avatar"
                :alt="rest.name"
                :title="rest.name"
                class="img-thumbnail rounded-circle"
                width="150"
              />
              <h1 class="color-white font-28">{{ rest.name }}</h1>
            </div>
            <div class="card-overlay bg-black opacity-80"></div>
          </div>
          <div class="card card-overflow card-style">
            <div class="content">
              <div class="d-flex">
                <div class="flex-grow-1">
                  <h2 class="font-30">Hakkımızda</h2>
                </div>
              </div>
              <div class="divider"></div>
              <p v-html="getSetting('about')"></p>
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

      <!-- contact -->
      <div
        id="menu-contact"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="500"
      >
        <div class="menu-title">
          <h1>
            <i class="far fa-envelope"></i>
            Gözden Geçirmek
          </h1>
          <p class="color-highlight">Şikayet & not</p>
          <a href="#" class="close-menu">
            <i class="fa fa-times"></i>
          </a>
        </div>
        <div class="divider divider-margins mb-n2"></div>
        <div class="content">
          <form class="contactForm">
            <fieldset>
              <div class="form-field form-name">
                <label class="contactNameField color-theme" for="contactNameField">
                  Ad:
                  <span>(gereklidir)</span>
                </label>
                <input
                  type="text"
                  class="contactField round-small requiredField"
                  v-model="contact.name"
                />
              </div>
              <div class="form-field form-email">
                <label class="contactEmailField color-theme" for="contactEmailField">
                  E-posta:
                  <span>(gereklidir)</span>
                </label>
                <input type="text" name="contactEmailField" v-model="contact.email" />
              </div>
              <div class="form-field form-text">
                <label class="contactMessageTextarea color-theme" for="contactMessageTextarea">
                  İleti:
                  <span>(gereklidir)</span>
                </label>
                <textarea
                  name="contactMessageTextarea"
                  class="contactTextarea round-small requiredField"
                  v-model="contact.msg"
                ></textarea>
              </div>
              <div class="form-button">
                <input
                  type="button"
                  @click="notify"
                  class="btn bg-highlight text-uppercase font-900 btn-m btn-full rounded-sm shadow-xl contactSubmitButton"
                  value="Gönderme"
                />
              </div>
            </fieldset>
          </form>
        </div>
      </div>
      <!-- end /contact -->

      <!-- basket -->
      <div
        id="menu-basket"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="500"
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
          <div class="row mb-0">
            <div class="col-sm-12 col-">
              <h4>
                <span class="badge badge-pill badge-dark float-right">{{total()}} {{rest.currency}}</span>
              </h4>
            </div>
            <div class="col-sm-12">
              <div class="card border-dark mb-0 mt-2">
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
                    class="btn btn-dark btn-lg btn-block bg-highlight text-uppercase font-900 btn-full rounded-sm shadow-xl"
                    @click="sendOrder"
                    v-show="pasket.length>0"
                  >
                    <i class="fas fa-paper-plane"></i> SEND!
                  </button>
                </div>
              </div>
            </div>
          </div>
          <!-- Current Orders -->
          <div class="row mb-2">
            <div class="col-sm-12" v-for="(order,index) in orders" :key="order.orderID">
              <div :class="'card border-'+colorOrder(order.status.value)">
                <div :class="'card-header text-white h3 bg-'+colorOrder(order.status.value)">
                  <span class="badge badge-dark float-left">#{{order.orderID.substring(0, 4)}}</span>
                  <button
                    class="btn btn-danger mx-2 float-right"
                    v-show="order.status.value==0"
                    @click="cancel(order.orderID)"
                  >
                    <i class="far fa-window-close"></i>
                  </button>
                  <span class="badge badge-light float-right">{{status(order.status.value)}}</span>
                </div>
                <div class="card-body">
                  <ul class="list-group">
                    <li
                      v-for="(item,innerIndex) in order.items"
                      :key="item.id"
                      class="list-group-item d-flex justify-content-between align-items-center"
                    >
                      {{item.title}}
                      <span
                        class="badge badge-warning badge-pill"
                      >{{item.subTotal}} {{rest.currency}}</span>
                    </li>

                    <li
                      class="list-group-item d-flex justify-content-between text-danger align-items-center list-group-item-secondary"
                    >
                      Toplam vergi ve hizmeti içermez, bu yüzden yaklaşık
                      <span
                        class="badge badge-dark float-right"
                      >{{order.total}} {{rest.currency}}</span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- success box -->

      <div
        id="menu-success-1"
        class="menu menu-box-bottom menu-box-detached rounded-m"
        data-menu-height="305"
        data-menu-effect="menu-over"
      >
        <h1 class="text-center mt-4">
          <i class="fa fa-3x fa-check-circle color-green1-dark"></i>
        </h1>
        <h1 class="text-center mt-3 text-uppercase font-900">Her Şey İyi</h1>
        <p class="boxed-text-l">Önceki işlemlerinize devam edebilirsiniz.</p>
        <a
          href="#"
          class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-green1-light"
        >Harika</a>
      </div>
      <div
        id="menu-success-2"
        class="menu menu-box-bottom menu-box-detached bg-green1-dark rounded-m"
        data-menu-height="305"
        data-menu-effect="menu-over"
      >
        <h1 class="text-center mt-4">
          <i class="fa fa-3x fa-check-circle color-white shadow-xl rounded-circle"></i>
        </h1>
        <h1 class="text-center mt-3 text-uppercase font-900 color-white">All's Good</h1>
        <p class="boxed-text-l color-white opacity-70">
          You can continue with your previous actions.
          <br />Easy to attach these to success calls.
        </p>
        <a
          href="#"
          class="close-menu btn btn-m btn-center-m button-s shadow-l rounded-s text-uppercase font-900 bg-white"
        >Great</a>
      </div>
      <!-- /end success box -->
      <!-- Be sure this is on your main visiting page, for example, the index.html page-->
      <!-- Install Prompt for Android -->
      <div
        id="menu-install-pwa-android"
        class="menu menu-box-bottom menu-box-detached rounded-l"
        data-menu-height="350"
        data-menu-effect="menu-parallax"
      >
        <div class="boxed-text-l mt-4">
          <img class="rounded-l mb-3" :src="rest.avatar" alt="img" width="90" />
          <h4 class="mt-3">Add {{rest.name}} on your Home Screen</h4>
          <p>Install {{rest.name}} on your home screen, and access it just like a regular app. It really is that simple!</p>
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
          <img class="rounded-l mb-3" :src="rest.avatar" alt="img" width="90" />
          <h4 class="mt-3">Add {{rest.name}} on your Home Screen</h4>
          <p
            class="mb-0 pb-0"
          >Install {{rest.name}} on your home screen, and access it just like a regular app. Open your Safari menu and tap "Add to Home Screen".</p>
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
    <!-- The Modal -->
    <div class="modal fade" id="customerInfo">
      <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Sipariş onayı</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="far fa-user"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="customer.name"
                  class="form-control"
                  placeholder="Adınız"
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
                <input
                  type="email"
                  v-model="customer.email"
                  class="form-control"
                  placeholder="E-posta"
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-phone-alt"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="customer.phone"
                  class="form-control"
                  placeholder="Telefon"
                  required
                />
              </div>
            </div>
            <hr />
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marked"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="customer.country"
                  class="form-control"
                  placeholder="ülke"
                  disabled
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marker"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="customer.city"
                  class="form-control"
                  placeholder="Kent"
                  required
                />
              </div>
            </div>
            <div class="form-group">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="fas fa-map-marker-alt"></i>
                  </span>
                </div>
                <input
                  type="text"
                  v-model="customer.address"
                  class="form-control"
                  placeholder="Adres"
                  required
                />
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer text-center">
            <button type="button" class="btn btn-success" @click="sendOrder">ONAYLAMAK!</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import CONFIG from "../../app";
export default {
  name: "PwaRemoteComponent",
  props: ["rest", "sess", "cats", "geo", "colors", "param"],
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
      query: {
        body: null,
        orderID: null,
        customer: null,
        total: 0,
      },
      customer: {
        country: this.geo.country,
        city: this.geo.city,
        clientID: null,
        name: null,
        email: null,
        phone: null,
        address: null,
      },
      contact: {
        name: null,
        email: null,
        msg: null,
      },
      selectedItem: null,
      pasket: [],
      note: null,
    };
  },
  created() {
    this.getResults();
    this.getOrders();
    this.checkClientID();
  },

  methods: {
    checkClientID() {
      if (
        this.param.clientID &&
        this.param.name &&
        this.param.email &&
        this.param.phone &&
        this.param
      ) {
        if (
          this.param.clientID > 1 &&
          this.param.name.length > 1 &&
          this.param.email.length > 4 &&
          this.param.phone.length > 5 &&
          this.param.address.length > 5
        ) {
          this.customer.name = this.param.name;
          this.customer.email = this.param.email;
          this.customer.phone = this.param.phone;
          this.customer.address = this.param.address;
          this.customer.clientID = this.param.clientID;
        }
      }
    },
    getResults() {
      this.loading = true;
      axios.get(CONFIG.API_URL + "menu/show/" + this.rest.id).then((res) => {
        this.ds = res.data;
        this.feeds = res.data;
        this.loading = false;
      });
    },
    notify() {
      const msg =
        "👋" +
        this.tbl.name +
        "🔔" +
        this.contact.name +
        "<" +
        this.contact.email +
        ">:" +
        this.contact.msg;
      axios.get(
        "https://api.telegram.org/bot1035645137:AAHWzg_1YzGUYD_XMZrz28tsMyzZSqq0a9Y/sendMessage?chat_id=@" +
          this.rest.telegram +
          "&text=" +
          msg
      );
      $("#menu-contact").hideMenu();
      $("#menu-success-1").showMenu();
    },
    getOrders() {
      this.loading = true;
      CONFIG.DB.collection("orders")
        .where("user.email", "==", this.rest.email)
        .where("session", "==", this.sess)
        .limit(10)
        .onSnapshot((snap) => {
          if (snap.size == 0) {
            this.loading = false;
            return 0;
          }
          snap.forEach((doc) => {
            let isExist = this.orders.find(
              (o) => o.orderID === doc.data().orderID
            );
            if (!isExist) {
              this.orders.push(doc.data());
            } else {
              const index = this.orders.indexOf(isExist);
              this.orders.splice(index, 1);
              this.orders.push(doc.data());
            }
          });
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
    sendOrder() {
      if (this.total() == 0) {
        alert("Error!!");
        return false;
      }
      if (!this.customer.name) {
        $("#customerInfo").modal("show");
        return false;
      }
      this.loading = true;

      let order = {};
      let items = [];
      this.pasket.forEach((item) => {
        items.push({
          amount: item.amount,
          catID: item.catID,
          slug: item.slug,
          out: 0,
          id: item.id,
          price: item.price,
          subTotal: item.price * item.amount,
          title: item.title,
        });
      });
      order.items = items;
      order.note = this.note ? this.note : "";
      order.session = this.sess;
      order.remote = true;
      order.orderID = this.makeid(28);
      order.status = {
        timestamp: new Date(),
        value: 0,
      };
      order.timestamp = new Date();
      order.total = this.total();
      order.customer = {
        clientID: this.customer.clientID ? this.customer.clientID : 0,
        name: this.customer.name,
        email: this.customer.email,
        phone: this.customer.phone,
        country: this.customer.country,
        city: this.customer.city,
        address: this.customer.address,
      };
      order.user = {
        id: this.rest.id,
        name: this.rest.name,
        email: this.rest.email,
      };
      order.grand = this.rest.parent.grand;
      order.sup = this.rest.parent.sup;
      order.hash = Math.random();
      CONFIG.DB.collection("orders")
        .doc(order.orderID)
        .set(order)
        .then(() => {
          this.loading = false;
          $("#customerInfo").modal("hide");
          this.query.orderID = order.orderID.substring(0, 4);
          this.query.total = order.total;
          this.bell = true;
          this.resetPasket();
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    cancel(orderID) {
      CONFIG.DB.collection("orders")
        .doc(orderID)
        .delete()
        .then(() => {
          this.loading = false;
          let isExist = this.orders.find((o) => o.orderID === orderID);
          this.orders.splice(isExist, 1);
        })
        .catch((error) => {
          this.loading = false;
          console.log(error);
        });
    },
    makeid(length) {
      var result = "";
      var characters =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      var charactersLength = characters.length;
      for (var i = 0; i < length; i++) {
        result += characters.charAt(
          Math.floor(Math.random() * charactersLength)
        );
      }
      return result;
    },
    resetPasket() {
      this.pasket = [];
    },
    getSetting(setting) {
      let obj = this.rest.settings.find((o) => o.name === setting);
      let res = obj ? obj.value : "#";
      return res;
    },
    doGTranslate(param) {
      doGTranslate(param);
      $("#menu-settings").hideMenu();
    },
    status(status) {
      let result = "";
      switch (status) {
        case 0:
          result = "Alınan";
          break;
        case 1:
          result = "Görüldü";
          break;
        case 2:
          result = "Teslim etti";
          break;
        default:
          result = "";
          break;
      }
      return result;
    },
    colorOrder(status) {
      let result = "";
      switch (status) {
        case 0:
          result = "warning";
          break;
        case 1:
          result = "success";
          break;
        case 2:
          result = "secondary";
          break;
        default:
          result = "";
          break;
      }
      return result;
    },
  },
};
</script>
