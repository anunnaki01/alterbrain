export const httpGetRequest = async (url) => {
    try {
        let response = await axios.get(url)
        return {
            status: response.status,
            data: response.data
        }
    } catch (e) {
        return {
            status: e.response.status,
            error: e.response.data
        }
    }
}

export default httpGetRequest
