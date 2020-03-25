import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';
import http from '../api';

Vue.use(Vuex);

const appsStore = new Vuex.Store({
    state: {
        listApp: {},
        appDetail: {},
        settingInfo: {}
    },
    getters: {
        listApp: state => state.listApp,
        appDetail: state => state.appDetail,
        settingInfo: state => state.settingInfo
    },
    mutations: {

        GET_LIST_APP (state, data) {
            state.listApp = data
        },
        GET_APP_DETAIL (state, data) {
            state.appDetail = data
        },
        GET_SETTING_INFO (state, data) {
            state.settingInfo = data
        }
    },
    actions: {
        getListApp ({commit}) {
            return new Promise(function (resolve, reject) {
                let urlData = '/list-app'
                http.axiosCus.get(urlData)
                    .then((response) => {
                        commit('GET_LIST_APP', response.data)
                        resolve(response)
                    })
                    .catch(err => {
                        reject(err)
                    })
            })
        },

        getAppDetail ({commit}, id) {
            return new Promise(function (resolve, reject) {
                let urlData = '/app-detail/' +id
                http.axiosCus.get(urlData)
                    .then((response) => {
                        commit('GET_APP_DETAIL', response.data)
                        resolve(response)
                    })
                    .catch(err => {
                        reject(err)
                    })
            })
        },
        getSettingInfo1 ({commit}) {
            return new Promise(function (resolve, reject) {
                let urlData = '/site-setting'
                http.axiosCus.get(urlData)
                    .then((response) => {
                        commit('GET_SETTING_INFO', response.data)
                        resolve(response)
                    })
                    .catch(err => {
                        reject(err)
                    })
            })
        }
    }
});

export default appsStore;

