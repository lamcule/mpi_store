import axios from 'axios'

const axiosCus = axios.create({
    baseURL: location.protocol+'//'+location.hostname+(location.port ? ':'+location.port: '') + '/api'
})

export default {
    axiosCus
}