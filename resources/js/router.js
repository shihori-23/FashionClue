import Vue from "vue";
import VueRouter from "vue-router";

import UserComponent from "./components/pages/UserComponent";
import UserHomeComponent from "./components/pages/UserHomeComponent";
import UserPostComponent from "./components/pages/UserPostComponent";
import UserPostDetailComponent from "./components/pages/UserPostDetailComponent";
import UserNoticeComponent from "./components/pages/UserNoticeComponent";
import UserSettingComponent from "./components/pages/UserSettingComponent";
import UserBookmarkComponent from "./components/pages/UserBookmarkComponent";
import UserProfileComponent from "./components/pages/UserProfileComponent";

Vue.use(VueRouter);

const routes = [
    {
        path: "/",
        redirect: "/user/home"
        // redirect: "/charisma/home"
    },
    {
        path: "/user",
        component: UserComponent,
        name: "User",
        children: [
            {
                path: "/user/home",
                component: UserHomeComponent,
                name: "UserHome"
            },
            {
                path: "/user/post",
                component: UserPostComponent,
                name: "UserPost"
            },
            {
                path: "/user/post/:postId",
                component: UserPostDetailComponent,
                name: "UserPostDetail"
            },
            {
                path: "/user/notice",
                component: UserNoticeComponent,
                name: "UserNotice"
            },
            {
                path: "/user/bookmark",
                component: UserBookmarkComponent,
                name: "UserBookmark"
            },
            {
                path: "/user/setting",
                component: UserSettingComponent,
                name: "UserSetting"
            },
            {
                path: "/user/profile",
                component: UserProfileComponent,
                name: "UserProfile"
            },
        ]
    },
];

// router.beforeEach((to, from, next) => {
// ログインか登録からじゃないと入れないような奴を書く感じになるかと。
//しばらく放置
//https://router.vuejs.org/guide/advanced/navigation-guards.html 参照
// });

export default new VueRouter({ routes });
