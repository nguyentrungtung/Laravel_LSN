<template>
<div v-if="checkCreate" class="add_list_select">
    <div class="add_content">
        <p>Add content</p>
    </div>
    <div class="add_view">
        <p>or view existing content</p>
    </div>
    <div @click="showCreate" class="add_list_textarea">
        <p>You have a new content?</p>
    </div>
</div>

<div v-else class="content_edit">
    <div class="content_edit_block">
        <div class="content_edit_input">
            <input type="text" v-model="titleValue" @keyup.enter="doneTitle" @blur="doneTitle" @keyup.esc="cancelEdit" id="content_edit_title" placeholder="Title">
            <select v-model="leverValue" @blur="getlever" @keyup.enter="getlever">		
                <option value="" disabled selected>Lever</option>
                <option value="Beginer">Beginer</option>		
                <option value="Intermidiate">Intermidiate</option>		
                <option value="Expert">Expert</option>		
            </select>
        </div>
        <div class="container ">
            <div class="row text-danger">
                <div class="col-sm-7" :class="{regex:checkRegex.checkTitle}">Lỗi tiêu đề !</div>
                <div class="col-sm-5 regexRight" :class="{regex:checkRegex.checkLever}">Lever is require !</div>
            </div>
        </div>

        <div class="content_edit_date">
            <div class="content_edit_start">
                <p>Start date</p>
                <input type="date" v-model="StartDateValue" @blur="doneStart" @keyup.enter="doneStart" placeholder="Start date">
            </div>
            <div class="content_edit_end">
                <p>End date</p>
                <input type="date" v-model="EndDateValue" @blur="doneEnd" @keyup.enter="doneEnd">
            </div>

        </div>
        <div class="container mb-3">
            <div class="row text-danger">
                <div class="col-sm-7" :class="{regex:checkRegex.checkStartDate}">Lỗi nhập ngày bắt đầu  !</div>
                <div class="col-sm-5 regexRight" :class="{regex:checkRegex.checkEndDate}">Lỗi nhập ngày kết thúc !</div>
            </div>
        </div>

        <!-- <textarea name="editor1"></textarea> -->
        <vue-editor v-model="DesValue" @blur="doneDes"  :editorToolbar="customToolbar"></vue-editor>
         <div class="col-sm-5 regexRight text-danger" :class="{regex:checkRegex.checkDes}">Vui lòng nhập nội dung !</div>
        <input @click="DoneContent" type="button" id="add_content_done" value="DONE">
        <input @click="showCreate" type="button" id="add_content_done" style="background: white; color: #000000d4;		border: 1px solid #80808075;" value="Cancel">
    </div>
</div>
</template>

<script>
import {
    VueEditor
} from 'vue2-editor'
export default {
    name: 'CreateContent',

    components: {

        VueEditor: VueEditor,
    },
    mounted() {
     var str = localStorage.getItem("user");
      this.user = JSON.parse(str);
  },
    data() {
        return {
            user:{},
            checkCreate: true,
            titleValue: '',
            StartDateValue: '',
            EndDateValue: '',
            DesValue:'',
            leverValue:'',
            checkRegex: {
                checkTitle: true,
                checkLever: true,
                checkStartDate: true,
                checkEndDate: true,
                checkDes: true,
            },
            customToolbar: [
                ["bold", "italic", "underline"],
                [{
                    list: "ordered"
                }, {
                    list: "bullet"
                }],
                ["image", "code-block"],
            ],
        }
    },
    methods: {
        showCreate: function () {
            this.checkCreate = !this.checkCreate;
        },
        DoneContent:function(){
          if(this.titleValue==''){
            this.checkRegex.checkTitle=false;
          }
          if(this.StartDateValue==''){
              this.checkRegex.checkStartDate=false
          }
          if(this.EndDateValue==''){
              this.checkRegex.checkEndDate=false;
          }
          if(this.DesValue==''){
              this.checkRegex.checkDes=false
          }
          if(this.checkRegex.checkTitle==true && this.checkRegex.checkStartDate==true && this.checkRegex.checkEndDate==true && this.checkRegex.checkDes==true && this.checkRegex.checkLever==true){
            this.$http.post("https://ccd301eb.ngrok.io/api/content/post", {
            class_id:1,
            title:this.titleValue,
            content : this.DesValue,
            level : this.leverValue,
            start_date :this.StartDateValue,
            end_date : this.EndDateValue,
            email : this.user.email,   
              })
              .then(data => {
                  console.log(data);
                 this.checkCreate=!this.checkCreate;
                this.$router.push({ path: '/show' })
              }).catch(err=>{
                  console.log('bị lỗi rồi ');
              });
          }
        },
        show_dropdown: function () {
            this.dropdown = true
        },
        doneTitle: function () {
            if (this.titleValue == '' || this.titleValue.length >= 64) {
                this.checkRegex.checkTitle = false;
            } else {
                this.checkRegex.checkTitle = true;
            }
        },
        getlever:function(){
            console.log(this.leverValue);
            if(this.leverValue==''){
                this.checkRegex.checkLever=false;
            }else{
                this.checkRegex.checkLever=true;
            }
        },
        doneStart: function () {
            var moment = require('moment');
            var now =moment(moment().format("YYYY MM DD")) ;
        
            
            var dayStart = moment(this.StartDateValue);
            var dayEnd = moment(this.EndDateValue);
            console.log(dayStart - now);
            
            if (this.EndDateValue != '') {
                if ((dayEnd - dayStart) < 0) {
                    this.checkRegex.checkEndDate = false;
                    this.checkRegex.checkStartDate = true;
                } else if ((now - dayStart) / (1000 * 60 * 60) > 0) {
                    this.checkRegex.checkStartDate = false;
                     this.checkRegex.checkEndDate = true;
                } else {
                    this.checkRegex.checkStartDate = true;
                    this.checkRegex.checkEndDate = true;
                }
            } else {
                if ((dayStart - now) / (1000 * 60 * 60) >=0 ) {
                    console.log('check day ' +(dayStart - now) / (1000 * 60 * 60));
                    
                    this.checkRegex.checkStartDate = true;
                } else {
                     console.log('check day ' +(dayStart - now) / (1000 * 60 * 60));
                    this.checkRegex.checkStartDate = false;
                }
            }

        },
        doneEnd: function () {
            var moment = require('moment');
            
            var now =moment(moment().format("YYYY MM DD")) ;
            var dayEnd = moment(this.EndDateValue);
            var dayStart = moment(this.StartDateValue);
            if (this.StartDateValue == '') {
                if (((now - dayEnd) / (1000 * 60 * 60) > 0)) {
                    this.checkRegex.checkEndDate = false;
                } else {
                    this.checkRegex.checkEndDate = true;
                }
            } else {
                console.log(dayEnd - dayStart);
                if ((dayEnd - dayStart) < 0) {
                    this.checkRegex.checkEndDate = false;
                } else {
                    this.checkRegex.checkEndDate = true;
                }
            }
        },
        doneDes:function(){
            if(this.DesValue==''){
                this.checkRegex.checkDes=false;
            }else{
                this.checkRegex.checkDes=true;
            }
        }
    },
    computed: {

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>
.regex {
    display: none;
}
select:required:invalid {
  color: gray;
}
option[value=""][disabled] {
  display: none;
}
option {
  color: black;
}
</style>
