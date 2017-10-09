var vue_el = new Vue({
    el:'#vue-demo-root',
    data: {
        nameArray: []
    },
    methods:{
        getNameAjax(){

            var postData = { action:'was_get_names',
                    //key2:'value2',
                    //key3:'value3',
                };

                // IN JQUERY AJAX
             //    jQuery.post(WAS_ajax_obj.ajax_url, postData )
             //    .done( function( $response) {
             //        console.log(this);
             //        vue_el.nameArray = $response;
             //    }).fail( function($error) {
             //     console.log(error);
             // });


                // AXIOS AJAX Method 1 using URLSearchParams
              //   var params = new URLSearchParams();
              //   params.append('action', 'was_get_names');
              //   // params.append('key2', 'value2');
              //   // params.append('key3', 'value3');
              //   axios.post(WAS_ajax_obj.ajax_url, params).then(function (response) {
              //      this.nameArray = response.data;
              //  }.bind(this))
              //   .catch(function (error) {
              //     console.log(error);
              // });

                  //Using Qs.js to convert the data to be sent in proper format
                  axios.post(WAS_ajax_obj.ajax_url, Qs.stringify( postData )
                      ).then(function (response) {
                        this.nameArray = response.data;
                                // this.$parent.ajaxloading = false;
                            }.bind(this))
                      .catch(function (error) {
                        console.log(error);
                    });


              }
          }
      });