import axios from 'axios'

export const getNews = async (page = 1, perPage = 6) => {
    const response = await axios.get('/news', {
        params: {
            page,
            per_page: perPage,
        },
    })

    return response.data.data
}

export const storeNews = async (data) => {
    const response = await axios.post('/news', data)

    return response.data.data
}

export const getNew = async (id) => {
    const response = await axios.get(`/news/${id}`)

    return response.data.data
}

export const updateNews = async (id, data) => {
    const response = await axios.put(`/news/${id}`, data)

    return response.data.data
}

export const deleteNews = async (id) => {
    const response = await axios.delete(`/news/${id}`)

    return response.data
}
