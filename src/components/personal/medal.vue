<template>
    <div class="medal">
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="已获取" name="first">
                <div class="gained">
                    <div class="gained_item" v-for="(item,index) in gained" :key="index">
                        <div>
                            <img :src='item.img'>
                        </div>
                        <div>
                            <span>{{item.name}}</span>
                            <span>{{item.content}}</span>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
            <el-tab-pane label="未获取" name="second">
                <div class="gained">
                    <div class="gained_item" v-for="(item,index) in lossed" :key="index">
                        <div>
                            <img :src='item.img'>
                        </div>
                        <div>
                            <span>
                                <span>{{item.name}}</span>
                                <span style="padding: .5rem 1.5rem;border:1px solid #d74850;position:absolute;right:.5rem;bottom:-.5rem;border-radius: .2rem;color: #ca0c16;font-weight:400;cursor:pointer;">立即激活</span>
                            </span>
                            <span>{{item.content}}</span>
                        </div>
                    </div>
                </div>
            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                activeName: 'first',
                gained: [{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qiandao-1.png',
                    name: '签到新秀',
                    content: '累计签到获取，不积跬步，无以至千里，继续坚持！'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/chizhiyiheng.png',
                    name: '持之以恒',
                    content: '授予每个自然月内发布4篇或4篇以上原创或翻译IT博文的用户。不积跬步无以至千里，不积小流无以成江海，程序人生的精彩需要坚持不懈地积累！'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qixiebiaobing-1.png',
                    name: '勤写标兵Lv1',
                    content: '授予每个自然周发布1篇到3篇原创IT博文的用户。本勋章将于次周周三上午根据用户上周的博文发布情况由系统自动颁发。'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qixiebiaobing-2.png',
                    name: '勤写标兵Lv2',
                    content: '授予每个自然周发布4篇到6篇原创IT博文的用户。本勋章将于次周周三上午根据用户上周的博文发布情况由系统自动颁发。'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/qixiebiaobing-4.png',
                    name: '勤写标兵Lv2',
                    content: '授予每个自然周发布9篇以上（包括9篇）原创IT博文的用户。本勋章将于次周周三上午根据用户上周的博文发布情况由系统自动颁发。'
                }],
                lossed: [{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/nojinpai.svg',
                    name: '金牌',
                    content: '总榜技术专家分月排行榜第一'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/noyinpai.svg',
                    name: '银牌',
                    content: '总榜技术专家分月排行榜第二'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/notongpai.svg',
                    name: '铜牌',
                    content: '总榜技术专家分月排行榜第三'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/nozhuangyuan.svg',
                    name: '状元',
                    content: '总榜技术专家分年内排名榜第一'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/nobangyan.svg',
                    name: '榜眼',
                    content: '总榜技术专家分年内排名榜第二'
                },{
                    img: 'http://localhost/graduation_project/blog2/src/assets/medal/notanhua.svg',
                    name: '探花',
                    content: '总榜技术专家分年内排名榜第三'
                }],
            };
        },
        methods: {
            handleClick(tab, event) {
                console.log(tab, event);
            }
        }
    };
</script>

<style lang="less">
    .medal{display: inline-block;width: 65vw;padding-right: 5rem;padding-left:2em;
        .gained{display:flex;justify-content:space-between;flex-wrap:wrap;
            .gained_item{width:48%;height:20rem;border:1px solid #f5f5f5;display:flex;background-color:#fff;transition:transform .2s,box-shadow .2s;
                &:hover{transform: translate3d(0,-2px,0);box-shadow: 0 1.5rem 3rem rgba(0,0,0,.1);transition:transform .2s,box-shadow .2s;}
                div:nth-child(1){flex:3;display:flex;align-items:center;justify-content:center;
                    img{width:9rem;height:9rem;}
                }
                div:nth-child(2){flex:5;display:flex;flex-direction:column;box-sizing:border-box;text-align:left;
                    &>span:nth-child(1){margin-top:6rem;box-sizing:border-box;padding: 0 2rem;color: #3d3d3d;font-weight:700;display:flex;position:relative;}
                    &>span:nth-child(2){margin-top:2rem;box-sizing:border-box;padding: 0 2rem;color: #666;}
                }
            }
        }
    }
</style>