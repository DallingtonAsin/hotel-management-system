<template>

<div class="noti__item js-item-menu nunito-font" v-if="smsnotifications.length > 0">
            <i class="zmdi zmdi-comment-more icon-white"></i>
            <span class="quantity">{{ smsnotifications.length }}</span>
            <div class="email-dropdown js-dropdown">
              <div class="email__title">
                <p>You have {{ smsnotifications.length }} new sms messages</p>
              </div>

              <div class="email__item" v-for="notification in smsnotifications">
                <div class="image img-cir bg-warning img-40">
                  <i class="ml-3 mX-3 zmdi zmdi-email text-white"></i>
                </div>
                <div class="content">
                 <p><a href="">{{ notification.data.subject }}</a></p>
                  <span>{{ notification.data.senderName }},
                       {{ FormatDate(notification.data.recordedOn) }}
                       </span>
                </div>
              </div>
              <div class="email__footer">
                <a href="#">See all sms messages</a>
              </div>
            </div>
          </div>



      </template>

      <script>
          import moment from 'moment';
    export default {
         props: ['smsnotifications'],
         methods: {
             FormatDate : function (date) {
                return moment(date, 'YYYY-MM-DD').format('DD-MM-YYYY hh:mm A');
            }
        },
        
    }

    </script>
