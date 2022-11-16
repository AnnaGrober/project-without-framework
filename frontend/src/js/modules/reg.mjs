import axios from 'axios';


function reg () {
    axios.post(`http://127.0.0.1.nip.io/v1/auth/register`)
        .then(response => {
            console.log(response.data)
        })
}

export {reg};