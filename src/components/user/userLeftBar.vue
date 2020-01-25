<template>
    <div class="userLeftBar">
        <!--Basic information of users-->
        <div class="userInfo">
            <div class="userDetail">
                <div class="avatar"><img :src="circleUrl"></div>
                <div class="userName">
                    <div class="nickName" :title="nickName">{{nickName}}</div>
                    <div class="index">Ta的个人主页></div>
                </div>
            </div>
            <div class="interact">
                <div class="interaction name">
                    <span>原创</span>
                    <span>粉丝</span>
                    <span>获赞</span>
                    <span>评论</span>
                    <span>访问</span>
                </div>
                <div class="interaction num">
                    <span>84</span>
                    <span>8495</span>
                    <span>12</span>
                    <span>215</span>
                    <span>2万+</span>
                </div>
            </div>
            <div class="record">
                <div class="part1">
                    <span>等级: 5级</span>
                    <span>周排名: 2282</span>
                </div>
                <div class="part2">
                    <span>积分: 1877</span>
                    <span>勋章: 恒</span>
                </div>
            </div>
            <div class="relaction">
                <div><span class="follow">关注</span></div>
                <div><span class="priLetter">私信</span></div>
            </div>
        </div>
        <!--Latest articles-->
        <div class="commonArticles">
            <span class="commonName">最新文章</span>
            <ul class="articles commonUl">
                <li>python专题文件操作</li>
                <li>我终于学会了使用python操作postgresql</li>
                <li>跟着知识追寻者学BeautifulSoup,你学不会打不还口，骂不还手</li>
                <li>那些不懂hystrix秘密</li>
                <li>学会springboot多环境配置方案不用五分钟</li>
            </ul>
        </div>
        <!--commonArticles-->
        <div class="commonArticles">
            <span class="commonName">分类专栏</span>
            <ul class="special commonUl">
                <li>
                    <span class="img">
                        <img :src="circleUrl">
                    </span>
                    <span class="colum">python爬虫</span>
                    <span>3篇</span>
                </li>
                <li>
                    <span class="img">
                        <img :src="circleUrl">
                    </span>
                    <span class="colum">python基础</span>
                    <span>2篇</span>
                </li>
                <li>
                    <span class="img">
                        <img :src="circleUrl">
                    </span>
                    <span class="colum">python数据分析可视化</span>
                    <span>1篇</span>
                </li>
                <li>
                    <span class="img">
                        <img :src="circleUrl">
                    </span>
                    <span class="colum">springboot</span>
                    <span>19篇</span>
                </li>
                <li>
                    <span class="img">
                        <img style="" :src="circleUrl">
                    </span>
                    <span class="colum">springcloud</span>
                    <span>9篇</span>
                </li>
                <div class="develop">展开</div>
            </ul>
        </div>
        <!--File-->
        <div class="commonArticles">
            <span class="commonName">归档</span>
            <ul class="file commonUl">
                <li>
                    <span class="time">2020年1月</span>
                    <span class="amount">11篇</span>
                </li>
                <li>
                    <span class="time">2019年12月</span>
                    <span class="amount">21篇</span>
                </li>
                <li>
                    <span class="time">2019年11月</span>
                    <span class="amount">28篇</span>
                </li>
                <li>
                    <span class="time">2019年10月</span>
                    <span class="amount">23篇</span>
                </li>
                <li>
                    <span class="time">2019年9月</span>
                    <span class="amount">15篇</span>
                </li>
                <li>
                    <span class="time">2018年9月</span>
                    <span class="amount">4篇</span>
                </li>
                <div class="develop">展开</div>
            </ul>
        </div>
        <!--Hot articles-->
        <div class="commonArticles">
            <span class="commonName">热门文章</span>
            <ul class="hotArticles commonUl">
                <li>
                    <span>SQL-小白最佳入门sql查询一</span>
                    <div>阅读数 36176</div>
                </li>
                <li>
                    <span>学会python正则表达式就是这么简答</span>
                    <div>阅读数 4608</div>
                </li>
                <li>
                    <span>SQL-小白最佳入门sql查询二</span>
                    <div>阅读数 2370</div>
                </li>
                <li>
                    <span>我终于懂得如何使用matplotib进行画图</span>
                    <div>阅读数 2497</div>
                </li>
            </ul>
        </div>
        <!--gateway-->
        <div class="extra">
            <div class="QRcode">
               <span class="QRitem">
                   <img :src="circleUrl" alt="" style="width: 10rem;">
               </span>
                <span  class="QRitem">
                   <img :src="circleUrl" alt="" style="width: 10rem;">
               </span>
            </div>
            <div class="QRname">
                <span>MSDN学院</span>
                <span>MSDN招聘</span>
            </div><br><hr><br>
            <div class="contact">
                <icon-svg icon-class="icon-QQ" style="width: 1.8rem;height: 1.8rem;padding-right: .5rem;color: rgb(92,92,92);"/>
                <span style="display: inline-block;flex: 1;">QQ客服</span>
                <icon-svg icon-class="icon-youxiang" style="width: 1.8rem;height: 1.8rem;padding-right: .5rem;color: rgb(92,92,92);"/>
                <span style="display: inline-block;flex: 1;">kefu@msdn.net</span>
            </div>
            <div class="contact">
                <icon-svg icon-class="icon-dianhua" class="number"/>
                <span>400-660-0108</span>
                <icon-svg icon-class="icon-icon" class="forum"/>
                <span>论坛</span>
            </div>
            <br><hr><br>
            <div class="about">
                <span>关于我们</span>
                <el-divider direction="vertical"></el-divider>
                <span>招聘</span>
                <el-divider direction="vertical"></el-divider>
                <span>广告服务</span>
            </div>
            <div class="record">
                <div>京ICP备19004658号 经营性网站备案信息</div>
                <div>公安备案号 11010502030143</div>
                <div>©1999-2020 北京未定义网络技术有限公司</div>
            </div>
            <br><hr><br>
            <div class="record">
                <div>网络110报警服务</div>
                <div>北京互联网违法和不良信息举报中心</div>
                <div>中国互联网举报中心 家长监护 版权申诉</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "userLeftBar",
    data(){
        return{
            nickName: "不脱发的程序员",
            circleUrl: "https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg",
        }
    }
}
</script>

