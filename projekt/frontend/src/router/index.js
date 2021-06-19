import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./views/Login";
import Register from "./views/Register";
import Home from "./views/Home";
import Rooms from "./views/Rooms";
import NotFound from "./views/NotFound";


Vue.use(VueRouter)

const routes = [
    {path: "/login", component:Login, name: "login"},
    {path: "/register", component:Register, name: "register"},
    {path: "/rooms", component:Rooms, name: "rooms"},
    {path: "", component:Home, name: "home"},
    {path: "*", component:NotFound, name: "notFound"},

];


const router = new VueRouter({routes:routes, mode:"history"});


export default router;