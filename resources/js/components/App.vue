<template>
    <div>
        <Header></Header>
        <router-view/>
        <Footer></Footer>
    </div>

</template>

<script>
    import Footer from '../components/common/Footer'
    import Header from '../components/common/Header'

    export default {
        name: 'app',
        components: {
            Footer,
            Header
        }
    }
</script>
