const URL = '/purchases'

function purchases(params) {
    return axios.get(URL, {
        params: params
    })
}

function read(id){
    return axios.get(URL + '/' + id)
}

function store(params) {
    return axios.post(URL, params)
}

function update(id, params) {
    return axios.put(URL + '/' + id, params)
}

function remove(id) {
    return axios.delete(URL + '/' + id)
}

module.exports = {
    index: purchases, read, store, update, remove
}
