<template>
    <div class="leftSidebar">
        <ul class="listClass">
            <li v-for="(item,index) in leftBarData" :key="index" :class="{'inline':(item.flag)}" @click="nextInfo(index)">{{item.name}}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        name: "leftSidebar",
        data() {
            return {
                leftBarData:[{name:"推荐",flag:true},{name:"动态",flag:false},{name:"程序人生",flag:false},
                    {name:"Python",flag:false},{name:"Java",flag:false},{name:"前端",flag:false},{name:"区块链",flag:false},
                    {name:"人工智能",flag:false},{name:"云计算/大数据",flag:false},{name:"其它",flag:false}],
            }
        },
        methods:{
            nextInfo(index){
                this.leftBarData.forEach(item=>{
                    item.flag = false;
                });
                // this.leftBarData[index].flag = true;
                // this.leftBarData[index].flag = true;
                // this.leftBarData[index].splice(1,1,true);
                // this.$set(this.leftBarData[index],'flag',true);
                // this.leftBarData[index] = Object.assign(this.leftBarData[index],{
                //     flag: true
                // })
                // this.$set(this.leftBarData[index],"flag",true)
                // this.vm.$set( this.leftBarData[index], "flag", true )
                // delete this.leftBarData[index].flag;
                this.leftBarData[index].flag = true;
            }
        },
        // created() {(1)通过添加对象内的元素 为什么数据更新了，视图却不更新
        //     this.leftBarData.forEach((item,index)=>{
        //         item.flag = !index?true:false;
        //         // item.push({"flag":false});
        //         // this.leftBarData[index] = Object.assign(item, {
        //         //     flag: !index?true:false
        //         // });
        //     });
        //     // console.log(this.leftBarData);
        // }
    }
</script>

<style lang="less">
    *{margin: 0;padding: 0;}
    .listClass{background-color: #fff;display: inline-block;list-style: none;cursor: pointer;
        li{padding: 10px 5px;}
        li:hover{background-color: #f44444;color: #fff;}
        .inline{background-color: #f44444;color: #fff;}
    }
</style>