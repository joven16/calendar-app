<template>
  <div id="app">
    
    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Calendar</a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        </div>
      </nav>
      <br>
      <div class="row">
        <div class="col-4">
            <div class="form-group">
              <label for="event">Event</label>
              <input type="text" placeholder="My Event..." class="form-control"  v-model="event">
            </div>
            <div class="row">
              <div class="col">
                <label for="event">From</label>
                <section>
                  <date-picker
                    v-model="dateFrom"
                    format="YYYY-MM-DD"
                    type="date"
                    placeholder="Select date from"
                  ></date-picker>
                </section>
              </div>
              <div class="col">
                <label for="event">To</label>
                <section>
                  <date-picker
                    v-model="dateTo"
                    format="YYYY-MM-DD"
                    type="date"
                    placeholder="Select date to"
                  ></date-picker>
                </section>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col">
              <input type="checkbox" id="mon" value="1" v-model="checkedNames">
              <label class="cb" for="mon">Mon</label>
              <input type="checkbox" id="tue" value="2" v-model="checkedNames">
              <label class="cb" for="tue">Tue</label>
              <input type="checkbox" id="wed" value="3" v-model="checkedNames">
              <label class="cb" for="wed">Wed</label>
              <input type="checkbox" id="thu" value="4" v-model="checkedNames">
              <label class="cb" for="thu">Thu</label>
              <input type="checkbox" id="fri" value="5" v-model="checkedNames">
              <label class="cb" for="fri">Fri</label>
              <input type="checkbox" id="sat" value="6" v-model="checkedNames">
              <label class="cb" for="sat">Sat</label>
              <input type="checkbox" id="sun" value="0" v-model="checkedNames">
              <label class="cb" for="sun">Sun</label>
              <br>
              <!-- <span>Checked days: {{ checkedNames }}</span> -->
            </div>
            </div><br>
            <button @click="addevent" class="btn btn-primary">Save Event</button>
            
        </div>
        <div class="col-8">
          <FullCalendar
          class='demo-app-calendar'
          ref="fullCalendar"
          defaultView="listMonth"
          :views="{
            listDay: { buttonText: 'list day' },
            listWeek: { buttonText: 'list week' },
            listMonth: { buttonText: 'list month' }
          }"
          :header="{
            left: 'prev,next today',
            center: 'title',
            right: 'listMonth,listWeek,dayGridMonth'
          }"
          :plugins="calendarPlugins"
          :weekends="calendarWeekends"
          :events="calendarEvents"
          
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
//@dateClick="handleDateClick"
// import HelloWorld from './components/HelloWorld.vue'
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
// import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import DatePicker from 'vue2-datepicker'
import moment from 'moment'

let data = [{
          title: 'Test Event',
          startRecur: '2019-12-01',
          endRecur: '2019-12-04',
          allDay: true
        }];
let dayArr = [];

export default {
  
  components: {
    FullCalendar, // make the <FullCalendar> tag available
    DatePicker
  },
  data: function() {
    return {
      calendarPlugins: [ // plugins must be defined in the JS
        dayGridPlugin,
        // timeGridPlugin,
        interactionPlugin, // needed for dateClick
        listPlugin
      ],
      calendarWeekends: true,
      calendarEvents: data,
      dateFrom: null,
      dateTo: null,
      event: null,
      checkedNames: []
    }
  },
  methods: {
    toggleWeekends() {
      this.calendarWeekends = !this.calendarWeekends // update a property
    },
    gotoPast() {
      let calendarApi = this.$refs.fullCalendar.getApi() // from the ref="..."
      calendarApi.gotoDate('2000-01-01') // call a method on the Calendar object
    },
    addevent(){
      if(this.event == null){
        this.$toast.open({
            message: 'Input Event name',
            type: 'error',
            position: 'top-right'
        });
        return false;
      } 
      if(this.dateFrom == null){
        this.$toast.open({
            message: 'Select date from',
            type: 'error',
            position: 'top-right'
        });
        return false;
      } 
      if(this.dateTo == null){
        this.$toast.open({
            message: 'Select date to',
            type: 'error',
            position: 'top-right'
        });
        return false;
      }
      if(this.checkedNames.length < 1){
        this.$toast.open({
            message: 'Select day of the week',
            type: 'error',
            position: 'top-right'
        });
        return false;
      } 
      
        let currentObj = this;
        this.axios.post('http://localhost:8000/api/addEvent', {
            event: this.event,
            startRecur: moment(String(this.dateFrom)).format('YYYY-MM-DD'),
            endRecur: moment(String(this.dateTo)).format('YYYY-MM-DD'),
            daysOfWeek: this.checkedNames.toString(),
            allDay: 1,
            backgroundColor: 'green'
        })
        .then(function (response) {
            currentObj.output = response.data;
        })
        .catch(function (error) {
            currentObj.output = error;
            return false;
        });

        this.calendarEvents = [];
        this.calendarEvents.push({
          title: this.event,
          startRecur: this.dateFrom,
          endRecur: this.dateTo,
          daysOfWeek: this.checkedNames,
          allDay: true,
          backgroundColor: 'green'
        });

        this.$toast.open({
            message: 'Event successfully saved',
            type: 'success',
            position: 'top-right'
        });
       
    }
  }
}
</script>

<style lang='scss'>

// you must include each plugins' css
// paths prefixed with ~ signify node_modules
@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
// @import '~@fullcalendar/timegrid/main.css';
@import '~@fullcalendar/list/main.css';
@import '~vue2-datepicker/scss/index.scss';


.demo-app {
  font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
  font-size: 14px;
}

.demo-app-top {
  margin: 0 0 3em;
}

.demo-app-calendar {
  // margin: 0 auto;
  // margin-right: 20px;
  // margin-left: 40%;
  max-width: 800px;
  margin-left: 0%;
  margin-bottom: 10%;
}
.dt{
    margin-right: 10px;
}
.cb{
  margin-right: 10px;
}
.mx-datepicker {
    position: relative;
    display: inline-block;
    width: 100% !important;
}
</style>
