import axios from 'axios';
class Auth {
    constructor () {

        this.token = window.localStorage.getItem('token');
        let userData = window.localStorage.getItem('user');
        this.company = window.localStorage.getItem('company');
        // this.user = userData ? JSON.parse(userData) : null;
        if (this.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.token;
        }
    }
    login (token, company) {
        window.localStorage.setItem('token', token);
        // window.localStorage.setItem('user', JSON.stringify(user));
        window.localStorage.setItem('company', JSON.stringify(company));
        window.localStorage.removeItem('c');
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        this.token = token;
        // this.user = user;
        this.company = company;
        return true;
    }
    check () {
        return !! this.token;
    }
    logout () {
        // window.localStorage.clear();
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');
        window.localStorage.removeItem('company');
        // this.user = null;
    }
    verify() {
        return new Promise((resolve, reject) => {
          axios.get('/api/v1/verify-token', {
            headers: {
              'Authorization': `Bearer ${this.token}`
            }
          })
            .then(response => {
              resolve(true);
            })
            .catch(error => {
              if (error.response && error.response.status === 401) {
                resolve(false);
              } else {
                reject(error);
              }
            });
        });
      }
   async hasAccess($permissionName) {

        return await  axios.get(`/api/v1/has/${$permissionName}/access`)
                .then(response => {
                    return response.data.is_allowed;
                })
                .catch(error => {
                if (error.response && error.response.status === 401) {
                    return false;
                } else {
                    return false;
                }
                });

      }
}
export default new Auth();
