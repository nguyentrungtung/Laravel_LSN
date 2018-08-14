import Vue from 'vue'
import Router from 'vue-router'
import Attendance from '../components/Attendance.vue'
import Calendar from '../components/Calendar.vue'
import ListContent from '../components/ListContent.vue'
import Member from '../components/Member.vue'
import PendingItems from '../components/PendingItems.vue'
import slide_logout from '../components/slide_logout.vue'
import Show from '../components/Show.vue'
import CreateContent from '../components/Create_Content.vue'
import EditContent from '../components/EditContent.vue'

Vue.use(Router)
 export default new Router({
   routes: [
    {
      path: '/', 
      component: slide_logout
    },
    {
      path: '/:id', component: Show,
      children: [
        { path: '', component: ListContent },
        { path: 'member', component: Member },
        { path: 'attendance', component: Attendance },
        { path: 'calendar', component: Calendar },
        { path: 'pendingitems', component: PendingItems },
        { path: 'editcontent', component: EditContent },
      ]
    },
 ],
 mode:'history'
})
