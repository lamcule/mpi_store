<template>
        <div class="container appDetail">
            <div v-if="isAndroid === false && isIOS === false" class="row">
                <div class="col-12">
                    <div class="text-center device__not-supported py-2">
                        <p>Thiết bị không hỗ trợ cài đặt</p>
                        <p class="appInfo--red">*Sử dụng điện thoại để cài đặt phần mềm</p>
                    </div>
                </div>
            </div>
            <div class="row appInfo mt-3">
                <div class="col-4 col-lg-3 pr-1">
                    <img class="mb-2 appDetail__avatar" v-if="dataDetail.avatar !== null" :src="dataDetail.avatar" alt="">
                    <img class="mb-2 appDetail__avatar" v-else src="./../../../../public/images/app_icon.png" alt="">
                </div>
                <div class="col-8 col-lg-9">
                    <h2 class="appDetail__app-name">{{dataDetail.title}}</h2>
                    <p class="appInfo--blue mb-1 appInfo--hiden-mobile">Phòng CNTT - Bộ Kế hoạch và Đầu tư</p>
                    <div v-if="isAndroid || isIOS" class="appDetail__btn-download">
                        <button v-if="isIOS" class="btn btn-primary btn-download" @click="downloadIOS">Tải</button>
                        <button v-else class="btn btn-primary btn-download" @click="downloadAndroid">Tải</button>
                    </div>
                    <div v-else>
                        <p>Phiên bản:</p>
                        <p v-if="dataDetail.iOS" class="appInfo--version">iOS: {{dataDetail.iOS.version}}</p>
                        <p v-if="dataDetail.android" class="appInfo--version">Android: {{dataDetail.android.version}}</p>
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div>
                <h2 class="appDetail__title">Hình ảnh</h2>
                <div class="wrapper">
                    <div class="scrolls">
                        <img v-for="item in dataDetail.listImage" :key="item.id" :src="item.image" alt="" >
                    </div>
                </div>
            </div>
            <div class="line"></div>
            <div class="row">
                <div class="col-12">
                    <h2 class="appDetail__title">Mô tả</h2>
                    <p>{{dataDetail.description}}</p>
                </div>
            </div>
        </div>
</template>

<script>
    import  deviceDetect  from 'mobile-device-detect';
    export default {
        name: "AppDetail",
        data () {
            return {
                isAndroid: deviceDetect.isAndroid,
                isIOS: deviceDetect.isIOS,
                url:'',
                dataDetail : {}
            }
        },
        mounted () {
            this.url = location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '');
            this.$store.dispatch('getAppDetail', this.$route.params.id)
                .then(()=> {
                    this.dataDetail = this.$store.getters.appDetail.data
                })
                .catch(err => console.log(err))
        },
        methods : {
            downloadIOS: function () {
                if(this.dataDetail.iOS.path !== null) {
                    location.href = this.dataDetail.iOS.path
                } else {
                    alert('Không tìm thấy phần mềm')
                }
            },
            downloadAndroid: function () {
                if(this.dataDetail.android.path !== null) {
                    location.href = this.dataDetail.android.path
                } else {
                    alert('Không tìm thấy phần mềm')
                }
            }
        }
    }
</script>

<style scoped>

</style>
