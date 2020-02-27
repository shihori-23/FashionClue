import Vue from "vue";
import VueRouter from "vue-router";

import UserComponent from "./components/pages/UserComponent";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        component: UserComponent,
        name: "user",
        // children: [
        //     {
            
        //     },
        // ]
    },
];

// router.beforeEach((to, from, next) => {
// ログインか登録からじゃないと入れないような奴を書く感じになるかと。
//しばらく放置
//https://router.vuejs.org/guide/advanced/navigation-guards.html 参照
// });

export default new VueRouter({ routes });
