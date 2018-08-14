<template>
<div class="content_edit">
    <div class="content_edit_block">
        <div class="content_edit_input">
            <input type="text" v-model="titleValue" @keyup.enter="doneTitle" @blur="doneTitle" @keyup.esc="cancelEdit" id="content_edit_title" placeholder="Title">
            <select id="listlever" v-model="leverValue" @blur="getlever" @keyup.enter="getlever">

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
                <div class="col-sm-7" :class="{regex:checkRegex.checkStartDate}">Lỗi nhập ngày bắt đầu !</div>
                <div class="col-sm-5 regexRight" :class="{regex:checkRegex.checkEndDate}">Lỗi nhập ngày kết thúc !</div>
            </div>
        </div>

        <!-- <textarea name="editor1"></textarea> -->
        <vue-editor v-model="DesValue" @blur="doneDes" :editorToolbar="customToolbar"></vue-editor>
        <div class="col-sm-5 regexRight text-danger" :class="{regex:checkRegex.checkDes}">Vui lòng nhập nội dung !</div>
        <input @click="DoneContent" type="button" id="add_content_done" value="DONE">
        <input @click="CancelContent" type="button" id="add_content_done" style="background: white; color: #000000d4;		border: 1px solid #80808075;" value="Cancel">
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
        var moment = require('moment');
        var str = localStorage.getItem("user");
        this.user = JSON.parse(str);
        this.content = JSON.parse(localStorage.getItem('content'));
        this.titleValue = this.content.title;
        this.StartDateValue = moment(this.content.start_date).format("YYYY-MM-DD");
        this.EndDateValue = moment(this.content.end_date).format("YYYY-MM-DD");
        this.DesValue = this.content.content;
        this.leverValue = this.content.level;
        // console.log(this.leverValue);

        this.selectItemByValue(this.leverValue)
    },
    data() {
        return {
            content: {},
            checkCreate: true,
            titleValue: '',
            StartDateValue: '',
            EndDateValue: '',
            DesValue: '',
            leverValue: '',
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
        CancelContent: function () {
            this.$router.push({
                path: '/show'
            })
        },
        showCreate: function () {
            this.checkCreate = !this.checkCreate;
        },
        DoneContent: function () {
            if (this.titleValue == '') {
                this.checkRegex.checkTitle = false;
            }
            if (this.StartDateValue == '') {
                this.checkRegex.checkStartDate = false
            }
            if (this.EndDateValue == '') {
                this.checkRegex.checkEndDate = false;
            }
            if (this.DesValue == '') {
                this.checkRegex.checkDes = false
            }
            if (this.checkRegex.checkTitle == true && this.checkRegex.checkStartDate == true && this.checkRegex.checkEndDate == true && this.checkRegex.checkDes == true && this.checkRegex.checkLever == true) {
                var id = this.content.id
                this.$http.post(`https://ccd301eb.ngrok.io/api/content/post/${id}`, {
                        class_id: 1,
                        title: this.titleValue,
                        content: this.DesValue,
                        level: this.leverValue,
                        start_date: this.StartDateValue,
                        end_date: this.EndDateValue,
                        email: this.user.email,

                    })
                    .then(data => {
                        console.log(data);
                        this.$router.push({
                            path: '/show'
                        })
                    }).catch(err => {
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
        getlever: function () {
            console.log(this.leverValue);
            if (this.leverValue == '') {
                this.checkRegex.checkLever = false;
            } else {
                this.checkRegex.checkLever = true;
            }
        },
        doneStart: function () {
            var moment = require('moment');
            var now = moment(moment().format("YYYY MM DD"));

            var dayStart = moment(this.StartDateValue);
            var dayEnd = moment(this.EndDateValue);
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
                if ((dayStart - now) / (1000 * 60 * 60) >= 0) {
                    this.checkRegex.checkStartDate = true;
                } else {
                    this.checkRegex.checkStartDate = false;
                }
            }

        },
        doneEnd: function () {
            var moment = require('moment');

            var now = moment(moment().format("YYYY MM DD"));
            var dayEnd = moment(this.EndDateValue);
            var dayStart = moment(this.StartDateValue);
            if (this.StartDateValue == '') {
                if (((now - dayEnd) / (1000 * 60 * 60) > 0)) {
                    this.checkRegex.checkEndDate = false;
                } else {
                    this.checkRegex.checkEndDate = true;
                }
            } else {
                if ((dayEnd - dayStart) < 0) {
                    this.checkRegex.checkEndDate = false;
                } else {
                    this.checkRegex.checkEndDate = true;
                }
            }
        },
        doneDes: function () {
            if (this.DesValue == '') {
                this.checkRegex.checkDes = false;
            } else {
                this.checkRegex.checkDes = true;
            }
        },
        selectItemByValue: function (value) {
            var elmnt = this.$el.getElementById('listlever');
            for (var i = 0; i < elmnt.options.length; i++) {
                if (elmnt.options[i].value == value) {
                    console.log(i);
                    elmnt.selectedIndex = i;
                }

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

.content_edit {
    margin-right: 40px;
    height: auto;
    background: white;
    margin-top: 25px;
    width: 100%;
    border: 1px solid #80808029;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.content_edit_block {
    padding: 20px;
}

.content_edit_input {
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding-bottom: 10px;
}

.content_edit_input input {
    width: 47%;
    height: 30px;
    padding-right: 10px;
    padding-left: 15px;
    outline: none;
}

.content_edit_input select {
    width: 47%;
    padding-left: 15px;
    outline: none;
}

.content_edit textarea {
    width: 100%;
    padding: 30px;
    outline: none;
}

.content_edit_date {
    display: flex;
    margin-top: 30px;
    width: 100%;
}

.content_edit_start {
    margin-right: 45px;
    width: 50%;
    display: flex;
    justify-content: space-between;
}

.content_edit_end {
    width: 50%;
    display: flex;
    justify-content: space-between;
}

.content_edit_start p,
.content_edit_end p {
    padding-bottom: 10px;
}

.content_edit_start input,
.content_edit_end input {
    height: 30px;
    font-size: 19px;
    width: 78%;
    outline: none;
    border: 1px solid #80808061;
    border-radius: 0px;
    text-align: center;
    padding-left: 35px;
}

#add_content_done {
    width: 72px;
    height: 35px;
    background: lightseagreen;
    color: white;
    outline: none;
    border: none;
    margin-top: 3%;
    margin-right: 3%;
    cursor: pointer;
}

/* End style for content_edit */

/* style for list-item */

.infor_menu ul a {
    width: 100%;
    text-decoration: none;
    color: #000000a6;
}

.infor_menu ul li {
    list-style: none;
    width: 100%;
    height: 50px;
    background: white;
    text-align: center;
    line-height: 50px;
    font-size: 22px;
}

/* style for list-item */

.list__item {
    width: 100%;
    height: auto;
    margin-top: 55px;
    display: flex;
    justify-content: space-between;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}

.list__item__intro {
    background-image: url('../assets/bg.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    width: 30%;
    height: 450px;
    position: relative;
}

.item__status {
    width: 100%;
    display: flex;
    justify-content: flex-start;
    padding-top: 31px;
}

.item__status__text {
    width: 95px;
    height: 30px;
    text-align: center;
    line-height: 30px;
    background: white;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
    cursor: pointer;
    margin-left: 25px;
    margin-right: 45px;
}

.item__status__icon {
    font-size: 24px;
    color: white;
}

.item__status__icon i {
    color: #ff000078;
}

.item__content {
    display: flex;
    justify-content: space-around;
    padding-top: 30px;
}

.item__content__avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-left: 15px;
}

.item__content__avatar img {
    width: 100%;
    height: 100%;
}

.item__content__descript {
    width: 75%;
    color: white;
    padding-left: 13px;
    line-height: 15px;
}

.item__title span {
    font-size: 30px;
}

.item__title {
    margin-top: 25px;
    margin-bottom: 25px;
}

.item__title:after {
    content: "";
    display: block;
    border: 0.5px solid #808080b5;
    width: 33%;
    height: 0.5px;
}

.item__content__name {
    padding-bottom: 10px;
}

.item__attendance {
    width: 170px;
    height: 50px;
    border: 1px solid white;
    text-align: center;
    line-height: 50px;
    position: absolute;
    top: 80%;
    left: 18%;
    color: white;
    cursor: pointer;
}

.list__item__content {
    width: 70%;
    height: 100%;
    position: relative;
    padding: 0 15px;
}

.item__title {
    width: 94%;
}

.item__content {
    width: 100%;
    height: 5%;
}

.item__option__icon {
    width: 5%;
    height: 5%;
    position: absolute;
    top: 0;
    left: 95%;
    font-size: 19px;
    cursor: pointer;
}

.item__option__text {
    width: 160px;
    height: 90px;
    background: white;
    text-align: center;
    position: absolute;
    top: 3%;
    left: 67%;
}

.item__option__text p {
    display: block;
    width: 100%;
    height: 30px;
    cursor: pointer;
    margin: 0;
}

.item__option__text p:hover {
    background: gray;
    color: white;
}

/* End style for list-item */

.regexRight {
    margin-left: -30px;
}
</style>
