// import './admin/vendor-approval.js'
class Admin {
    constructor() {
        // this.init();
        
    }
    // init() {
       
    // }
   getToken(){
    return document.head.querySelector('meta[name="csrf-token"]').content;
   }
    sendRequest(url, method, data = null) {
        console.log({url, method, data})
        let token = this.getToken();
        let options = {
            method: method,
            url: url,
            data: data,
        };
        if (token) {
            options.headers = {
                "X-CSRF-TOKEN": token,
            };
        }
        return axios(options);
    }
}

export default Admin;
