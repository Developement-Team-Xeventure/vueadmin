import 'toastr/build/toastr.css';
import toastr from 'toastr';
toastr.options = {
    closeButton: true,
    newestOnTop: true,
    progressBar: true,
  };

export default {
    install(app) {
    //   // Global function 1
    //   app.config.globalProperties.$myFunction1 = () => {
    //     console.log('Global function 1');
    //   };

    //   // Global function 2
    //   app.config.globalProperties.$myFunction2 = (message) => {
    //     console.log('Global function 2:', message);
    //   };



      app.config.globalProperties.api = async (method, apiUrl, dataObject) => {
        try {
          return await axios({
            method: method,
            url: "/api/v1/" + apiUrl,
            data: dataObject,
          });
        } catch (e) {
          return e.response;
        }
      };

      app.config.globalProperties.toast = toastr;

      app.config.globalProperties.token = window.localStorage.getItem('token');


    },
  };
