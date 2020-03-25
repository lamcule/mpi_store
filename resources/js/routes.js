// import AppList from './components/AppList'
// import AppDetail from './components/AppDetail'
import ListApp from './components/listApp/ListApp'
import AppDetail from './components/appDetail/AppDetail'

const routes = [
    {
        path: '*',
        redirect: '/'
    },
    {
        path: '/',
        name: 'home',
        component: ListApp
    },
    {
        path: '/chi-tiet/:id',
        name: 'Detail',
        component: AppDetail,
    },

];

export default routes;