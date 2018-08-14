<template>
    <div class="calendar_show">
      <full-calendar ref="calendar" ></full-calendar>
      <!--history-->
      <div class="history_show">
        <h2>HISTORY</h2>
        <!--
        <div v-for="historyitem in historyitems" :key="historyitem.id" class="item_history">
          <div class="historyitem_status">
            <p>{{historyitem.start_date}}</p>
            <p>{{historyitem.title}}</p>
          </div>
        </div>
        -->
        <div  class="item_history">
          <div class="historyitem_status">
            <p>22th June,2017</p>
            <p>team building - CV Thu Le 4h30</p>
            <div>
              <router-link to="/user">View content</router-link>
            </div>
          </div>
        </div>
        <div class="history_older">
          <button>Older</button>
        </div>
      </div>

    </div>
</template>
<script>
export default {
  name: 'calendar',
  components:{
    'full-calendar': require('vue-fullcalendar')
  },
  data () {
    return {
      
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style >
.calendar_show{
  width:69%;
  padding-right: 20px;
  height:auto !important;
  border:1px soild black !important;
}
.full-calendar-body .weeks {
    display: flex;
    border-top: 1px solid black;
    border-bottom: 1px solid black;
    border-left: 1px solid black;
}
.full-calendar-body .weeks .week {
    flex: 1;
    text-align: center;
    border-right: 1px solid black;
}
.full-calendar-body .dates .week-row {
    border-left: 1px solid black;
    display: flex;
}
.full-calendar-body .dates .week-row .day-cell {
    flex: 1;
    min-height: 100px;
    padding: 4px;
    border-right: 1px solid black;
    border-bottom: 1px solid black;
}
/* history*/
.history_show{
  border: 1px soild #0000005c;
  width:100%;
  height:auto;
  padding: 0 5px 10px 10px;
}
.history_older{
  text-align:center;
}
.history_older button{
  border:none;
  width:100px;
}
</style>