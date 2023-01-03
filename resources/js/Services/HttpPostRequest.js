export const httpPostRequest = async (url, payload) => {
    try {
        let response =  await axios.post(url, payload)
        return {
            status : response.status,
            data : response.data
        }
    } catch (e) {
        if (e.response.status === 422){
            return {
                status: e.response.status,
                errors: e.response.data.errors
            }
        }
        return {
            status: e.response.status,
            error: e.response.data
        }
    }
}

export default httpPostRequest
