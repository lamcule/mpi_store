<template>
<div>
    <div class="container header">
        <div class="row py-3">
            <div class="col-2 col-md-1 col-xl-1 header-img">
                <router-link :to="{name:'home'}">
                    <img v-if="settingInfo.logo" :src=settingInfo.logo alt="" class="rounded-circle">
                    <img v-else src="./../../../../public/images/logo.png" alt="" class="rounded-circle">
                </router-link>
            </div>
            <div class="col-10 col-md-11 col-xl-11 pl-0 mt-2 pl-lg-3 pl-md-5 header-text">
                <h1 v-if="settingInfo.siteName">{{settingInfo.siteName}}</h1>
                <h1 v-else>Bộ Kế Hoạch và Đầu Tư</h1>
                <p v-if="settingInfo.smallSiteName">{{settingInfo.smallSiteName}}</p>
                <p v-else>Phần mềm quản lý ứng dụng nội bộ</p>
            </div>
        </div>
    </div>
    <div class="line"></div>
</div>
</template>

<script>
    export default {
        name: "Header",
        data () {
            return{
                settingInfo: {}
            }
        },
        mounted() {
            this.$store.dispatch('getSettingInfo1')
                .then(() => {
                    this.settingInfo = this.$store.getters.settingInfo.data
                    console.log(123)
                })
                .catch(err => console.log(err))
        }
    }
</script>

<style scoped>

</style>
