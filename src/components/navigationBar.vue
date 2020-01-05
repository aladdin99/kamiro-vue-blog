<template>
    <div class="nav">
        <div class="banner-left">
            <span style="margin-right: 15px;">MDSN</span>
            <ul>
                <li v-for="(item,index) in bannerData" :key="index" @click="nextInfo(index)"><span :class="{'checked':(item.flag)}" :title="item.name">{{item.name}}</span></li>
            </ul>
            <el-select
                    size="small" v-model="value" filterable remote reserve-keyword
                    placeholder="Python进阶之路" :remote-method="remoteMethod" :loading="loading"
            >
                <el-option
                        v-for="item in options" :key="item.value"
                        :label="item.label" :value="item.value">
                </el-option>
            </el-select>
        </div>
        <div class="banner-right">
            <span class="blogging">
                <i class="el-icon-edit" style="padding-right: 5px;"></i>
                <span>写博客</span>
            </span>
            <el-badge :value="12" class="item">
                <i class="el-icon-message-solid message"></i>
            </el-badge>

            <span class="logister">登陆/注册</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: "navigationBar",
        data() {
            return {
                bannerData: [{name:"首页",flag:true},{name:"博客",flag:false},{name:"问答",flag:false},{name:"活动",flag:false}],
                options: [],
                value: [],
                list: [],
                loading: false,
                states: ["Alabama", "Alaska", "Arizona",
                    "Arkansas", "California", "Colorado",
                    "Connecticut", "Delaware", "Florida",
                    "Georgia", "Hawaii", "Idaho", "Illinois",
                    "Indiana", "Iowa", "Kansas", "Kentucky",
                    "Louisiana", "Maine", "Maryland",
                    "Massachusetts", "Michigan", "Minnesota",
                    "Mississippi", "Missouri", "Montana",
                    "Nebraska", "Nevada", "New Hampshire",
                    "New Jersey", "New Mexico", "New York",
                    "North Carolina", "North Dakota", "Ohio",
                    "Oklahoma", "Oregon", "Pennsylvania",
                    "Rhode Island", "South Carolina",
                    "South Dakota", "Tennessee", "Texas",
                    "Utah", "Vermont", "Virginia",
                    "Washington", "West Virginia", "Wisconsin",
                    "Wyoming"]
            }
        },
        mounted() {
            this.list = this.states.map(item => {
                return { value: `value:${item}`, label: `${item}` };
            });
        },
        methods: {
            remoteMethod(query) {//快捷搜索
                if (query !== '') {
                    this.loading = true;
                    setTimeout(() => {
                        this.loading = false;
                        this.options = this.list.filter(item => {
                            return item.label.toLowerCase()
                                .indexOf(query.toLowerCase()) > -1;
                        });
                    }, 200);
                } else {
                    this.options = [];
                }
            },
            nextInfo(index){
                this.bannerData.forEach(item=>{
                    item.flag = false;
                });
                this.bannerData[index].flag=true;
            }
        }
    }
</script>

<style lang="less">
    *{margin: 0;padding: 0;}
    .nav{
        box-shadow: 0 2px 4px 0 rgba(0,0,0,.05);height: 4.5rem;padding: 0 12%;background-color: #fff;
        display: flex;justify-content: space-between;align-items: center;cursor: pointer;}
    .banner-left{
        ul {list-style-type:none;display:inline-block;
            li{display: inline-block;height: 100%;padding: 0 1.5rem;line-height: 4.5rem;transition: background-color .5s;color: #666C7A;box-sizing: border-box;}
            li:hover{background-color: #F0F0F0;transition: background-color .5s;}
            .checked{border-bottom: 2px solid #D92E2E;color: #222429;display: inline-block;}
        }
        .el-select{margin-left: 1.5rem;}
    }
    .banner-right{display: flex;justify-content: space-between;align-items: center;
        .blogging{color: #D92E2E;display: inline-block;height:100%;;padding: 0 1.5rem;line-height: 4.8rem;
            &:hover{background-color: #fff1f1;transition: background-color .5s;}
        }
        .item{padding: 0 2rem;
            .el-badge__content.is-fixed{right: 2.5rem;}
            .el-badge__content{
            font-size: .8rem;height: 1.2rem;line-height: 1.5rem;padding: 0px .4rem;
        }}
        .message{color: #C3C3C3;font-size: 1.6rem;}
        .logister{display: inline-block;height: 100%;padding: 0 1.5rem;line-height: 4.8rem;transition: background-color .5s;}
        .logister:hover{background-color: #F0F0F0;transition: background-color .5s;}
    }
</style>