/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
//git fetch --all
//git reset --hard origin/master

require("./bootstrap");
const firebase = require("firebase");
require("firebase/firestore");
firebase.initializeApp({
    apiKey: "AIzaSyC-dFnAYRRg8SyDGa-DzA66Hc3Z6Uc9Fko ",
    projectId: "emossmartmenu"
});
/* firebase.initializeApp({
    apiKey: 'AIzaSyCfHMiEGontiU0StbGpoNKZyBUxMunSkfM',
    projectId: 'emostestmode'
}); */
const db = firebase.firestore();
const firestore = firebase.firestore;
const dbAuth = firebase.auth();

window.Vue = require("vue");
Vue.use(require("vue-moment"));
var VueScrollTo = require("vue-scrollto");
Vue.use(VueScrollTo);

import translations from "../lang/vue-translations.json";
//php artisan lang:js resources/lang/vue-translations.json --json
//jchl403vz7hy@148.66.155.19
//₺
// ssh root@142.93.174.231
// cd /home/2urkeymenu.com/public_html
// scp narabana.com.zip root@142.93.174.231:/home/narabana.com/public_html
//Zoom+9314MU

Vue.component("pagination", require("laravel-vue-pagination"));
Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);
Vue.component(
    "user-component",
    require("./components/UserComponent.vue").default
);
Vue.component(
    "role-component",
    require("./components/RoleComponent.vue").default
);
Vue.component(
    "permission-component",
    require("./components/PermissionComponent.vue").default
);
Vue.component(
    "config-component",
    require("./components/ConfigComponent.vue").default
);
Vue.component(
    "settings-component",
    require("./components/SettingsComponent.vue").default
);
Vue.component("menu-feeds", require("./components/MenuComponent.vue").default);
Vue.component(
    "menu-categories",
    require("./components/CategoriesComponent.vue").default
);
Vue.component("new-order", require("./components/OrderComponent.vue").default);
Vue.component(
    "inner-orders",
    require("./components/OrdersComponent.vue").default
);
Vue.component(
    "remote-orders",
    require("./components/RemoteComponent.vue").default
);

Vue.component("my-table", require("./components/TableComponent.vue").default);
Vue.component(
    "category",
    require("./components/CategoryComponent.vue").default
);
Vue.component("item", require("./components/ItemComponent.vue").default);
Vue.component(
    "info-tables",
    require("./components/info/TableComponent.vue").default
);
Vue.component(
    "info-cats",
    require("./components/info/CatsComponent.vue").default
);
Vue.component(
    "info-items",
    require("./components/info/SubitemsComponent.vue").default
);
Vue.component(
    "orders-card",
    require("./components/info/OrdersCardComponent.vue").default
);
Vue.component(
    "relevance-sheet",
    require("./components/info/RelevanceComponent.vue").default
);
Vue.component(
    "tables-pie",
    require("./components/info/TablesPieComponent.vue").default
);
Vue.component(
    "orders-details",
    require("./components/info/OrdersDetailsComponent.vue").default
);
Vue.component(
    "members-sheet",
    require("./components/MembersSheetComponent.vue").default
);
Vue.component(
    "theme-default",
    require("./components/themes/DefaultThemeComponent.vue").default
);
Vue.component(
    "theme-pwa",
    require("./components/themes/PwaThemeComponent.vue").default
);
Vue.component(
    "remote-pwa",
    require("./components/themes/PwaRemoteComponent.vue").default
);
Vue.component(
    "theme-water",
    require("./components/themes/WaterThemeComponent.vue").default
);
Vue.component(
    "theme-remote",
    require("./components/themes/RemoteThemeComponent.vue").default
);
Vue.component(
    "water-remote",
    require("./components/themes/WaterRemoteComponent.vue").default
);
Vue.component("reset", require("./components/info/ResetComponent").default);
Vue.component(
    "statistic",
    require("./components/statistic/StatisticComponent").default
);
Vue.component("hooks", require("./components/HookComponent").default);
Vue.component("stack", require("./components/StackComponent").default);
Vue.component(
    "invoice-print",
    require("./components/InvoiceComponent").default
);

function coolNumber(num) {
    if (num < 1000) {
        return $num;
    }

    if (num < 1000000) {
        return num / 1000 + "K";
    }
    if ($num >= 1000000) {
        return num / 1000000 + "M";
    }
}

const CONFIG = {
    //API_URL: "https://" + window.location.hostname + "/public/api/",
    //FULL_PATH: "https://" + window.location.hostname + "/public",
    FULL_PATH: "http://" + window.location.hostname + "/emos/public",
    API_URL: "http://" + window.location.hostname + "/emos/public/api/",
    PATH: "/public",
    LANG: translations,
    DB: db,
    FIRESTORE: firestore,
    dbAuth: dbAuth,
    coolNumber: coolNumber
};

export default CONFIG;

const app = new Vue({
    el: "#app"
});
