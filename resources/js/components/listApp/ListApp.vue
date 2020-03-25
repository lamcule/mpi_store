<template>
    <div class="container listApp">
        <div v-for="(item, index) in listApp" :key="item.id">
            <div  class="row my-3">
                <div class="col-2 col-lg-1 d-flex">
                    <div class="list_icon-img">
                        <router-link :to="{name:'Detail', params:{id:item.id}}">
                            <img v-if="item.avatar !== null" :src="item.avatar" alt="">
                            <img v-else src="./../../../../public/images/app_icon.png" alt="">
                        </router-link>
                    </div>
                </div>
                <div class="col-7 col-lg-9">
                    <router-link :to="{name:'Detail', params:{id:item.id}}" class="listApp--link-detail">
                    <div class="list-text">
                        <h2 style="font-size: 20px">{{item.title}}</h2>
                        <p class="appInfo--version">Ứng dụng quản lý văn bản nội bộ</p>
                        <div v-if="isAndroid === false && isIOS === false">
                            <p class="appInfo--version">Phiên bản iOS: </p>
                            <p class="appInfo--version">Phiên bản android: 1.0</p>
                        </div>

                    </div>
                    </router-link>
                </div>
                <div class="col-3 col-lg-2 listApp-col3 d-flex justify-content-center align-items-center">
                    <div v-if="isIOS">
                        <button @click="downloadIOS(index)" class="btn btn-primary btn-download">Tải</button>
                    </div>
                    <div v-else-if="isAndroid">
                        <button @click="downloadAndroid(index)" class="btn btn-primary btn-download">Tải</button>
                    </div>
                    <div v-else>
                        <router-link :to="{name:'Detail', params: {id:item.id}}" class="listApp--detailbtn">Chi tiết</router-link>
                    </div>
                </div>
            </div>
            <div v-if="index !== listApp.length -1" class="row">
                <div class="col-2 col-lg-1"></div>
                <div class="col-10 col-lg-11">
                    <div class="line list-line"></div>
                </div>
            </div>
            <!--<div v-if="index !== listApp.length -1" class="line"></div>-->
        </div>

    </div>
</template>

<script>
    import  deviceDetect  from 'mobile-device-detect';

    export default {
        name: "ListApp",
        data () {
            return {
                isAndroid: deviceDetect.isAndroid,
                isIOS: deviceDetect.isIOS,
                url:'',
                listApp: {}
            }
        },
        mounted () {
            this.url = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
            this.$store.dispatch('getListApp')
                .then(() => {
                    this.listApp = this.$store.getters.listApp.data
                })
                .catch(err => console.log(err))
        },
        methods: {
            downloadIOS: function (id) {
                console.log(this.listApp[id].iOS.path);
                if(this.listApp[id].iOS.path !== null) {
                    location.href = this.listApp[id].iOS.path
                } else {
                    alert('Không tìm thấy phần mềm')
                }
            },
            downloadAndroid: function (id) {
                if(this.listApp[id].android.path !== null) {
                    location.href = this.listApp[id].android.path
                } else {
                    alert('Không tìm thấy phần mềm')
                }
            }
        }
    }
</script>

<style scoped>

</style>
