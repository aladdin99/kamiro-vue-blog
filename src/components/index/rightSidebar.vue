<template>
   <div class="rightSidebar">
       <div class="advert" style="color: #C3C3C3;box-shadow: 3px 2px 2px #A5D6B6;border: 1px solid #A5D6B6;width: 98%;">
           W E L C O M E TO H E R E !
       </div>
       <div class="recommend" style="height: 38rem;">
           <el-calendar v-model="dateNote">
           </el-calendar>
       </div>
       <div class="recommend-today">
           <div class="category"><span class="bgColor vertical-line"></span>今日推荐</div>
           <div>
               <div style="display: flex;margin-bottom: 1.5rem;" v-for="item in 10" :key="item">
                   <span style="display: flex;flex: 1;">
                        <el-image
                                style="width: 6rem; height: 4.8rem;border-radius: .5rem;"
                                :src="url"
                                :fit="fits[0]"></el-image>
                   </span>
                   <div class="title">机器推理文本+视觉，跨模态预训练新进展</div>
               </div>
           </div>
       </div>
       <!--gateway-->
<!--       <div class="extra">-->
<!--           <div class="QRcode">-->
<!--               <span class="QRitem">-->
<!--                   <img :src="url" alt="" style="width: 10rem;">-->
<!--               </span>-->
<!--               <span  class="QRitem">-->
<!--                   <img :src="url" alt="" style="width: 10rem;">-->
<!--               </span>-->
<!--           </div>-->
<!--           <div class="QRname">-->
<!--               <span>MSDN学院</span>-->
<!--               <span>MSDN招聘</span>-->
<!--           </div><br><hr><br>-->
<!--           <div class="contact">-->
<!--               <icon-svg icon-class="icon-QQ" style="width: 1.8rem;height: 1.8rem;padding-right: .5rem;color: rgb(92,92,92);"/>-->
<!--               <span style="display: inline-block;flex: 1;">QQ客服</span>-->
<!--               <icon-svg icon-class="icon-youxiang" style="width: 1.8rem;height: 1.8rem;padding-right: .5rem;color: rgb(92,92,92);"/>-->
<!--               <span style="display: inline-block;flex: 1;">kefu@msdn.net</span>-->
<!--           </div>-->
<!--           <div class="contact">-->
<!--               <icon-svg icon-class="icon-dianhua" class="number"/>-->
<!--               <span>400-660-0108</span>-->
<!--               <icon-svg icon-class="icon-icon" class="forum"/>-->
<!--               <span>论坛</span>-->
<!--           </div>-->
<!--           <br><hr><br>-->
<!--           <div class="about">-->
<!--               <span>关于我们</span>-->
<!--               <el-divider direction="vertical"></el-divider>-->
<!--               <span>招聘</span>-->
<!--               <el-divider direction="vertical"></el-divider>-->
<!--               <span>广告服务</span>-->
<!--           </div>-->
<!--           <div class="record">-->
<!--               <div>京ICP备19004658号 经营性网站备案信息</div>-->
<!--               <div>公安备案号 11010502030143</div>-->
<!--               <div>©1999-2020 北京未定义网络技术有限公司</div>-->
<!--           </div>-->
<!--           <br><hr><br>-->
<!--           <div class="record">-->
<!--               <div>网络110报警服务</div>-->
<!--               <div>北京互联网违法和不良信息举报中心</div>-->
<!--               <div>中国互联网举报中心 家长监护 版权申诉</div>-->
<!--           </div>-->
<!--       </div>-->
   </div>
</template>

<script>
    export default {
        name: "rightSidebar",
        data(){
            return{
                fits:['fill','contain','cover','none','scale-down'],
                url:"https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
                dateNote: new Date(),
            }
        },
        methods:{
        },
    }
</script>

<style lang="less">
    /*.rightSidebar{background-color: #f5f6f7;}*/

    .recommend-today{background-color: #FFF;text-align: left;padding:1rem;
        .category{display: flex;height: 2.5rem;align-items:center;padding-bottom: 1rem;font-size: 1.6rem;}
        .vertical-line{display: inline-block;margin-right: .5rem;width: 2.5px;height: 1.8rem;}
        .title{display:flex;width:280px;padding: 0 .5rem;font-size: 14px;color: #3d3d3d;font-weight: bold;cursor: pointer;line-height: 22px;white-space:normal;
            overflow: hidden;display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow-wrap: break-word;}//overflow-wrap_控制超出换行
    }

    .el-calendar-table .el-calendar-day{height: 4rem!important;}


    .extra{margin-top: 2rem;background-color: #fff;padding: 1.5rem;
        .QRcode{display: flex;margin-top: 1.5rem;
            .QRitem{display: flex;flex: 1;align-items:center;justify-content:center;
                .el-image{width: 10rem; height: 7rem;border-radius: .5rem;}
            }
        }
        .QRname{display: flex;align-content:space-between;align-items:center;padding: .25rem 0 .8rem 0;
            span{display: flex;flex: 1;align-items:center;justify-content:center;}
        }
        .contact{display: flex;text-align: left;padding-top: .8rem;
            .number{width: 1.6rem;height: 1.6rem;padding-right: .5rem;color: rgb(92,92,92);}
            .forum{width: 2rem;height: 2rem;padding-right: .5rem;color: rgb(92,92,92);}
            span{display: inline-block;flex: 1;}
        }
        .about{font-weight: bold;line-height: 2.1rem;padding-bottom: .5rem;}
        .record{text-align: left;line-height: 2.1rem;}
    }
    .el-divider--horizontal{margin-top: 0.5rem!important;}
</style>