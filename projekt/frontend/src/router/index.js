import Vue from "vue";
import VueRouter from "vue-router";

import Login from "./views/Login";
import Register from "./views/Register";
import Home from "./views/Home";
import Rooms from "./views/Rooms";
import Room from "./views/Room";
import {tokenManager} from "../main";

import NotFound from "./views/NotFound";


Vue.use(VueRouter)

const routes = [
    {path: "/login", component:Login, name: "login"},
    {path: "/register", component:Register, name: "register"},
    {path: "/rooms", component:Rooms, name: "rooms", meta:{requireAuth: true}},
    {path: "/rooms/:id", component:Room, name: "room", meta:{requireAuth: true}},
    {path: "", component:Home, name: "home"},
    {path: "*", component:NotFound, name: "notFound"},

];


const router = new VueRouter({routes:routes, mode:"history"});

router.beforeEach((to,from, next)=>{
    if(to.meta != null && to.meta.requireAuth){
        //kontrola jestli mam token:
        if(tokenManager.isUserLogged()){
            next();
        }
        else{
            next({name:"login"});
        }
    }
    else{
        next();
    }

});


export default router;