<style lang="less">
    .userLeftBar{
        /*background-color: #fff;*/
        /*background-color: #474747;*/
        /*height: 20rem;*/
    }

    .userInfo{padding: 1.5rem;background-color: #fff;
        .userDetail{display: flex;cursor: pointer;
            .avatar{flex: 1;img{display:inline-block;width: 4rem;height: 4rem;border-radius: 50%;}}
            .userName{display:flex;flex:4;flex-direction:column;padding-left: 1rem;text-align: left;line-height: 2rem;
                .nickName{flex: 1;color: #ffa200;font-size: 1.4rem;&:hover{color: #B66300;}}
                .index{flex: 1;color: #3399ea;font-size: 1rem;}
            }
        }
        .interact{padding: 1.5rem 0;line-height: 2rem;height: 2rem;
            .interaction{display: flex;justify-content:center;span{flex: 1;}}
            .name{font-size: 1.3rem;}
            .num{font-weight: bold;}
        }
        .record{padding: 1.5rem 0 1rem 0;text-align: left;line-height: 2rem;
            div{display: flex;padding:.35rem 0;span{flex: 1;padding-right: .25rem;}}
        }
        .relaction{display: flex;align-items: center;justify-content: space-between;padding: 1.5rem 0;cursor:pointer;border-top:1px solid #EDE9FF; div{flex: 1;}
            .follow{width: 90%;background-color: #ca0c16;display: inline-block;padding: .5rem 0;border-radius: .5rem;color: #fff;
                &:hover{background-color: #BE0E1A;color: olive;}
            }
            .priLetter{width: 90%;background-color: #fff;display: inline-block;padding: .5rem 0;border-radius: .5rem;color: #ca0c16;border: 1px solid #ca0c16;
                &:hover{background-color: #FDE0EC;}
            }
        }
    }
    .commonArticles{background-color: #f5f5f5;margin-top: 1rem;
        .commonName{display: inline-block;width: 100%;text-align: left;background-color: #E9E6E6;color:#3D3D3D;font-weight: bold;padding: 1.5rem;box-sizing: border-box;}
        .commonUl{display: inline-block;margin-top: 1rem;text-align: left;padding: 1.5rem;cursor: pointer;list-style: none;}
        .articles{
            li{line-height: 2rem;display: inline-block;padding-bottom: 1rem;color: #ffa200;&:hover{color: #A86200;}}
        }
        .special{width:90%;
            li{display: flex;padding-bottom: 2rem;color: #ffa200;&:hover{color: #A86200;}
                span{flex: 1;} .colum{flex: 5;line-height: 3rem;}
                img{display: inline-block;width: 3rem;height: 3rem;background-color: #3399ea;}
                span:nth-child(3){color: #858585;font-size: 1.2rem;text-align: right;}
            }
        }
        .file{width:90%;
            li{display: flex;padding-bottom: 2rem;
                .time{flex:1;text-align:left;color: #ffa200;&:hover{color: #A86200;}}
                .amount{flex: 1;text-align: right;color: #858585;font-size: 1.2rem;}
            }
        }
        .hotArticles{width:90%;text-align: left;
            li{display: flex;flex-direction: column;padding-bottom: 1.5rem;
                span{color: #ffa200;&:hover{color: #A86200;}}
                div{font-size: 1.2rem;}
            }
        }
        .develop{text-align: center;font-size: 1.2rem;color: #ffa200;&:hover{color: #A86200;}}
    }
    .extra{margin-top: 1rem;background-color: #fff;padding: 1.5rem;
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