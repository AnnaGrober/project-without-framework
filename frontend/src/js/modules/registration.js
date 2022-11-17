import axios from 'axios';


export class Registration {
    static registration(data) {

        console.log(process.env.APP_URL)
        return axios.post(process.env.APP_URL  + '/api/v1/auth/register', data).then(response => {
            console.log(response.data)
        });

    }
}