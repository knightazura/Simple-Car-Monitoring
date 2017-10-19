import axios from 'axios'

export function get (url) {
  return axios({
    method: 'GET',
    url: url
  })
}

export function post (url, payload) {
  return axios({
    method: 'POST',
    url: url,
    data: payload
  })
}

// "delete" is reserved keyword
export function del (url) {
  return axios({
    method: 'DELETE',
    url: url
  })
}

export function interceptors (callback) {
  axios.interceptors.response.use((res) => {
    return res
  }, (err) => {
    callback(err)
    return Promise.reject(err)
  })
}
