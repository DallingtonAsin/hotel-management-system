<template>

 <div class="noti__item js-item-menu nunito-font" v-if="notifications.length > 0">
            <i class="zmdi zmdi-notifications icon-white"></i>
            <span class="quantity">{{ notifications.length }}</span>
            <div class="email-dropdown js-dropdown">
              <div class="email__title">
                <p>You have {{ notifications.length }} new notifications</p>
              </div>

              <div class="email__item" v-for="notification in notifications">
                <div class="image img-cir bg-warning img-40">
                  <i class="ml-3 mt-3 pb-4 zmdi zmdi-email text-white"></i>
                </div>
                <div class="content">
                 <p><a href="">{{ notification.data.title }}</a></p>
                  <span>{{ notification.data.subject }},
                       {{ FormatDate(notification.data.recordedOn) }}
                       </span>
                </div>
              </div>
              <div class="email__footer">
                <a href="#">See all notifications</a>
              </div>
            </div>
          </div>




      </template>
 
      <script>
          import moment from 'moment';
    export default {
         props: ['notifications'],
         methods: {
             FormatDate : function (date) {
                return moment(date, 'YYYY-MM-DD').format('MM DD, YYYY hh:mm A');
            }
        },
          head: {

      link: [
        { rel: 'canonical', href: "", id: 'canonical' },
        { rel: 'author', href: 'author', undo: false },
     
      ],

      script: [
        { type: 'text/javascript', src:"../../public/js/main.js", async: true, body: true}, // Insert in body
      ],
      
    }
    
       
    }

    </script>
