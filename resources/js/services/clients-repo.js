const URL = '/clients'

const create = async function (data) {
    axios.post(URL, data)
}
const read = async function (params) {
    axios.get(URL + client.id, {
        params: params
    })
}
const update = async function (data) {
    axios.put(URL, data)
}
const remove = async function (client) {
    axios.delete(URL + '/' + client.id)
}

export {create, read, update, remove}
