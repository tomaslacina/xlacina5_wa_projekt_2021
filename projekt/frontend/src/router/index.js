import Vue from "vue";
import VueRouter from "vue-router";

import Login from "views/Login";
import Register from "views/Register";
import Home from "views/Home";

Vue.use(VueRouter)

const routes = [
    {path: "/login", component:Login, name: "login"},
    {path: "/register", component:Register, name: "register"},
    {path: "/home", component:Home, name: "home"},

]